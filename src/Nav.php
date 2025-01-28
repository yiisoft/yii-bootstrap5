<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

use function implode;

/**
 * Nav renders a Bootstrap nav component.
 *
 * For example:
 *
 * ```php
 * echo Nav::widget()
 *     ->items(
 *         NavLink::item('Active', '#', active: true),
 *         Dropdown::widget()
 *             ->items(
 *                 DropdownItem::link('Action', '#'),
 *                 DropdownItem::link('Another action', '#'),
 *                 DropdownItem::link('Something else here', '#'),
 *                 DropdownItem::divider(),
 *                 DropdownItem::link('Separated link', '#'),
 *             ),
 *         NavLink::item('Link', url: '#'),
 *         NavLink::item('Disabled', '#', disabled: true),
 *     )
 *     ->styles(NavStyle::TABS)
 *     ->render(),
 * ```
 */
final class Nav extends \Yiisoft\Widget\Widget
{
    private const NAV_CLASS = 'nav';
    private const NAV_ITEM_CLASS = 'nav-item';
    private const NAV_ITEM_DROPDOWN_CLASS = 'nav-item dropdown';
    private const NAV_LINK_ACTIVE_CLASS = 'active';
    private const NAV_LINK_CLASS = 'nav-link';
    private const NAV_LINK_DISABLED_CLASS = 'disabled';
    private bool $activateItems = true;
    private array $attributes = [];
    private array $cssClasses = [];
    private string $currentPath = '';
    /** @psalm-var Dropdown[]|NavLink[] */
    private array $items = [];
    private array $styleClasses = [];
    private string $tag = '';

    /**
     * Whether to activate items by matching the currentPath with the `url` option in the nav items.
     *
     * @param bool $value Whether to activate items. Defaults to `true`.
     *
     * @return self A new instance with the specified activate items value.
     */
    public function activateItems(bool $value): self
    {
        $new = clone $this;
        $new->activateItems = $value;

        return $new;
    }

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
        $new->attributes = [...$this->attributes, ...$values];

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
        $new->cssClasses = [...$this->cssClasses, ...$value];

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
     * Sets the HTML attributes for the nav component.
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
     * The currentPath to be used to check the active state of the nav items.
     *
     * @param string $value The currentPath to be used to check the active state of the nav items.
     *
     * @return self A new instance with the specified currentPath.
     */
    public function currentPath(string $value): self
    {
        $new = clone $this;
        $new->currentPath = $value;

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
     * @param NavStyle|null ...$value One or more CSS style class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $nav->styles(NavStyle::TABS, NavStyle::VERTICAL);
     * ```
     *
     * @return self A new instance with the specified CSS style classes added.
     */
    public function styles(NavStyle|null ...$value): self
    {
        $new = clone $this;
        $new->styleClasses = [...$this->styleClasses, ...$value];

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

        if (in_array(NavStyle::NAVBAR, $this->styleClasses, true)) {
            Html::addCssClass($attributes, [...$this->styleClasses, ...$this->cssClasses, $classes]);
        } else {
            Html::addCssClass($attributes, [self::NAV_CLASS, ...$this->styleClasses, ...$this->cssClasses, $classes]);
        }

        return $this->tag === ''
            ? Ul::tag()->addAttributes($attributes)->items(...$this->renderItems())->render()
            : Html::tag($this->tag)
                ->addAttributes($attributes)
                ->addContent("\n", implode("\n", $this->renderLinks()), "\n")
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
            if ($item instanceof Dropdown) {
                $items[] = $this->renderItemsDropdown($item);
            } elseif ($item->isVisible()) {
                $items[] = $this->renderNavLink($item);
            }
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
    private function renderItemsDropdown(Dropdown $items): Li
    {
        $dropDownItems = $this->isItemActiveDropdown($items);

        return Li::tag()
            ->addClass(self::NAV_ITEM_DROPDOWN_CLASS)
            ->addContent(
                "\n",
                $dropDownItems
                    ->container(false)
                    ->toggleAsLink()
                    ->toggleClass('nav-link', 'dropdown-toggle')
                    ->render(),
                "\n"
            )
            ->encode(false);
    }

    /**
     * Renders a link for the nav component.
     *
     * @param NavLink $item The link to render.
     *
     * @return A The rendered link.
     */
    private function renderLink(NavLink $item): A
    {
        $attributes = $item->getUrlAttributes();

        Html::addCssClass($attributes, [self::NAV_LINK_CLASS]);

        if ($this->isItemActive($item)) {
            Html::addCssClass($attributes, [self::NAV_LINK_ACTIVE_CLASS]);

            $attributes['aria-current'] = 'page';
        }

        if ($item->isDisabled()) {
            Html::addCssClass($attributes, [self::NAV_LINK_DISABLED_CLASS]);

            $attributes['aria-disabled'] = 'true';
        }

        return A::tag()
            ->addAttributes($attributes)
            ->addContent($item->getLabel())
            ->href($item->getUrl())
            ->encode($item->shouldEncodeLabel());
    }

    /**
     * Renders the links for the nav component.
     *
     * @return array The rendered links.
     */
    private function renderLinks(): array
    {
        $links = [];

        foreach ($this->items as $item) {
            if ($item instanceof NavLink) {
                $links[] = $this->renderLink($item);
            }
        }

        return $links;
    }

    /**
     * Renders a nav link for the nav component.
     *
     * @param NavLink $item The nav link to render.
     *
     * @return Li The rendered nav link.
     */
    private function renderNavLink(NavLink $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addClass(self::NAV_ITEM_CLASS)
            ->addContent(
                "\n",
                $this->renderLink($item),
                "\n"
            );
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the menu item. When
     * the `url` option of a menu item is specified in terms of an array, its first element is treated as the
     * currentPath for the item and the rest of the elements are the associated parameters. Only when its currentPath
     * and parameters match {@see currentPath}, respectively, will a menu item be considered active.
     *
     * @param NavLink $item The menu item to be checked.
     *
     * @return bool Whether the menu item is active.
     */
    private function isItemActive(NavLink $item): bool
    {
        if ($item->isActive()) {
            return true;
        }

        return $item->getUrl() === $this->currentPath && $this->activateItems;
    }

    /**
     * Checks whether a dropdown item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the dropdown item.
     * When the `url` option of a dropdown item is specified in terms of an array, its first element is treated as the
     * currentPath for the item and the rest of the elements are the associated parameters. Only when its currentPath
     * and parameters match {@see currentPath}, respectively, will a dropdown item be considered active.
     *
     * @param Dropdown $dropdown The dropdown item to be checked.
     *
     * @return Dropdown The active dropdown item.
     */
    private function isItemActiveDropdown(Dropdown $dropdown): Dropdown
    {
        $items = $dropdown->getItems();

        foreach ($items as $key => $value) {
            if ($value->getType() === 'link' && $value->getUrl() === $this->currentPath && $this->activateItems) {
                $items[$key] = DropdownItem::link($value->getContent(), $value->getUrl(), active: true);
            }
        }

        return $dropdown->items(...$items);
    }
}
