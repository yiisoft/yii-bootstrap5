<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Generator;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

use function iterator_count;

abstract class AbstractMenu extends Widget
{
    /**
     * @psalm-var non-empty-string $tag
     */
    private string $tag = 'ul';
    private array $options = [];
    private bool|Item $defaultItem = true;
    protected MenuType $type;
    protected int|string|null $activeItem = null;
    private bool $activateParents = false;

    /**
     * @var Link[]
     */
    private array $links = [];

    /**
     * @psalm-param non-empty-string $tag
     */
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

    public function defaultItem(bool|Item $defaultItem): static
    {
        $new = clone $this;
        $new->defaultItem = $defaultItem;

        return $new;
    }

    public function links(Link ...$links): static
    {
        $new = clone $this;
        $new->links = $links;

        return $new;
    }

    final protected function getVisibleLinks(): Generator
    {
        $index = 0;

        /** @var Link $link */
        foreach ($this->links as $link) {
            if ($link->isVisible()) {
                yield $index++ => $link;
            }
        }
    }

    public function type(MenuType $type): static
    {
        $new = clone $this;
        $new->type = $type;

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

    private function activateTree(Link $link, Link ...$parents): void
    {
        if ($this->isLinkActive($link, null)) {

            $link->activate();

            foreach ($parents as $link) {
                $link->activate();
            }

            return;
        }

        $items = $link->getItem()?->getItems() ?? [];

        foreach ($items as $item) {
            $child = $item instanceof Item ? $item->getLink() : $item;
            $this->activateTree($child, $link, ...$parents);
        }
    }

    private function isLinkActive(Link $link, ?int $index): bool
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
        $classNames = ['widget' => $this->type->value];

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        Html::addCssClass($options, $classNames);

        foreach ($this->getVisibleLinks() as $index => $link) {
            $items[] = $this->renderItem($link, $index);
        }

        return Html::tag($this->tag)
                ->content(...$items)
                ->attributes($options)
                ->encode(false);
    }

    protected function prepareLink(Link $link, int $index): Link
    {
        if ($this->activateParents) {
            $this->activateTree($link);
        } elseif ($this->isLinkActive($link, $index)) {
            $link->activate();
        }

        $link = $link->widgetClassName($this->type->linkClassName());

        if ($this->defaultItem && $link->getItem() === null) {

            if ($this->defaultItem === true) {
                return $link->item(Item::widget());
            }

            return $link->item($this->defaultItem);
        }

        return $link;
    }

    public function render(): string
    {
        if (iterator_count($this->getVisibleLinks()) === 0) {
            return '';
        }

        return $this->prepareNav()->render();
    }

    protected function renderItem(Link $link, int $index): string
    {
        $link = $this->prepareLink($link, $index);

        return ($link->getItem()?->widgetClassName($this->type->itemClassName()) ?? $link)->render();
    }
}
