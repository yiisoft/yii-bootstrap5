<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Generator;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\NavType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;

use function iterator_count;

abstract class AbstractNav extends Widget
{
    /**
     * @psalm-var non-empty-string $tag
     */
    private string $tag = 'ul';
    private array $options = [];
    private bool|NavItem $defaultItem = true;
    protected ?NavType $type = null;
    private ?Size $vertical = null;
    protected int|string|null $activeItem = null;
    private bool $activateParents = false;

    /**
     * @var NavLink[]
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

    public function defaultItem(bool|NavItem $defaultItem): static
    {
        $new = clone $this;
        $new->defaultItem = $defaultItem;

        return $new;
    }

    public function links(NavLink ...$links): static
    {
        $new = clone $this;
        $new->links = $links;

        return $new;
    }

    final protected function getVisibleLinks(): Generator
    {
        $index = 0;

        /** @var NavLink $link */
        foreach ($this->links as $link) {
            if ($link->isVisible()) {
                yield $index++ => $link;
            }
        }
    }

    public function type(?NavType $type): static
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    public function tabs(): static
    {
        return $this->type(NavType::Tabs);
    }

    public function pills(): static
    {
        return $this->type(NavType::Pills);
    }

    public function underline(): static
    {
        return $this->type(NavType::Underline);
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

    private function activateTree(NavLink $link, NavLink ...$tree): void
    {
        if ($this->isLinkActive($link, null)) {

            $link->activate();

            foreach ($tree as $link) {
                $link->activate();
            }

            return;
        }

        $tree[] = $link;
        $items = $link->getItem()?->getItems() ?? [];

        foreach ($items as $item) {

            $link = $item instanceof NavItem ? $item->getLink() : $item;
            $this->activateTree($link, ...$tree);
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
            $classNames['type'] = $this->type->value;
        }

        if ($this->vertical === Size::ExtraSmall) {
            $classNames[] = 'flex-column';
        } elseif ($this->vertical) {
            $classNames[] = 'flex-' . $this->vertical->value . '-column';
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

    protected function prepareLink(NavLink $link, int $index): NavLink
    {
        if ($this->activateParents) {
            $this->activateTree($link);
        } elseif ($this->isLinkActive($link, $index)) {
            $link->activate();
        }

        if ($this->defaultItem && $link->getItem() === null) {

            if ($this->defaultItem === true) {
                return $link->item(NavItem::widget());
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

    protected function renderItem(NavLink $link, int $index): string
    {
        $link = $this->prepareLink($link, $index);

        if ($item = $link->getItem()) {
            return $item->render();
        }

        return $link->render();
    }
}
