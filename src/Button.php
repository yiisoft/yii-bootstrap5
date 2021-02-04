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
 *     ->withLabel('Action')
 *     ->withOptions(['class' => 'btn-lg']);
 * ```
 */
final class Button extends Widget
{
    private string $tagName = 'button';
    private string $label = 'Button';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $options = [];

    public function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn']);

        $this->registerPlugin('button', $this->options);

        if ($this->encodeTags === false) {
            $this->options = array_merge($this->options, ['encode' => false]);
        }

        return Html::tag(
            $this->tagName,
            $this->encodeLabels ? Html::encode($this->label) : $this->label,
            $this->options
        );
    }

    /**
     * Whether the label should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function withEncodeLabels(bool $value): self
    {
        $new = clone $this;
        $new->encodeLabels = $value;

        return $new;
    }

    /**
     * The button label
     *
     * @param string $value
     *
     * @return $this
     */
    public function withLabel(string $value): self
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
     *
     * @return $this
     */
    public function withOptions(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * The tag to use to render the button.
     *
     * @param string $value
     *
     * @return $this
     */
    public function withTagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }

    /**
     * Allows you to enable or disable the encoding tags html.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withEncodeTags(bool $value): self
    {
        $new = clone $this;
        $new->encodeTags = $value;

        return $new;
    }
}
