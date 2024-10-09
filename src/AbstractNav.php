<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;

abstract class AbstractNav extends AbstractMenu
{
    protected ?Size $vertical = null;

    final public function items(Link|Dropdown ...$items): static
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    private function type(MenuType $type): static
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    public function nav(): static
    {
        return $this->type(MenuType::Nav);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs
     */
    public function tabs(): static
    {
        return $this->type(MenuType::Tabs);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#pills
     */
    public function pills(): static
    {
        return $this->type(MenuType::Pills);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#underline
     */
    public function underline(): static
    {
        return $this->type(MenuType::Underline);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#vertical
     */
    public function vertical(?Size $vertical): static
    {
        $new = clone $this;
        $new->vertical = $vertical;

        return $new;
    }

    protected function prepareMenu(string $item, string ...$items): Tag
    {
        $tag = parent::prepareMenu($item, ...$items);

        if ($this->vertical) {
            return $tag->addClass($this->vertical->formatClassName('flex', 'column'));
        }

        return $tag;
    }

    /**
     * @param Dropdown|Link $item
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function renderItem(mixed $item, int $index): string
    {
        if ($item instanceof Dropdown) {
            /** @psalm-suppress PossiblyNullArgument */
            return $item->toggle(
                $this->prepareLink($item->getToggle(), $index),
            )
            ->setParent($this)
            ->render();
        }

        $link = $this->prepareLink($item, $index);

        return ($link->getItem()?->widgetClassName($this->type->itemClassName()) ?? $link)->render();
    }
}
