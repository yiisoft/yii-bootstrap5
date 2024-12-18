<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

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

    private const NAV_CLASS = 'collapse navbar-collapse';
    private const NAV_ITEM_CLASS = 'nav-item';
    private const NAV_ITEM_DROPDOWN_CLASS = 'dropdown';
    private const NAV_LIST_CLASS = 'nav';
    private array $attributes = [];
    /** @psalm-var Dropdown[]|NavLink[] */
    private array $items = [];
    private array $itemsClass = [];
    private array $styleClasses = [];

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
     * Replaces all existing CSS classes of items of the nav component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $carousel->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set for items.
     */
    public function itemsClass(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;

        foreach ($value as $class) {
            if ($class !== null) {
                $new->itemsClass[] = $class instanceof BackedEnum ? $class->value : $class;
            }
        }

        return $new;
    }

    public function styles(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;

        $new->styleClasses = array_merge($new->styleClasses, $value);

        return $new;
    }

    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        Html::addCssClass($attributes, [self::NAV_CLASS, $classes]);

        return $this->renderItems();
    }

    private function renderItemDropdown(Dropdown $item): Li
    {
        return Li::tag()
            ->addClass(
                self::NAV_ITEM_CLASS,
                self::NAV_ITEM_DROPDOWN_CLASS
            )
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

    private function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item instanceof Dropdown ? $this->renderItemDropdown($item) : $item->getContent();
        }

        $ulTag = Ul::tag()->addClass(self::NAV_LIST_CLASS)->items(...$items);

        if ($this->styleClasses !== []) {
            $ulTag = $ulTag->class(...$this->styleClasses);
        }

        return $ulTag->render();
    }
}
