<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the {@see begin()} and {@see end()} calls within the
 * modal window:
 *
 * ```php
 * Modal::begin()
 *     ->title('<h2>Hello world</h2>')
 *     ->toggleButton(['label' => 'click me'])
 *     ->start();
 *
 * echo 'Say hello...';
 *
 * echo Modal::end();
 * ```
 */
class Modal extends Widget
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

    public function start(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-modal";
        }

        $this->initOptions();

        $htmlStart = '';

        $htmlStart .= $this->renderToggleButton() . "\n";
        $htmlStart .= Html::beginTag('div', $this->options) . "\n";
        $htmlStart .= Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        $htmlStart .= Html::beginTag('div', ['class' => 'modal-content']) . "\n";
        $htmlStart .= $this->renderHeader() . "\n";
        $htmlStart .= $this->renderBodyBegin() . "\n";

        return $htmlStart;
    }

    protected function run(): string
    {
        $htmlRun = '';

        $htmlRun .= "\n" . $this->renderBodyEnd();
        $htmlRun .= "\n" . $this->renderFooter();
        $htmlRun .= "\n" . Html::endTag('div'); // modal-content
        $htmlRun .= "\n" . Html::endTag('div'); // modal-dialog
        $htmlRun .= "\n" . Html::endTag('div');

        $this->registerPlugin('modal', $this->options);

        return $htmlRun;
    }

    /**
     * Renders the header HTML markup of the modal.
     *
     * @return string the rendering result
     */
    protected function renderHeader(): string
    {
        $button = $this->renderCloseButton();

        if ($this->title !== null) {
            Html::addCssClass($this->titleOptions, ['widget' => 'modal-title']);
            $header = Html::tag('h5', $this->title, $this->titleOptions);
        } else {
            $header = '';
        }

        if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        }

        Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);

        return Html::tag('div', "\n" . $header . "\n", $this->headerOptions);
    }

    /**
     * Renders the opening tag of the modal body.
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
     * @return string the rendering result
     */
    protected function renderFooter(): ?string
    {
        if ($this->footer === null) {
            return null;
        }

        Html::addCssClass($this->footerOptions, ['widget' => 'modal-footer']);
        return Html::tag('div', "\n" . $this->footer . "\n", $this->footerOptions);
    }

    /**
     * Renders the toggle button.
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
     * @return string the rendering result
     */
    protected function renderCloseButton(): ?string
    {
        if ($this->closeButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->closeButton, 'label', Html::tag('span', '&times;', [
            'aria-hidden' => 'true'
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
        $this->options = \array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
            'aria-hidden' => 'true'
        ], $this->options);

        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->getEnableClientOptions() !== false) {
            $this->clientOptions(\array_merge(['show' => false], $this->getClientOptions()));
        }

        $this->titleOptions = \array_merge([
            'id' => $this->options['id'] . '-label'
        ], $this->titleOptions);

        if (!isset($this->options['aria-label'], $this->options['aria-labelledby']) && $this->title !== null) {
            $this->options['aria-labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButtonEnabled !== false) {
            $this->closeButton = \array_merge([
                'data-dismiss' => 'modal',
                'class' => 'close',
                'type' => 'button',
            ], $this->closeButton);
        }

        if ($this->toggleButton !== array()) {
            $this->toggleButton = \array_merge([
                'data-toggle' => 'modal',
                'type' => 'button'
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
    }

    /**
     * Body options.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     */
    public function closeButton(array $value): self
    {
        $this->closeButton = $value;

        return $this;
    }

    /**
     * Enable/Disable close button.
     */
    public function closeButtonEnabled(bool $value): self
    {
        $this->closeButtonEnabled = $value;

        return $this;
    }

    /**
     * The footer content in the modal window.
     */
    public function footer(?string $value): self
    {
        $this->footer = $value;

        return $this;
    }

    /**
     * Additional footer options.
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
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerOptions(array $value): self
    {
        $this->headerOptions = $value;

        return $this;
    }

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized.
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
     */
    public function toggleButton(array $value): self
    {
        $this->toggleButton = $value;

        return $this;
    }

    /**
     * Enable/Disable toggle button.
     */
    public function toggleButtonEnabled(bool $value): self
    {
        $this->toggleButtonEnabled = $value;

        return $this;
    }

    /**
     * The modal size. Can be {@see SIZE_LARGE} or {@see SIZE_SMALL}, or null for default.
     */
    public function size(?string $value): self
    {
        $this->size = $value;

        return $this;
    }
}
