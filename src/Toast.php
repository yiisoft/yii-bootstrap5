<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;

/**
 * Toasts renders a toast bootstrap widget.
 *
 * For example,
 *
 * ```php
  * echo Toast::widget()
 *     ->title('Hello world!')
 *     ->dateTime('a minute ago')
 *     ->body('Say hello...')
 *     ->begin();
 * ```
 *
 * The following example will show the content enclosed between the {@see begin()}
 * and {@see end()} calls within the toast box:
 *
 * ```php
 * echo Toast::widget()
 *     ->title('Hello world!')
 *     ->dateTime('a minute ago')
 *     ->begin();
 *
 * echo 'Say hello...';
 *
 * echo Toast::end();
 * ```
 *
 * @see https://getbootstrap.com/docs/5.0/components/toasts/
 */
final class Toast extends Widget
{
    private string $body = '';
    private string $title = '';
    private string $dateTime = '';
    private array $closeButton = [];
    private array $titleOptions = [];
    private array $dateTimeOptions = [];
    private array $headerOptions = [];
    private array $bodyOptions = [];
    private array $options = [];
    private bool $encodeTags = false;

    public function begin(): string
    {
        parent::begin();

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-toast";
        }

        $this->initOptions();

        return
            Html::beginTag('div', $this->options) . "\n" .
            $this->renderHeader() . "\n" .
            $this->renderBodyBegin();
    }

    protected function run(): string
    {
        return $this->renderBodyEnd() . Html::endTag('div');
    }

    /**
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value Body options.
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
     * The close button is displayed in the header of the toast window. Clicking on the button will hide the toast
     * window. If {@see closeButtonEnabled} is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag. Please refer to the
     * [Toast plugin help](https://getbootstrap.com/docs/5.0/components/toasts/) for the supported HTML attributes.
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
     * The date/time content in the toast window.
     *
     * @param string $value
     *
     * @return $this
     */
    public function dateTime(string $value): self
    {
        $new = clone $this;
        $new->dateTime = $value;

        return $new;
    }

    /**
     * Additional DateTime options.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function dateTimeOptions(array $value): self
    {
        $new = clone $this;
        $new->dateTimeOptions = $value;

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
     * The title content in the toast window.
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
     * Renders the header HTML markup of the toast.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderHeader(): string
    {
        $button = $this->renderCloseButton();
        $tag = ArrayHelper::remove($this->titleOptions, 'tag', 'strong');
        Html::addCssClass($this->titleOptions, ['widget' => 'me-auto']);
        $title = Html::tag($tag, $this->title, $this->titleOptions);

        if ($this->dateTime !== '') {
            $tag = ArrayHelper::remove($this->dateTimeOptions, 'tag', 'small');
            $title .= "\n" . Html::tag($tag, $this->dateTime, $this->dateTimeOptions);
        }

        $title .= "\n" . $button;

        Html::addCssClass($this->headerOptions, ['widget' => 'toast-header']);
        return Html::div("\n" . $title . "\n", $this->headerOptions);
    }

    /**
     * Renders the opening tag of the toast body.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderBodyBegin(): string
    {
        Html::addCssClass($this->bodyOptions, ['widget' => 'toast-body']);
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the toast body.
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        return $this->body . "\n" . Html::endTag('div');
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderCloseButton(): string
    {
        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove(
            $this->closeButton,
            'label',
            Html::tag('span', '&times;', ['aria-hidden' => 'true', 'encode' => false])
        );

        return Html::tag($tag, "\n" . $label . "\n", $this->closeButton);
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    private function initOptions(): void
    {
        if ($this->encodeTags === false) {
            $this->bodyOptions['encode'] = false;
            $this->closeButton['encode'] = false;
            $this->dateTimeOptions['encode'] = false;
            $this->headerOptions['encode'] = false;
            $this->options['encode'] = false;
            $this->titleOptions['encode'] = false;
        }

        Html::addCssClass($this->options, ['widget' => 'toast']);

        $this->closeButton = array_merge([
            'aria' => ['label' => 'Close'],
            'data' => ['bs-dismiss' => 'toast'],
            'class' => ['widget' => 'btn-close'],
            'type' => 'button',
        ], $this->closeButton);

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'alert';
        }

        if (!isset($this->options['aria']) && !isset($this->options['aria-live'])) {
            $this->options['aria'] = [
                'live' => 'assertive',
                'atomic' => 'true',
            ];
        }
    }
}
