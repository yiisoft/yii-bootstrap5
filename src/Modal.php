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
 *     ->title('<h2>Hello world</h2>')
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
     * The additional css class of large modal
     */
    public const SIZE_LARGE = 'modal-lg';

    /**
     * The additional css class of small modal
     */
    public const SIZE_SMALL = 'modal-sm';

    /**
     * The additional css class of default modal
     */
    public const SIZE_DEFAULT = '';

    private string $title = '';
    private array $titleOptions = [];
    private array $headerOptions = [];
    private array $bodyOptions = [];
    private string $footer = '';
    private array $footerOptions = [];
    private string $size = '';
    private array $closeButton = [];
    private bool $closeButtonEnabled = true;
    private array $toggleButton = [];
    private bool $toggleButtonEnabled = true;
    private array $options = [];
    private bool $encodeTags = false;

    public function begin(): string
    {
        parent::begin();

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-modal";
        }

        if ($this->encodeTags === false) {
            $this->options['encode'] = false;
        }

        $this->initOptions();

        return
            $this->renderToggleButton() . "\n" .
            Html::beginTag('div', $this->options) . "\n" .
            Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n" .
            Html::beginTag('div', ['class' => 'modal-content']) . "\n" .
            $this->renderHeader() . "\n" .
            $this->renderBodyBegin() . "\n";
    }

    protected function run(): string
    {
        return
            "\n" . $this->renderBodyEnd() .
            "\n" . $this->renderFooter() .
            "\n" . Html::endTag('div') . // modal-content
            "\n" . Html::endTag('div') . // modal-dialog
            "\n" . Html::endTag('div');
    }

    /**
     * Body options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
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
     * @return $this
     */
    public function closeButton(array $value): self
    {
        $new = clone $this;
        $new->closeButton = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @return $this
     */
    public function withoutCloseButton(): self
    {
        $new = clone $this;
        $new->closeButtonEnabled = false;

        return $new;
    }

    /**
     * The footer content in the modal window.
     *
     * @param string $value
     *
     * @return $this
     */
    public function footer(string $value): self
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function title(string $value): self
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
     * @return $this
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
     * @return $this
     */
    public function toggleButton(array $value): self
    {
        $new = clone $this;
        $new->toggleButton = $value;

        return $new;
    }

    /**
     * Disable toggle button.
     *
     * @return $this
     */
    public function withoutToggleButton(): self
    {
        $new = clone $this;
        $new->toggleButtonEnabled = false;

        return $new;
    }

    /**
     * The modal size. Can be {@see SIZE_LARGE} or {@see SIZE_SMALL}, or null for default.
     *
     * @param string $value
     *
     * @return $this
     */
    public function size(string $value): self
    {
        $new = clone $this;
        $new->size = $value;

        return $new;
    }

    /**
     * Allows you to enable the encoding tags html.
     *
     * @return self
     */
    public function encodeTags(): self
    {
        $new = clone $this;
        $new->encodeTags = true;

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
        $button = $this->renderCloseButton();

        if ($this->title !== '') {
            Html::addCssClass($this->titleOptions, ['titleOptions' => 'modal-title']);
        }

        $header = ($this->title === '') ? '' : Html::tag('h5', $this->title, $this->titleOptions);

        if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        }

        Html::addCssClass($this->headerOptions, ['headerOptions' => 'modal-header']);

        if ($this->encodeTags === false) {
            $this->headerOptions['encode'] = false;
        }

        return Html::div($header, $this->headerOptions);
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
        Html::addCssClass($this->bodyOptions, ['widget' => 'modal-body']);

        if ($this->encodeTags === false) {
            $this->bodyOptions['encode'] = false;
        }

        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the modal body.
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        return Html::endTag('div');
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
        if ($this->footer === '') {
            return '';
        }

        Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);

        if ($this->encodeTags === false) {
            $this->footerOptions['encode'] = false;
        }

        return Html::div($this->footer, $this->footerOptions);
    }

    /**
     * Renders the toggle button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderToggleButton(): ?string
    {
        if ($this->toggleButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->toggleButton, 'label', 'Show');

        if ($this->encodeTags === false) {
            $this->toggleButton['encode'] = false;
        }

        return Html::tag($tag, $label, $this->toggleButton);
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderCloseButton(): ?string
    {
        if ($this->closeButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->closeButton, 'label', Html::span('&times;', [
            'aria-hidden' => 'true',
        ]));

        if ($this->encodeTags === false) {
            $this->closeButton['encode'] = false;
        }

        return Html::tag($tag, $label, $this->closeButton);
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    private function initOptions(): void
    {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
            'aria-hidden' => 'true',
        ], $this->options);

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'modal']);

        $this->titleOptions = array_merge([
            'id' => $this->options['id'] . '-label',
        ], $this->titleOptions);

        if (!isset($this->options['aria-label'], $this->options['aria-labelledby']) && $this->title !== '') {
            $this->options['aria-labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButtonEnabled !== false) {
            Html::addCssClass($this->closeButton, ['closeButton' => 'close']);

            $this->closeButton = array_merge([
                'data-bs-dismiss' => 'modal',
                'type' => 'button',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== []) {
            $this->toggleButton = array_merge([
                'data-bs-toggle' => 'modal',
                'type' => 'button',
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-bs-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-bs-target'] = '#' . $this->options['id'];
            }
        }
    }
}
