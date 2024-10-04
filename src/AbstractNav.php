<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Generator;
use InvalidArgumentException;
use LogicException;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

use function get_debug_type;
use function sprintf;

abstract class AbstractNav extends AbstractMenu
{
    /**
     *
     * @param Link|Dropdown $items
     * @return static
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public function items(mixed ...$items): static
    {
        foreach ($items as $item) {
            if (!$item instanceof Link && !$item instanceof Dropdown) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"$item" must be instance of "%s" or "%s". "%s" given.',
                        Link::class,
                        Dropdown::class,
                        get_debug_type($item),
                    )
                );
            }

            if ($item instanceof Dropdown && $item->getToggler() === null) {
                throw new LogicException(
                    sprintf(
                        'Every "%s" $item must contains a "toggler" property.',
                        Dropdown::class
                    )
                );
            }
        }

        return parent::items(...$items);
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

    final protected function getVisibleItems(): Generator
    {
        $index = 0;

        /** @var Link|Dropdown $item */
        foreach ($this->getItems() as $item) {
            /** @var Link $link */
            $link = $item instanceof Dropdown ? $item->getToggler() : $item;

            if ($link->isVisible()) {
                yield $index++ => $item;
            }
        }
    }

    /**
     *
     * @param Link|Dropdown $item
     * @param int $index
     * @return string
     */
    protected function renderItem(mixed $item, int $index): string
    {
        if ($item instanceof Dropdown) {

            $dropdown = $item->toggler(
                $this->prepareLink($item->getToggler(), $index),
            );

            if ($this->activateParents && $this->activeItem !== null) {
                $dropdown = $dropdown->activateParents($this->activateParents)
                                     ->activeItem($this->activeItem);
            }

            return $dropdown->render();
        }

        $link = $this->prepareLink($item, $index);

        return ($link->getItem()?->widgetClassName($this->type->itemClassName()) ?? $link)->render();
    }
}
