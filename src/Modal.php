<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the {@see begin()} and {@see end()} calls within the
 * modal window:
 *
 * ```php
 * Modal::widget()
 *     ->title('Hello world')
 *     ->toggleButton(['label' => 'click me'])
 *     ->begin();
 *
 * echo 'Say hello...';
 *
 * echo Modal::end();
 * ```
 */
final class Modal extends Widget
{
    /**
     * Size classes
     */
    public const SIZE_SMALL = 'modal-sm';
    public const SIZE_DEFAULT = null;
    public const SIZE_LARGE = 'modal-lg';
    public const SIZE_EXTRA_LARGE = 'modal-xl';

    /**
     * Fullsceen classes
     */
    public const FULLSCREEN_ALWAYS = 'modal-fullscreen';
    public const FULLSCREEN_BELOW_SM = 'modal-fullscreen-sm-down';
    public const FULLSCREEN_BELOW_MD = 'modal-fullscreen-md-down';
    public const FULLSCREEN_BELOW_LG = 'modal-fullscreen-lg-down';
    public const FULLSCREEN_BELOW_XL = 'modal-fullscreen-xl-down';
    public const FULLSCREEN_BELOW_XXL = 'modal-fullscreen-xxl-down';

    private ?string $title = null;
    private array $titleOptions = [];
    private array $headerOptions = [];
    private array $dialogOptions = [];
    private array $contentOptions = [];
    private array $bodyOptions = [];
    private ?string $footer = null;
    private array $footerOptions = [];
    private ?string $size = self::SIZE_DEFAULT;
    private ?array $closeButton = ['class' => 'btn-close'];
    private ?array $toggleButton = [];
    private array $options = [];
    private bool $encodeTags = false;
    private bool $fade = true;
    private bool $staticBackdrop = false;
    private bool $scrollable = false;
    private bool $centered = false;
    private ?string $fullscreen = null;

    public function getId(?string $suffix = '-modal'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    public function getTitleId(): string
    {
        return $this->titleOptions['id'] ?? $this->getId() . '-label';
    }

    public function begin(): string
    {
        parent::begin();

        $options = $this->prepareOptions();
        $dialogOptions = $this->prepareDialogOptions();
        $contentOptions = $this->contentOptions;
        $contentTag = ArrayHelper::remove($contentOptions, 'tag', 'div');
        $dialogTag = ArrayHelper::remove($dialogOptions, 'tag', 'div');

        Html::addCssClass($contentOptions, ['modal-content']);

        return
            $this->renderToggleButton() .
            Html::openTag('div', $options) .
            Html::openTag($dialogTag, $dialogOptions) .
            Html::openTag($contentTag, $contentOptions) .
            $this->renderHeader() .
            $this->renderBodyBegin();
    }

    protected function run(): string
    {
        $contentTag = ArrayHelper::getValue($this->contentOptions, 'tag', 'div');
        $dialogTag = ArrayHelper::getValue($this->dialogOptions, 'tag', 'div');

        return
            $this->renderBodyEnd() .
            $this->renderFooter() .
            Html::closeTag($contentTag) . // modal-content
            Html::closeTag($dialogTag) . // modal-dialog
            Html::closeTag('div');
    }

    /**
     * Prepare options for modal layer
     *
     * @return array
     */
    private function prepareOptions(): array
    {
        $options = array_merge([
            'role' => 'dialog',
            'tabindex' => -1,
            'aria-hidden' => 'true',
        ], $this->options);

        $options['id'] = $this->getId();

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, ['widget' => 'modal']);

        if ($this->fade) {
            Html::addCssClass($options, ['animation' => 'fade']);
        }

        if (!isset($options['aria-label'], $options['aria-labelledby']) && !empty($this->title)) {
            $options['aria-labelledby'] = $this->getTitleId();
        }

        if ($this->staticBackdrop) {
            $options['data-bs-backdrop'] = 'static';
        }

        return $options;
    }

    /**
     * Prepare options for dialog layer
     *
     * @return array
     */
    private function prepareDialogOptions(): array
    {
        $options = $this->dialogOptions;
        $classNames = ['modal-dialog'];

        if ($this->size) {
            $classNames[] = $this->size;
        }

        if ($this->fullscreen) {
            $classNames[] = $this->fullscreen;
        }

        if ($this->scrollable) {
            $classNames[] = 'modal-dialog-scrollable';
        }

        if ($this->centered) {
            $classNames[] = 'modal-dialog-centered';
        }

        Html::addCssClass($options, $classNames);

        return $options;
    }

    /**
     * Dialog layer options
     *
     * @param array $options
     *
     * @return self
     */
    public function dialogOptions(array $options): self
    {
        $new = clone $this;
        $new->dialogOptions = $options;

        return $new;
    }

    /**
     * Set options for content layer
     *
     * @param array $options
     *
     * @return self
     */
    public function contentOptions(array $options): self
    {
        $new = clone $this;
        $new->contentOptions = $options;

        return $new;
    }

    /**
     * Body options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function bodyOptions(array $value): self
    {
        $new = clone $this;
        $new->bodyOptions = $value;

        return $new;
    }

    /**
     * The options for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see closeButtonEnabled} is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag. Please refer to the
     * [Modal plugin help](http://getbootstrap.com/javascript/#modals) for the supported HTML attributes.
     *
     * @param array $value
     *
     * @return self
     */
    public function closeButton(?array $value): self
    {
        $new = clone $this;
        $new->closeButton = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @return self
     */
    public function withoutCloseButton(): self
    {
        return $this->closeButton(null);
    }

    /**
     * The footer content in the modal window.
     *
     * @param string $value
     *
     * @return self
     */
    public function footer(?string $value): self
    {
        $new = clone $this;
        $new->footer = $value;

        return $new;
    }

    /**
     * Additional footer options.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function footerOptions(array $value): self
    {
        $new = clone $this;
        $new->footerOptions = $value;

        return $new;
    }

    /**
     * Additional header options.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerOptions(array $value): self
    {
        $new = clone $this;
        $new->headerOptions = $value;

        return $new;
    }

    /**
     * @param array $value the HTML attributes for the widget container tag. The following special options are
     * recognized.
     *
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * The title content in the modal window.
     *
     * @param string $value
     *
     * @return self
     */
    public function title(?string $value): self
    {
        $new = clone $this;
        $new->title = $value;

        return $new;
    }

    /**
     * Additional title options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function titleOptions(array $value): self
    {
        $new = clone $this;
        $new->titleOptions = $value;

        return $new;
    }

    /**
     * The options for rendering the toggle button tag.
     *
     * The toggle button is used to toggle the visibility of the modal window. If {@see toggleButtonEnabled} is false,
     * no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag. Please refer to the
     * [Modal plugin help](http://getbootstrap.com/javascript/#modals) for the supported HTML attributes.
     *
     * @param array $value
     *
     * @return self
     */
    public function toggleButton(?array $value): self
    {
        $new = clone $this;
        $new->toggleButton = $value;

        return $new;
    }

    /**
     * Disable toggle button.
     *
     * @return self
     */
    public function withoutToggleButton(): self
    {
        return $this->toggleButton(null);
    }

    /**
     * The modal size. Can be {@see SIZE_LARGE} or {@see SIZE_SMALL}, or null for default.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#optional-sizes
     */
    public function size(?string $value): self
    {
        $new = clone $this;
        $new->size = $value;

        return $new;
    }

    /**
     * Enable/disable static backdrop
     *
     * @param bool $value
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#static-backdrop
     */
    public function staticBackdrop(bool $value = true): self
    {
        if ($value === $this->staticBackdrop) {
            return $this;
        }

        $new = clone $this;
        $new->staticBackdrop = $value;

        return $new;
    }

    /**
     * Enable/Disable scrolling long content
     *
     * @param bool $scrollable
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#scrolling-long-content
     */
    public function scrollable(bool $scrollable = true): self
    {
        if ($scrollable === $this->scrollable) {
            return $this;
        }

        $new = clone $this;
        $new->scrollable = $scrollable;

        return $new;
    }

    /**
     * Enable/Disable vertically centered
     *
     * @param bool $centered
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#vertically-centered
     */
    public function centered(bool $centered = true): self
    {
        if ($centered === $this->centered) {
            return $this;
        }

        $new = clone $this;
        $new->centered = $centered;

        return $new;
    }

    /**
     * Set/remove fade animation
     *
     * @param bool $fade
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#remove-animation
     */
    public function fade(bool $fade = true): self
    {
        $new = clone $this;
        $new->fade = $fade;

        return $new;
    }

    /**
     * Enable/disable fullscreen mode
     *
     * @param string|null $fullscreen
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#fullscreen-modal
     */
    public function fullscreen(?string $fullscreen): self
    {
        $new = clone $this;
        $new->fullscreen = $fullscreen;

        return $new;
    }

    /**
     * Renders the header HTML markup of the modal.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderHeader(): string
    {
        $title = (string) $this->renderTitle();
        $button = (string) $this->renderCloseButton();

        if ($button === '' && $title === '') {
            return '';
        }

        $options = $this->headerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $content = $title . $button;

        Html::addCssClass($options, ['headerOptions' => 'modal-header']);

        return Html::tag($tag, $content, $options)->encode(false)->render();
    }

    /**
     * Render title HTML markup
     *
     * @return string|null
     */
    private function renderTitle(): ?string
    {
        if ($this->title === null) {
            return '';
        }

        $options = $this->titleOptions;
        $options['id'] = $this->getTitleId();
        $tag = ArrayHelper::remove($options, 'tag', 'h5');
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);

        Html::addCssClass($options, ['modal-title']);

        return Html::tag($tag, $this->title, $options)->encode($encode)->render();
    }

    /**
     * Renders the opening tag of the modal body.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderBodyBegin(): string
    {
        $options = $this->bodyOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        Html::addCssClass($options, ['widget' => 'modal-body']);

        return Html::openTag($tag, $options);
    }

    /**
     * Renders the closing tag of the modal body.
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        $tag = ArrayHelper::getValue($this->bodyOptions, 'tag', 'div');

        return Html::closeTag($tag);
    }

    /**
     * Renders the HTML markup for the footer of the modal.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderFooter(): string
    {
        if ($this->footer === null) {
            return '';
        }

        $options = $this->footerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);
        Html::addCssClass($options, ['widget' => 'modal-footer']);

        return Html::tag($tag, $this->footer, $options)->encode($encode)->render();
    }

    /**
     * Renders the toggle button.
     *
     * @param array $options additional options for current button
     *
     * @throws JsonException
     *
     * @return string|null the rendering result
     */
    public function renderToggleButton(array $options = []): ?string
    {
        if ($this->toggleButton === null && count($options) === 0) {
            return null;
        }

        $options = array_merge(
            [
                'data-bs-toggle' => 'modal',
            ],
            $this->toggleButton,
            $options
        );

        $tag = ArrayHelper::remove($options, 'tag', 'button');
        $label = ArrayHelper::remove($options, 'label', 'Show');
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);

        if ($tag === 'button' && !isset($options['type'])) {
            $options['type'] = 'button';
        }

        if (!isset($options['data-bs-target'])) {
            $target = (string) $this->getId();

            if ($tag === 'a') {
                if (!isset($options['href'])) {
                    $options['href'] = '#' . $target;
                } else {
                    $options['data-bs-target'] = '#' . $target;
                }
            } else {
                $options['data-bs-target'] = '#' . $target;
            }
        }

        return Html::tag($tag, $label, $options)->encode($encode)->render();
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string|null the rendering result
     *
     * @link https://getbootstrap.com/docs/5.1/components/close-button/
     */
    private function renderCloseButton(): ?string
    {
        if ($this->closeButton === null) {
            return null;
        }

        $options = array_merge([
            'data-bs-dismiss' => 'modal',
            'aria-label' => 'Close',
        ], $this->closeButton);
        $tag = ArrayHelper::remove($options, 'tag', 'button');
        $label = ArrayHelper::remove($options, 'label', '');
        $encode = ArrayHelper::remove($options, 'encode', !empty($label));

        if ($tag === 'button' && !isset($options['type'])) {
            $options['type'] = 'button';
        }

        return Html::tag($tag, $label, $options)->encode($encode)->render();
    }
}
