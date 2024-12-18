<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

use function array_merge;
use function implode;

/**
 * Nav renders a Bootstrap nav component.
 *
 * For example:
 *
 * ```php
 * echo Nav::widget()
 *     ->items(
 *         NavLink::create('Active', '#', active: true),
 *         Dropdown::widget()
 *             ->items(
 *                 DropdownItem::link('Action', '#'),
 *                 DropdownItem::link('Another action', '#'),
 *                 DropdownItem::link('Something else here', '#'),
 *                 DropdownItem::divider(),
 *                 DropdownItem::link('Separated link', '#'),
 *             ),
 *         NavLink::create('Link', url: '#'),
 *         NavLink::create('Disabled', '#', disabled: true),
 *     )
 *     ->styles(NavStyles::TABS)
 *     ->render(),
 * ```
 */
final class Nav extends \Yiisoft\Widget\Widget
{
    private const NAV_CLASS = 'nav';
    private const NAV_ITEM_DROPDOWN_CLASS = 'nav-item dropdown';
    private array $attributes = [];
    private array $cssClasses = [];
    /** @psalm-var Dropdown[]|NavLink[] */
    private array $items = [];
    private array $styleClasses = [];
    private string $tag = '';

    /**
     * Adds a set of attributes for the nav component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-nav']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $values);

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the nav component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $nav->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClasses = array_merge($new->cssClasses, $value);

        return $new;
    }

    /**
     * Adds a CSS style for the nav component.
     *
     * @param array|string $value The CSS style for the nav component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the nav component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $nav->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClasses = $value;

        return $new;
    }

    /**
     * List of links to appear in the nav. If this property is empty, the widget will not render anything.
     *
     * @param array $value The links to appear in the nav.
     *
     * @return self A new instance with the specified links to appear in the nav.
     *
     * @psalm-param Dropdown[]|NavLink[] $value The links to appear in the nav.
     */
    public function items(Dropdown|NavLink ...$value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Change the style of `.navs` component with modifiers and utilities. Mix and match as needed, or build your own.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param NavStyles|null ...$value One or more CSS style class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $nav->styles(NavStyles::TABS, NavStyles::VERTICAL);
     * ```
     *
     * @return self A new instance with the specified CSS style classes added.
     */
    public function styles(NavStyles|null ...$value): self
    {
        $new = clone $this;

        $new->styleClasses = array_merge($new->styleClasses, $value);

        return $new;
    }

    /**
     * Set the tag name for the nav component.
     *
     * @param string|Stringable $value The tag name for the nav component.
     *
     * @return self A new instance with the specified tag name.
     */
    public function tag(string|Stringable $value): self
    {
        $new = clone $this;
        $new->tag = (string) $value;

        return $new;
    }

    /**
     * Run the nav widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        Html::addCssClass($attributes, [self::NAV_CLASS, ...$this->styleClasses, ...$this->cssClasses, $classes]);

        $renderItems = $this->renderItems();

        return $this->tag === ''
            ? Ul::tag()->addAttributes($attributes)->items(...$renderItems)->render()
            : Html::tag($this->tag)
                ->addAttributes($attributes)
                ->addContent("\n", implode("\n", $renderItems), "\n")
                ->encode(false)
                ->render();
    }

    /**
     * Renders the items for the nav component.
     *
     * @return array The rendered items.
     */
    private function renderItems(): array
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item instanceof Dropdown ? $this->renderItemsDropdown($item) : $item->getContent();
        }

        return $items;
    }

    /**
     * Renders a dropdown item for the nav component.
     *
     * @param Dropdown $item The dropdown item to render.
     *
     * @return Li The rendered dropdown item.
     */
    private function renderItemsDropdown(Dropdown $item): Li
    {
        return Li::tag()
            ->addClass(self::NAV_ITEM_DROPDOWN_CLASS)
            ->addContent(
                "\n",
                $item
                    ->container(false)
                    ->toggleAsLink()
                    ->toggleClass('nav-link', 'dropdown-toggle')
                    ->toggleContent('Dropdown')
                    ->render(),
                "\n"
            )
            ->encode(false);
    }
}
