<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Enum\ToggleType;

/**
 * Toggle class serves as a base for implementing various types of toggle components.
 */
final class Toggle extends \Yiisoft\Widget\Widget
{
    private array $attributes = [];
    private ToggleType|null $toggleType = null;
    private string $tagName = 'button';

    /**
     * Sets the HTML attributes for the toggle component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance of the current class with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): static
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Sets the tag name to 'a', making the toggle component a link.
     *
     * @return self A new instance of the current class with the tag name set to 'a'.
     */
    public function link(): self
    {
        $new = clone $this;
        $new->tagName = 'a';

        return $new;
    }

    /**
     * Sets the type of the toggle component.
     *
     * @param ToggleType $value The type of the toggle component.
     *
     * @return self A new instance of the current class with the specified type.
     */
    public function type(ToggleType $value): self
    {
        $new = clone $this;
        $new->toggleType = $value;

        return $new;
    }

    /**
     * Run the toggle widget.
     *
     * It generates the toggle button with the specified content and attributes.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $class = $this->attributes['class'] ?? null;

        if ($this->toggleType !== null) {
            $buildAttributes = $this->toggleType->buildAttibutes();

            Html::addCssClass($buildAttributes, $class);
            unset($attributes['class']);
            $attributes = array_merge($attributes, $buildAttributes);
        }

        return Html::tag($this->tagName, '', $attributes)->encode(false)->render();
    }
}
