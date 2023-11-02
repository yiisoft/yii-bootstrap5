<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

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
    use CloseButtonTrait;

    private string $body = '';
    private string $title = '';
    private string $dateTime = '';
    private array $titleOptions = [];
    private array $dateTimeOptions = [];
    private array $headerOptions = [];
    private array $bodyOptions = [];
    private array $options = [];
    private bool $encodeTags = false;

    public function getId(?string $suffix = '-toast'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function toggleComponent(): string
    {
        return 'toast';
    }

    public function begin(): string
    {
        parent::begin();

        $this->initOptions();

        return
            Html::openTag('div', $this->options) . "\n" .
            $this->renderHeader() . "\n" .
            $this->renderBodyBegin();
    }

    public function render(): string
    {
        return $this->renderBodyEnd() . Html::closeTag('div');
    }

    /**
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value Body options.
     */
    public function bodyOptions(array $value): self
    {
        $new = clone $this;
        $new->bodyOptions = $value;

        return $new;
    }

    /**
     * The date/time content in the toast window.
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
     */
    public function titleOptions(array $value): self
    {
        $new = clone $this;
        $new->titleOptions = $value;

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
        $button = $this->renderCloseButton(true);
        $tag = ArrayHelper::remove($this->titleOptions, 'tag', 'strong');
        Html::addCssClass($this->titleOptions, ['widget' => 'me-auto']);
        $title = Html::tag($tag, $this->title, $this->titleOptions)
            ->encode($this->encodeTags)
            ->render();

        if ($this->dateTime !== '') {
            $tag = ArrayHelper::remove($this->dateTimeOptions, 'tag', 'small');
            $title .= "\n" . Html::tag($tag, $this->dateTime, $this->dateTimeOptions)->encode($this->encodeTags);
        }

        $title .= "\n" . $button;

        Html::addCssClass($this->headerOptions, ['widget' => 'toast-header']);
        return Html::div("\n" . $title . "\n", $this->headerOptions)
            ->encode($this->encodeTags)
            ->render();
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
        return Html::openTag('div', $this->bodyOptions);
    }

    /**
     * Renders the closing tag of the toast body.
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        return $this->body . "\n" . Html::closeTag('div');
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    private function initOptions(): void
    {
        $this->options['id'] = $this->getId();
        Html::addCssClass($this->options, ['widget' => 'toast']);

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
