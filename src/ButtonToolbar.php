<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

use function implode;

/**
 * ButtonToolbar Combines sets of button groups into button toolbars for more complex components.
 * Use utility classes as needed to space out groups, buttons, and more.
 *
 * For example,
 *
 * ```php
 * echo ButtonToolbar::widget()
 *     ->ariaLabel('Toolbar with button groups')
 *     ->buttonGroups(
 *         ButtonGroup::widget()
 *             ->addClass('me-2')
 *             ->ariaLabel('First group')
 *             ->buttons(
 *                 Button::widget()->label('1')->variant(ButtonVariant::PRIMARY),
 *                 Button::widget()->label('2')->variant(ButtonVariant::PRIMARY),
 *                 Button::widget()->label('3')->variant(ButtonVariant::PRIMARY),
 *                 Button::widget()->label('4')->variant(ButtonVariant::PRIMARY),
 *             ),
 *         ButtonGroup::widget()
 *             ->addClass('me-2')
 *             ->ariaLabel('Second group')
 *             ->buttons(
 *                 Button::widget()->label('5'),
 *                 Button::widget()->label('6'),
 *                 Button::widget()->label('7'),
 *             ),
 *         ButtonGroup::widget()
 *             ->ariaLabel('Third group')
 *             ->buttons(
 *                 Button::widget()->label('8')->variant(ButtonVariant::INFO),
 *             )
 *     )
 *     ->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/button-group/#button-toolbar
 */
final class ButtonToolbar extends Widget
{
    private const NAME = 'btn-toolbar';
    private array $attributes = [];
    /** @psalm-var ButtonGroup[]|Tag[] $buttonGroups */
    private array $buttonGroups = [];
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
     * $buttonToolbar->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$new->attributes, ...$attributes];

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
     * $buttonToolbar->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $buttonToolbar->addCssStyle('color: red');
     *
     * // or
     * $buttonToolbar->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
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
     * $buttonToolbar->ariaLabel('Toolbar with button groups');
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
     * $buttonToolbar->attribute('data-id', '123');
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
     * $buttonToolbar->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * List of buttons groups.
     *
     * @param ButtonGroup|Tag ...$groups The button group.
     *
     * @return self A new instance with the specified buttons groups.
     */
    public function buttonGroups(ButtonGroup|Tag ...$groups): self
    {
        $new = clone $this;
        $new->buttonGroups = $groups;

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
     * $buttonToolbar->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $buttonToolbar->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class'], $attributes['id']);

        $buttonGroup = implode("\n", $this->buttonGroups);
        $buttonsGroups = $buttonGroup === '' ? '' : "\n" . $buttonGroup . "\n";

        if ($buttonsGroups === '') {
            return '';
        }

        return Div::tag()
            ->attributes($attributes)
            ->attribute('role', 'toolbar')
            ->addClass(
                self::NAME,
                $classes,
                ...$this->cssClasses,
            )
            ->content($buttonsGroups)
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
