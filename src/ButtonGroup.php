<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Widget\Widget;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;

use function implode;

/**
 * ButtonGroup renders a button group bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo ButtonGroup::widget()
 *     ->addClass('btn-lg')
 *     ->ariaLabel('Basic example')
 *     ->buttons(
 *         Button::widget()->label('Left')->variant(ButtonVariant::PRIMARY),
 *         Button::widget()->label('Middle')->variant(ButtonVariant::PRIMARY),
 *         Button::widget()->label('Right')->variant(ButtonVariant::PRIMARY),
 *     )
 *     ->render();
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 *
 * @link https://getbootstrap.com/docs/5.3/components/button-group/
 */
final class ButtonGroup extends Widget
{
    private const NAME = 'btn-group';

    private array $attributes = [];

    /** psalm-var Button[]|Checkbox[]|Radio[] $buttons */
    private array $buttons = [];

    private array $cssClasses = [];

    private bool|string $id = true;

    /**
     * Adds a sets of attributes for the button group component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-button-group']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$values];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the button group component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$values One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $buttonGroup->addClass('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$values];

        return $new;
    }

    /**
     * Sets the ARIA label for the button group component.
     *
     * @param string $value The ARIA label for the button group component.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the button group component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * List of buttons.
     *
     * @param Button|Checkbox|Radio ...$value The button configuration.
     *
     * @return self A new instance with the specified buttons.
     */
    public function buttons(Button|Checkbox|Radio ...$value): self
    {
        $new = clone $this;
        $new->buttons = $value;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the button group component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$values One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $buttonGroup->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = $values;

        return $new;
    }

    /**
     * Sets the ID of the button group component.
     *
     * @param bool|string $value The ID of the button group component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Sets the button group size to be large.
     *
     * @return self A new instance with the button as a large button.
     */
    public function largeSize(): self
    {
        $new = clone $this;
        $new->cssClasses['size'] = 'btn-lg';

        return $new;
    }

    /**
     * Sets the button group size to be normal.
     *
     * @return self A new instance with the button as a normal button.
     */
    public function normalSize(): self
    {
        $new = clone $this;
        $new->cssClasses['size'] = null;

        return $new;
    }

    /**
     * Sets the button group size to be small.
     *
     * @return self A new instance with the button as a small button.
     */
    public function smallSize(): self
    {
        $new = clone $this;
        $new->cssClasses['size'] = 'btn-sm';

        return $new;
    }

    /**
     * Sets the button group to be vertical.
     *
     * @return self A new instance of the current class with the button group as vertical.
     */
    public function vertical(): self
    {
        $new = clone $this;
        $new->cssClasses[] = 'btn-group-vertical';

        return $new;
    }

    /**
     * Run the button group widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = 'group';
        $classes = $attributes['class'] ?? null;

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClasses]);

        $button = implode("\n", $this->buttons);
        $buttons = $button === '' ? '' : "\n" . $button . "\n";

        if ($buttons === '') {
            return '';
        }

        return Div::tag()->attributes($attributes)->content($buttons)->encode(false)->id($id)->render();
    }
}
