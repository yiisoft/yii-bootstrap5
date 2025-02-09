<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

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
     * Adds a sets of attributes for the button toolbar component.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-button-toolbar']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$new->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the button toolbar component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $buttonToolbar->addClass('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Sets the ARIA label for the button toolbar component.
     *
     * @param string $label The ARIA label for the button toolbar component.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     */
    public function ariaLabel(string $label): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $label;

        return $new;
    }

    /**
     * Sets the HTML attributes for the button toolbar component.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * @param ButtonGroup|Tag ...$groups The button group configuration.
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
     * Replaces all existing CSS classes of the button toolbar component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $buttonToolbar->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the ID of the button toolbar component.
     *
     * @param bool|string $id The ID of the button toolbar component. If `true`, an ID will be generated
     * automatically.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Run the button toolbar widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = 'toolbar';
        $classes = $attributes['class'] ?? null;

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClasses]);

        $buttonGroup = implode("\n", $this->buttonGroups);
        $buttonsGroups = $buttonGroup === '' ? '' : "\n" . $buttonGroup . "\n";

        if ($buttonsGroups === '') {
            return '';
        }

        return Div::tag()->attributes($attributes)->content($buttonsGroups)->encode(false)->id($id)->render();
    }
}
