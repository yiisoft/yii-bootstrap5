<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget()
 *     ->label('Action')
 *     ->options(['class' => 'btn-lg']);
 * ```
 */
final class Button extends Widget
{
    /** @psalm-var non-empty-string */
    private string $tagName = 'button';
    private string $label = 'Button';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $options = [];

    public function render(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn']);

        return Html::tag(
            $this->tagName,
            $this->encodeLabels ? Html::encode($this->label) : $this->label,
            $this->options
        )
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * When tags Labels HTML should not be encoded.
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * The button label
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * The tag to use to render the button.
     *
     * @psalm-param non-empty-string $value
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }
}
