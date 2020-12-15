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

    private ?string $title = null;
    private array $titleOptions = [];
    private array $headerOptions = [];
    private array $bodyOptions = [];
    private ?string $footer = null;
    private array $footerOptions = [];
    private ?string $size = null;
    private array $closeButton = [];
    private bool $closeButtonEnabled = true;
    private array $toggleButton = [];
    private bool $toggleButtonEnabled = true;
    private array $options = [];

    public function begin(): ?string
    {
        parent::begin();

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-modal";
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
        $this->registerPlugin('modal', $this->options);

        return
            "\n" . $this->renderBodyEnd() .
            "\n" . $this->renderFooter() .
            "\n" . Html::endTag('div') . // modal-content
            "\n" . Html::endTag('div') . // modal-dialog
            "\n" . Html::endTag('div');
    }

    /**
     * Renders the header HTML markup of the modal.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderHeader(): string
    {
        $button = $this->renderCloseButton();

        if ($this->title !== null) {
            Html::addCssClass($this->titleOptions, ['widget' => 'modal-title']);
        }

        $header = ($this->title === null) ? '' : Html::tag('h5', $this->title, $this->titleOptions);

        if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        }

        Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);

        return Html::div($header, $this->headerOptions);
    }

    /**
     * Renders the opening tag of the modal body.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderBodyBegin(): string
    {
        Html::addCssClass($this->bodyOptions, ['widget' => 'modal-body']);

        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the modal body.
     *
     * @return string the rendering result
     */
    protected function renderBodyEnd(): string
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
    protected function renderFooter(): ?string
    {
        if ($this->footer === null) {
            return null;
        }

        Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
        return Html::div($this->footer, $this->footerOptions);
    }

    /**
     * Renders the toggle button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderToggleButton(): ?string
    {
        if ($this->toggleButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->toggleButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->toggleButton, 'label', 'Show');

        return Html::tag($tag, $label, $this->toggleButton);
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderCloseButton(): ?string
    {
        if ($this->closeButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->closeButton, 'label', Html::span('&times;', [
            'aria-hidden' => 'true',
        ]));

        return Html::tag($tag, $label, $this->closeButton);
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    protected function initOptions(): void
    {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
            'aria-hidden' => 'true',
        ], $this->options);

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->getEnableClientOptions() !== false) {
            $this->clientOptions(array_merge(['show' => false], $this->getClientOptions()));
        }

        $this->titleOptions = array_merge([
            'id' => $this->options['id'] . '-label',
        ], $this->titleOptions);

        if (!isset($this->options['aria-label'], $this->options['aria-labelledby']) && $this->title !== null) {
            $this->options['aria-labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButtonEnabled !== false) {
            $this->closeButton = array_merge([
                'data-bs-dismiss' => 'modal',
                'class' => 'close',
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

    /**
     * Body options.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function bodyOptions(array $value): self
    {
        $this->bodyOptions = $value;

        return $this;
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
        $this->closeButton = $value;

        return $this;
    }

    /**
     * Enable/Disable close button.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function closeButtonEnabled(bool $value): self
    {
        $this->closeButtonEnabled = $value;

        return $this;
    }

    /**
     * The footer content in the modal window.
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function footer(?string $value): self
    {
        $this->footer = $value;

        return $this;
    }

    /**
     * Additional footer options.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function footerOptions(array $value): self
    {
        $this->footerOptions = $value;

        return $this;
    }

    /**
     * Additional header options.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerOptions(array $value): self
    {
        $this->headerOptions = $value;

        return $this;
    }

    /**
     * @param array $value the HTML attributes for the widget container tag. The following special options are
     * recognized.
     *
     * @return $this
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * The title content in the modal window.
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function title(?string $value): self
    {
        $this->title = $value;

        return $this;
    }

    /**
     * Additional title options.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function titleOptions(array $value): self
    {
        $this->titleOptions = $value;

        return $this;
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
        $this->toggleButton = $value;

        return $this;
    }

    /**
     * Enable/Disable toggle button.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function toggleButtonEnabled(bool $value): self
    {
        $this->toggleButtonEnabled = $value;

        return $this;
    }

    /**
     * The modal size. Can be {@see SIZE_LARGE} or {@see SIZE_SMALL}, or null for default.
     *
     * @param string|null $value
     *
     * @return $this
     */
    public function size(?string $value): self
    {
        $this->size = $value;

        return $this;
    }
}
