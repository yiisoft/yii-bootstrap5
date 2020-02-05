<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

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
class Button extends Widget
{
    /**
     * @var string the tag to use to render the button
     */
    private string $tagName = 'button';

    /**
     * @var string the button label
     */
    private string $label = 'Button';

    /**
     * @var bool whether the label should be HTML-encoded.
     */
    private bool $encodeLabels = true;

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $options = [];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
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
     * {@see $encodeLabel}
     *
     * @param bool $value
     *
     * @return Button
     */
    public function encodeLabels(bool $value): Button
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * {@see $label}
     *
     * @param string $value
     *
     * @return Button
     */
    public function label(string $value): Button
    {
        $this->label = $value;

        return $this;
    }

    /**
     * {@see $options}
     *
     * @param array $value
     *
     * @return Button
     */
    public function options(array $value): Button
    {
        $this->options = $value;

        return $this;
    }

    /**
     * {@see $tagName}
     *
     * @param string $value
     *
     * @return Button
     */
    public function tagName(string $value): Button
    {
        $this->tagName = $value;

        return $this;
    }
}
