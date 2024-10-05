<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Traversable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

use function count;
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
    protected bool $activateParents = false;
    private array $items = [];

    abstract protected function renderItem(mixed $item, int $index): string;

    abstract protected function getVisibleItems(): iterable;

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

    /**
     * Set default `Item` for each `Link` if not preset
     */
    public function defaultItem(bool|Item $defaultItem): static
    {
        $new = clone $this;
        $new->defaultItem = $defaultItem;

        return $new;
    }

    protected function getDefaultItem(): ?Item
    {
        if ($this->defaultItem === true) {
            return Item::widget()->widgetClassName($this->type->itemClassName());
        }

        return $this->defaultItem ? $this->defaultItem : null;
    }

    public function items(mixed ...$items): static
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    final protected function getItems(): array
    {
        return $this->items;
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

    /**
     *
     * @param Link $link
     * @param Link $parents
     * @return Link[]|null
     */
    protected function activateTree(Link $link, Link ...$parents): ?array
    {
        if ($this->isLinkActive($link, null)) {

            $links = [
                $link->activate(),
            ];

            foreach ($parents as $link) {
                $links[] = $link->activate();
            }

            return $links;
        }

        return null;
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

    protected function prepareMenu(): Tag
    {
        $items = [];
        $options = $this->options;
        $classNames = ['widget' => $this->type->value];

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        if ($this->theme) {
            $options['data-bs-theme'] = $this->theme;
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

    protected function prepareLink(Link $link, int $index): Link
    {
        if ($this->activateParents) {
            $this->activateTree($link);
        } elseif ($this->isLinkActive($link, $index)) {
            $link->activate();
        }

        $link = $link->widgetClassName($this->type->linkClassName());

        if ($link->getItem() === null) {
            return $link->item($this->getDefaultItem());
        }

        return $link;
    }

    public function render(): string
    {
        $iterator = $this->getVisibleItems();
        $count = $iterator instanceof Traversable ? iterator_count($iterator) : count($iterator);

        if ($count === 0) {
            return '';
        }

        return $this->prepareMenu()->render();
    }
}
