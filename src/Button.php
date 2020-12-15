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
    private string $tagName = 'button';
    private string $label = 'Button';
    private bool $encodeLabels = true;
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button";
        }

        Html::addCssClass($this->options, ['widget' => 'btn']);

        $this->registerPlugin('button', $this->options);

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
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * The button label
     *
     * @param string $value
     *
     * @return $this
     */
    public function label(string $value): self
    {
        $this->label = $value;

        return $this;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * The tag to use to render the button.
     *
     * @param string $value
     *
     * @return $this
     */
    public function tagName(string $value): self
    {
        $this->tagName = $value;

        return $this;
    }
}
