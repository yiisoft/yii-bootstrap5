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
    /**
     * @var string the body content in the alert component. Note that anything between
     * the {@see begin()} and {@see end()} calls of the Toast widget will also be treated
     * as the body content, and will be rendered before this.
     */
    private string $body = '';
    /**
     * @var string The title content in the toast.
     */
    private string $title = '';
    /**
     * @var string The footer content in the toast.
     */
    private string $footer = '';
    /**
     * @var string The date time the toast message references to.
     * This will be formatted as relative time (via formatter component). It will be omitted if
     * set to `false` (default).
     */
    private string $dateTime = '';
    /**
     * @var array the options for rendering the close button tag.
     * The close button is displayed in the header of the toast. Clicking on the button will hide the toast.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Toast documentation](https://getbootstrap.com/docs/5.0/components/toasts/)
     * for the supported HTML attributes.
     */
    private array $closeButton = [];
    /**
     * @var array additional title options
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'strong'.
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public array $titleOptions = [];
    /**
     * @var array additional date time part options
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'small'.
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    private array $dateTimeOptions = [];
    /**
     * @var array additional header options
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    private array $headerOptions = [];
    /**
     * @var array body options
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    private array $bodyOptions = [];
    /**
     * @var array options
     */
    private array $options = [];
    /**
     * @var array footer options
     *
     * @see Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    private array $footerOptions = [];

    public function begin(): ?string
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
        $this->registerPlugin('toast', $this->options);

        return $this->renderBodyEnd() . Html::endTag('div');
    }

    /**
     * Renders the header HTML markup of the toast.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    protected function renderHeader(): string
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
    protected function renderBodyBegin(): string
    {
        Html::addCssClass($this->bodyOptions, ['widget' => 'toast-body']);
        return Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the toast body.
     *
     * @return string the rendering result
     */
    protected function renderBodyEnd(): string
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
    protected function renderCloseButton(): ?string
    {
        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->closeButton, 'label', Html::tag('span', '&times;', [
            'aria-hidden' => 'true',
        ]));

        return Html::tag($tag, "\n" . $label . "\n", $this->closeButton);
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    protected function initOptions(): void
    {
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
        $this->bodyOptions = $value;

        return $this;
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
        $this->closeButton = $value;

        return $this;
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
        $this->dateTime = $value;

        return $this;
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
        $this->dateTimeOptions = $value;

        return $this;
    }

    /**
     * The footer content in the toast window.
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
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * The title content in the toast window.
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
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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
}
