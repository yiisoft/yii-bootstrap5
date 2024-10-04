<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Generator;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\DropAlignment;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Enum\Theme;

use function array_unshift;
use function get_debug_type;
use function is_string;
use function sprintf;

final class Dropdown extends AbstractMenu
{
    protected MenuType $type = MenuType::Dropdown;
    private ?Link $toggler = null;
    private bool $separate = false;
    private DropDirection $direction = DropDirection::Down;
    private ?self $parent = null;
    private array $alignments = [];
    private bool $encode = false;

    /**
     *
     * @param string|Stringable $items
     * @return static
     * @throws InvalidArgumentException
     */
    public function items(mixed ...$items): static
    {
        foreach ($items as $i => $item) {

            if (!is_string($item) && !$item instanceof Stringable) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"$item" must be instance of "%s" or string. "%s" given.',
                        Stringable::class,
                        get_debug_type($item)
                    )
                );
            }

            if ($item instanceof self) {
                $items[$i] = $item->parent($this);
            }
        }

        return parent::items(...$items);
    }

    public function toggler(?Link $toggler): self
    {
        $new = clone $this;
        $new->toggler = $toggler;

        return $new;
    }

    public function getToggler(): ?Link
    {
        return $this->toggler;
    }

    public function separate(bool $sepatate): self
    {
        $new = clone $this;
        $new->separate = $sepatate;

        return $new;
    }

    public function direction(DropDirection $direction): self
    {
        $new = clone $this;
        $new->direction = $direction;

        return $new;
    }

    public function parent(?self $parent): self
    {
        $new = clone $this;
        $new->parent = $parent;

        return $new;
    }

    public function alignments(DropAlignment $alignment, Size ...$sizes): self
    {
        $new = clone $this;

        if ($sizes) {
            $new->alignments[$alignment->value] = $sizes;
        } else {
            unset($new->alignments[$alignment->value]);
        }

        return $new;
    }

    public function encode(bool $encode): self
    {
        $new = clone $this;
        $new->encode = $encode;

        return $new;
    }

    final protected function getVisibleItems(): Generator
    {
        $index = 0;

        foreach ($this->getItems() as $item) {
            if (!$item instanceof Link || $item->isVisible()) {
                yield $index++ => $item;
            }
        }
    }

    protected function activateTree(Link $link, Link ...$parents): ?array
    {
        $links = parent::activateTree($link, ...$parents);

        if ($links && $this->toggler) {
            array_unshift($links, $this->toggler->activate());
        }

        return $links;
    }

    private function prepareToggler(): ?link
    {
        if ($this->toggler === null) {
            return null;
        }

        $options = ['aria-expanded' => 'false'];

        if ($this->parent) {
            $options['class'] = $this->type->linkClassName() . ' dropdown-toggle';
        } else {
            $options['class'] = 'dropdown-toggle';
        }

        if ($this->toggler->getTag() !== 'button') {
            $options['role'] = 'button';
        }

        if ($this->parent) {
            $options['data-bs-auto-close'] = 'outside';
            $options['aria-haspopup'] = 'true';
        }

        return parent::prepareLink($this->toggler, 0)
                ->toggle($this->type->toggleComponent())
                ->addOptions($options);
    }

    protected function prepareLink(Link $link, int $index): Link
    {
        $link = parent::prepareLink($link, $index);
        $tag = $link->getTag();

        if ($link->getUrl() === null) {

            if (empty($link->getLabel())) {
                return $link->widgetClassName('dropdown-divider', true);
            }

            return $link->widgetClassName('dropdown-header', true);
        }

        return $link;
    }

    protected function prepareNav(): Tag
    {
        $classNames = [];
        $tag = parent::prepareNav();
        $prefix = MenuType::Dropdown->value;

        foreach ($this->alignments as $name => $sizes) {
            /** @var Size $size */
            foreach ($sizes as $size) {
                $classNames[] = $size->formatClassName($prefix, $name);
            }
        }
        //BC with old version
        if ($this->theme === Theme::Dark->value) {
            $classNames[] = 'dropdown-menu-dark';
        }

        return $classNames ? $tag->addClass(...$classNames) : $tag;
    }

    public function render(): string
    {
        $menu = parent::render();
        $link = $this->prepareToggler();

        if ($menu === '' || $link === null) {
            return $menu;
        }

        if ($link) {

            if (!$link->isVisible()) {
                return '';
            }

            if (($item = $link->getItem()) === null) {
                return $link . $menu;
            }

            return $item->begin(['class' => $this->direction->value]) . $menu . $item::end();
        }

        return $menu;
    }

    protected function renderItem(mixed $item, int $index): string
    {
        if ($item instanceof Link) {
            $link = $this->prepareLink($item, $index);

            return ($link?->getItem() ?? $link)->render();
        }

        return $this->encode ? Html::encode($item) : (string)$item;
    }
}
