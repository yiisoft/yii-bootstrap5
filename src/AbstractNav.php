<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

use function iterator_count;

abstract class AbstractNav extends Widget
{
    /**
     * @psalm-suppress MissingClassConstType Remove suppress after fix https://github.com/vimeo/psalm/issues/11024
     */
    final public const NAV_TABS = 'nav-tabs';

    /**
     * @psalm-suppress MissingClassConstType Remove suppress after fix https://github.com/vimeo/psalm/issues/11024
     */
    final public const NAV_PILLS = 'nav-pills';

    /**
     * @psalm-suppress MissingClassConstType Remove suppress after fix https://github.com/vimeo/psalm/issues/11024
     */
    final public const NAV_UNDERLINE = 'nav-underline';

    private string $tag = 'ul';
    private array $options = [];
    private bool|NavItem $defaultItem = true;
    protected ?string $type = null;
    private ?Size $vertical = null;
    protected int|string|null $activeItem = null;
    private bool $activateParents = false;

    /**
     * @var NavItem[]|NavLink[]
     */
    private array $items = [];

    public function tag(string $tag): static
    {
        $new = clone $this;
        $new->tag = $tag;

        return $new;
    }

    public function options(array $options): static
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    public function defaultItem(bool|NavItem $defaultItem): static
    {
        $new = clone $this;
        $new->defaultItem = $defaultItem;

        return $new;
    }

    public function items(NavItem|NavLink ...$items): static
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * @return NavItem[]|NavLink[]
     */
    final protected function getVisibleItems(): iterable
    {
        $index = 0;

        /** @var NavItem|NavLink $item */
        foreach ($this->items as $item) {
            /** @var NavLink $link */
            $link = $item instanceof NavItem ? $item->getLink() : $item;

            if ($link->isVisible()) {
                yield $index++ => $item;
            }
        }
    }

    public function type(?string $type): static
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    public function tabs(): static
    {
        return $this->type(self::NAV_TABS);
    }

    public function pills(): static
    {
        return $this->type(self::NAV_PILLS);
    }

    public function underline(): static
    {
        return $this->type(self::NAV_UNDERLINE);
    }

    public function vertical(?Size $vertical): static
    {
        $new = clone $this;
        $new->vertical = $vertical;

        return $new;
    }

    public function activeItem(int|string|null $activeItem): static
    {
        $new = clone $this;
        $new->activeItem = $activeItem;

        return $new;
    }

    public function activateParents(bool $activate): static
    {
        $new = clone $this;
        $new->activateParents = $activate;

        return $new;
    }

    private function activateTree(NavItem|NavLink $item, NavLink ...$tree): void
    {
        $isItem = $item instanceof NavItem;
        $link = $isItem ? $item->getLink() : $item;
        $tree[] = $link;

        if ($this->isLinkActive($link, null)) {

            foreach ($tree as $navLink) {
                $navLink->activate();
            }

            return;
        }

        if (!$isItem) {
            return;
        }

        foreach ($item->getItems() as $subItem) {
            $this->activateTree($subItem, ...$tree);
        }
    }

    private function isLinkActive(NavLink $link, ?int $index): bool
    {
        if ($link->isActive() || $this->activeItem === null) {
            return $link->isActive();
        }

        if (is_int($this->activeItem)) {
            return $this->activeItem === $index;
        }

        return $link->getUrl() === $this->activeItem || $link->getPath() === $this->activeItem;
    }

    protected function prepareNav(): Tag
    {
        $items = [];
        $options = $this->options;
        $classNames = ['widget' => 'nav'];

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        if ($this->type) {
            $classNames['type'] = $this->type;
        }

        if ($this->vertical === Size::ExtraSmall) {
            $classNames[] = 'flex-column';
        } elseif ($this->vertical) {
            $classNames[] = 'flex-' . $this->vertical->value . '-column';
        }

        Html::addCssClass($options, $classNames);

        foreach ($this->getVisibleItems() as $index => $item) {
            $items[] = $this->renderItem($item, $index);
        }

        return Html::tag($this->tag)
                ->content(...$items)
                ->attributes($options)
                ->encode(false);
    }

    protected function prepareLink(NavLink $link, int $index): NavLink
    {
        return $this->isLinkActive($link, $index) ? $link->activate() : $link;
    }

    public function render(): string
    {
        if (iterator_count($this->getVisibleItems()) === 0) {
            return '';
        }

        return $this->prepareNav()
                    ->render();
    }

    protected function renderItem(NavItem|NavLink $item, int $index): string
    {
        $isLink = $item instanceof NavLink;
        /** @var NavLink $link */
        $link = $isLink ? $item : $item->getLink();

        if ($this->activateParents) {
            $this->activateTree($item);
        }

        $link = $this->prepareLink($link, $index);

        if ($isLink) {

            if ($this->defaultItem === true) {
                $this->defaultItem = NavItem::widget();
            }

            $item = $this->defaultItem ? $this->defaultItem->links($link) : null;
        }

        return ($item ?? $link)->render();
    }
}
