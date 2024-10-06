<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use RuntimeException;
use Traversable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

use function count;
use function iterator_count;
use function sprintf;

abstract class AbstractMenu extends Widget
{
    /**
     * @psalm-var non-empty-string $tag
     */
    protected string $tag = 'ul';
    private array $options = [];
    protected bool|Item $defaultItem = true;
    protected MenuType $type;
    protected int|string|null $activeItem = null;
    private ?bool $activateParents = null;
    protected array $items = [];
    private ?self $parent = null;

    abstract protected function renderItem(mixed $item, int $index): string;

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

        return $this->defaultItem ?: null;
    }

    public function activeItem(int|string|null $activeItem): static
    {
        $new = clone $this;
        $new->activeItem = $activeItem;

        return $new;
    }

    public function getActiveItem(): int|string|null
    {
        return $this->activeItem ?? $this->parent?->getActiveItem();
    }

    public function activateParents(?bool $activate): static
    {
        $new = clone $this;
        $new->activateParents = $activate;

        return $new;
    }

    public function getActivateParents(): bool
    {
        return $this->activateParents ?? $this->parent?->getActivateParents() ?? false;
    }

    public function activateParent(): void
    {
        if ($this->getActivateParents()) {
            $this->parent?->activateParent();
        }
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    protected function getVisibleItems(): iterable
    {
        $index = 0;

        foreach ($this->items as $item) {
            if ($item instanceof Link) {
                if ($item->isVisible()) {
                    yield $index++ => $item;
                }
            } elseif ($item instanceof Dropdown) {

                if ($item->getToggle() === null) {
                    throw new RuntimeException(
                        sprintf(
                            'Every child "%s" $item must contains a "toggle" property.',
                            Dropdown::class
                        )
                    );
                }

                if ($item->getToggle()->isVisible()) {
                    yield $index++ => $item;
                }

            } else {
                yield $index++ => $item;
            }
        }
    }

    protected function isLinkActive(Link $link, ?int $index): bool
    {
        $active = $this->getActiveItem();

        if ($link->isActive() || $active === null) {
            return $link->isActive();
        }

        if (is_int($active)) {
            return $active === $index;
        }

        return $link->getUrl() === $active || $link->getPath() === $active;
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
        if ($this->isLinkActive($link, $index)) {
            $link->activate();
            $this->activateParent();
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
