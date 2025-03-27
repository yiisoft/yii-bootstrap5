<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;
use Yiisoft\Widget\Widget;

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
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $buttonGroup->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $buttonGroup->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style.
     *
     * @param array|string $style The CSS style. If an array, the values will be separated by a space. If a string, it
     * will be added as is. For example, `color: red`. If the value is an array, the values will be separated by a
     * space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $buttonGroup->addCssStyle('color: red');
     *
     * // or
     * $buttonGroup->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the ARIA label.
     *
     * @param string $label The ARIA label.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     *
     * Example usage:
     * ```php
     * $buttonGroup->ariaLabel('Basic example');
     * ```
     */
    public function ariaLabel(string $label): self
    {
        return $this->attribute('aria-label', $label);
    }

    /**
     * Adds a sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute added.
     *
     * Example usage:
     * ```php
     * $buttonGroup->attribute('data-id', '123');
     * ```
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $buttonGroup->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * List of buttons.
     *
     * @param Button|Checkbox|Radio ...$buttons The button.
     *
     * @return self A new instance with the specified buttons.
     *
     * Example usage:
     * ```php
     * $buttonGroup->buttons(
     *     Button::widget()->label('Left')->variant(ButtonVariant::PRIMARY),
     *     Button::widget()->label('Middle')->variant(ButtonVariant::PRIMARY),
     *     Button::widget()->label('Right')->variant(ButtonVariant::PRIMARY),
     * );
     * ```
     */
    public function buttons(Button|Checkbox|Radio ...$buttons): self
    {
        $new = clone $this;
        $new->buttons = $buttons;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $buttonGroup->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     *
     * Example usage:
     * ```php
     * $buttonGroup->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the size.
     *
     * @param ButtonSize|null $size The size. If `null`, the size will not be set.
     *
     * @return self A new instance with the specified size.
     *
     * Example usage:
     * ```php
     * $buttonGroup->size(ButtonSize::LARGE);
     * ```
     */
    public function size(ButtonSize|null $size): self
    {
        return $this->addClass($size?->value);
    }

    /**
     * Sets the button group to be vertical.
     *
     * @return self A new instance of the current class with the button group as vertical.
     *
     * Example usage:
     * ```php
     * $buttonGroup->vertical();
     * ```
     */
    public function vertical(): self
    {
        return $this->addClass('btn-group-vertical');
    }

    /**
     * Run the button group widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class'], $attributes['id']);

        $button = implode("\n", $this->buttons);
        $buttons = $button === '' ? '' : "\n" . $button . "\n";

        if ($buttons === '') {
            return '';
        }

        return Div::tag()
            ->attributes($attributes)
            ->attribute('role', 'group')
            ->addClass(
                self::NAME,
                $classes,
                ...$this->cssClasses,
            )
            ->content($buttons)
            ->encode(false)
            ->id($this->getId())
            ->render();
    }

    /**
     * Generates the ID.
     *
     * @return string|null The generated ID.
     *
     * @psalm-return non-empty-string|null The generated ID.
     */
    private function getId(): string|null
    {
        return match ($this->id) {
            true => $this->attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };
    }
}
