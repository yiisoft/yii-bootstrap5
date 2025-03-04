<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use RuntimeException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;
use Yiisoft\Widget\Widget;

use function in_array;
use function implode;
use function sprintf;

/**
 * Nav renders a Bootstrap navigation component.
 *
 * For example:
 *
 * ```php
 * // Basic navigation
 * echo Nav::widget()
 *     ->items(
 *         NavLink::to('Home', '#', active: true),
 *         NavLink::to('Link', '#'),
 *         NavLink::to('Disabled', '#', disabled: true),
 *     )
 *     ->render();
 *
 * // Tabs navigation
 * echo Nav::widget()
 *     ->items(
 *         NavLink::tab('Tab 1', 'Content 1', active: true),
 *         NavLink::tab('Tab 2', 'Content 2'),
 *         NavLink::tab('Tab 3', 'Content 3', disabled: true),
 *     )
 *     ->styles(NavStyle::TABS)
 *     ->withFade()
 *     ->render();
 * ```
 */
final class Nav extends Widget
{
    private const NAME = 'nav';
    private const NAV_ITEM_CLASS = 'nav-item';
    private const NAV_ITEM_DROPDOWN_CLASS = 'nav-item dropdown';
    private const NAV_LINK_ACTIVE_CLASS = 'active';
    private const NAV_LINK_CLASS = 'nav-link';
    private const NAV_LINK_DISABLED_CLASS = 'disabled';
    private bool $activateItems = true;
    private array $attributes = [];
    private array $cssClasses = [];
    private string $currentPath = '';
    private bool $fade = true;
    private bool|string $id = false;
    /** @var array<int, Dropdown|NavLink> */
    private array $items = [];
    private array $paneAttributes = [];
    private array $styleClasses = [];
    private string $tag = '';

    /**
     * Whether to activate items by matching the currentPath with the `url` option in the nav items.
     *
     * @param bool $enabled Whether to activate items. Defaults to `true`.
     *
     * @return self A new instance with the specified activated items value.
     */
    public function activateItems(bool $enabled): self
    {
        $new = clone $this;
        $new->activateItems = $enabled;

        return $new;
    }

    /**
     * Adds a set of attributes for the nav component.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-nav']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the nav component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
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
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style for the nav component.
     *
     * @param array|string $style The CSS style for the nav component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, `color: red`. If the value is an array, the values
     * will be separated by a space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as
     * `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the nav component.
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
     * Replaces all existing CSS classes of the nav component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $nav->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * The currentPath to be used to check the active state of the nav items.
     *
     * @param string $path The current path to be used to check the active state of the nav items.
     *
     * @return self A new instance with the specified current path.
     */
    public function currentPath(string $path): self
    {
        $new = clone $this;
        $new->currentPath = $path;

        return $new;
    }

    /**
     * Whether to fade the navigation items when toggling between them.
     *
     * @param bool $enabled Whether to fade the navigation items when toggling between them.
     *
     * @return self A new instance with the specified fade value.
     */
    public function fade(bool $enabled): self
    {
        if ($enabled && $this->isTabsOrPills() === false) {
            throw new RuntimeException('Fade effect can only be used with tabs or pills.');
        }

        $new = clone $this;
        $new->fade = $enabled;

        return $new;
    }

    /**
     * Sets the ID of the component.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
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
     * List of links to appear in the nav. If this property is empty, the widget will not render anything.
     *
     * @param array $items The links to appear in the nav.
     *
     * @return self A new instance with the specified links to appear in the nav.
     *
     * @psalm-param Dropdown[]|NavLink[] $items The links to appear in the nav.
     */
    public function items(Dropdown|NavLink ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the HTML attributes for the content panes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified pane attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function paneAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->paneAttributes = $attributes;

        return $new;
    }

    /**
     * Change the style of `.navs` component with modifiers and utilities. Mix and match as needed, or build your own.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param NavStyle|null ...$styles One or more CSS style class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $nav->styles(NavStyle::TABS, NavStyle::VERTICAL);
     * ```
     *
     * @return self A new instance with the specified CSS style classes added.
     */
    public function styles(NavStyle|null ...$styles): self
    {
        $new = clone $this;
        $new->styleClasses = [...$this->styleClasses, ...$styles];

        return $new;
    }

    /**
     * Set the tag name for the nav component.
     *
     * @param string|Stringable $tag The tag name for the nav component.
     *
     * @return self A new instance with the specified tag name.
     */
    public function tag(string|Stringable $tag): self
    {
        $new = clone $this;
        $new->tag = (string) $tag;

        return $new;
    }

    /**
     * Create a link or button for the navigation component.
     *
     * @param NavLink $item The link or button to be created.
     *
     * @return A|Button The link or button for the navigation component.
     */
    private function createLink(NavLink $item): A|Button
    {
        $attributes = $item->getUrlAttributes();
        $tag = A::tag()->href($item->getUrl());

        Html::addCssClass($attributes, [self::NAV_LINK_CLASS]);

        if ($this->isItemActive($item)) {
            Html::addCssClass($attributes, [self::NAV_LINK_ACTIVE_CLASS]);

            if ($item->hasContent() === false) {
                $attributes['aria-current'] = 'page';
            }
        }

        if ($item->isDisabled()) {
            Html::addCssClass($attributes, [self::NAV_LINK_DISABLED_CLASS]);
            $attributes['aria-disabled'] = 'true';
        }

        if ($item->hasContent()) {
            $tag = Button::tag()->type('button');
            $paneId = $item->getId();

            $attributes['id'] = $paneId;
            $attributes['data-bs-toggle'] = in_array(NavStyle::TABS, $this->styleClasses, true) ? 'tab' : 'pill';
            $attributes['data-bs-target'] = sprintf('#%s-pane', $paneId);
            $attributes['role'] = 'tab';
            $attributes['aria-controls'] = $paneId . '-pane';
            $attributes['aria-selected'] = $item->isActive() ? 'true' : 'false';
        }

        return $tag->addAttributes($attributes)->content($item->getLabel())->encode($item->shouldEncodeLabel());
    }

    /**
     * Create the links for the navigation component.
     *
     * @return array The links for the navigation component.
     */
    private function createLinks(): array
    {
        $links = [];

        foreach ($this->items as $item) {
            if ($item instanceof NavLink) {
                $links[] = $this->createLink($item);
            }
        }

        return $links;
    }

    /**
     * Checks whether a nav item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the nav item.
     *
     * @param NavLink $item The nav item to be checked.
     *
     * @return bool Whether the nav item is active.
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
     * current path for the item, and the rest of the elements are the associated parameters.
     *
     * Only when its current path and parameters match {@see currentPath}, respectively, will a dropdown item be
     * considered active.
     *
     * @param Dropdown $dropdown The dropdown item to be checked.
     *
     * @return Dropdown The active dropdown item.
     */
    private function isDropdownActive(Dropdown $dropdown): Dropdown
    {
        $items = $dropdown->getItems();

        foreach ($items as $key => $value) {
            if (
                $this->activateItems &&
                $value->getType() === DropdownItemType::LINK &&
                $value->getUrl() === $this->currentPath
            ) {
                $items[$key] = DropdownItem::link($value->getContent(), $value->getUrl(), active: true);
            }
        }

        return $dropdown->items(...$items);
    }

    /**
     * Checks whether the nav component is tabs or pills.
     *
     * @return bool Whether the nav component is tabs or pills.
     */
    private function isTabsOrPills(): bool
    {
        return in_array(NavStyle::TABS, $this->styleClasses, true) ||
            in_array(NavStyle::PILLS, $this->styleClasses, true);
    }

    /**
     * Run the nav widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;
        $tabContent = '';

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        if (in_array(NavStyle::NAVBAR, $this->styleClasses, true)) {
            Html::addCssClass($attributes, [...$this->styleClasses, ...$this->cssClasses, $classes]);
        } else {
            Html::addCssClass($attributes, [self::NAME, ...$this->styleClasses, ...$this->cssClasses, $classes]);
        }

        if ($this->isTabsOrPills()) {
            $tabContent = $this->renderTabContent();
        }

        if ($tabContent !== '') {
            $attributes['role'] = 'tablist';
        }

        $html = $this->tag === ''
            ? Ul::tag()->addAttributes($attributes)->id($id)->items(...$this->renderItems())->render()
            : Html::tag($this->tag)
                ->addAttributes($attributes)
                ->addContent("\n", implode("\n", $this->createLinks()), "\n")
                ->encode(false)
                ->render();

        return $html . $tabContent;
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
                $items[] = $this->renderNavItem($item);
            }
        }

        return $items;
    }

    /**
     * Renders a dropdown item for the nav component.
     *
     * @param Dropdown $items The dropdown items to render.
     *
     * @return Li The rendered dropdown item.
     */
    private function renderItemsDropdown(Dropdown $items): Li
    {
        $dropDownItems = $this->isDropdownActive($items);

        return Li::tag()
            ->addClass(self::NAV_ITEM_DROPDOWN_CLASS)
            ->addContent(
                "\n",
                $dropDownItems
                    ->container(false)
                    ->togglerAsLink()
                    ->togglerClass('nav-link', 'dropdown-toggle')
                    ->render(),
                "\n"
            )
            ->encode(false);
    }

    /**
     * Renders a nav item for the nav component.
     *
     * @param NavLink $item The nav item to render.
     *
     * @return Li The rendered nav item.
     */
    private function renderNavItem(NavLink $item): Li
    {
        $attributes = $item->getAttributes();

        Html::addCssClass($attributes, [self::NAV_ITEM_CLASS]);

        if ($item->hasContent()) {
            $attributes['role'] = 'presentation';
        }

        return Li::tag()->addAttributes($attributes)->addContent("\n", $this->createLink($item), "\n");
    }

    /**
     * Renders the content for the tab component.
     *
     * @return string The rendered content.
     */
    private function renderTabContent(): string
    {
        $panes = [];

        foreach ($this->items as $index => $item) {
            if ($item instanceof NavLink && $item->hasContent()) {
                $panes[] = $this->renderTabPane($item, $index);
            }
        }

        if ($panes === []) {
            return '';
        }

        $paneAttributes = $this->paneAttributes;

        Html::addCssClass($paneAttributes, ['widget' => 'tab-content']);

        return "\n" .
            Div::tag()
                ->addAttributes($paneAttributes)
                ->content("\n" . implode("\n", $panes) . "\n")
                ->encode(false)
                ->render();
    }

    /**
     * Renders a tab pane for the nav component.
     *
     * @param NavLink $item The tab pane to render.
     * @param int $index The index of the tab pane.
     *
     * @return string The rendered tab pane.
     */
    private function renderTabPane(NavLink $item, int $index): string
    {
        $paneAttributes = $item->getPaneAttributes();

        Html::addCssClass($paneAttributes, ['widget' => 'tab-pane']);

        if ($this->fade) {
            Html::addCssClass($paneAttributes, ['transition' => 'fade']);
        }

        if ($item->isActive()) {
            Html::addCssClass(
                $paneAttributes,
                [
                    'show' => $this->fade ? 'show' : '',
                    'active' => 'active',
                ],
            );
        }

        return Div::tag()
            ->attributes($paneAttributes)
            ->addAttributes(
                [
                    'role' => 'tabpanel',
                    'aria-labelledby' => $item->getId(),
                    'tabindex' => 0,
                ]
            )
            ->content($item->getContent())
            ->encode($item->shouldEncodeContent())
            ->id($item->getId() . '-pane')
            ->render();
    }
}
