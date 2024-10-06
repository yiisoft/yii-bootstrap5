<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\DropAlignment;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Enum\Theme;

final class Dropdown extends AbstractMenu
{
    protected MenuType $type = MenuType::Dropdown;
    private ?Link $toggle = null;
    private bool|Link $split = false;
    private DropDirection $direction = DropDirection::Down;
    private array $alignments = [];
    private bool $encode = false;

    public function items(string|Stringable ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    protected function activateParent(): void
    {
        $this->toggle?->activate();

        parent::activateParent();
    }

    public function toggle(?Link $toggle): self
    {
        $new = clone $this;
        $new->toggle = $toggle;

        return $new;
    }

    public function getToggle(): ?Link
    {
        return $this->toggle;
    }

    public function split(bool|Link $split): self
    {
        $new = clone $this;
        $new->split = $split;

        return $new;
    }

    public function direction(DropDirection $direction): self
    {
        $new = clone $this;
        $new->direction = $direction;

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

    private function prepareToggle(): ?Link
    {
        if ($this->toggle === null) {
            return null;
        }

        if ($this->split === true) {
            $toggle = $this->toggle
                           ->encode(false)
                           ->label(Html::span('Toggle Dropdown', ['class' => 'visually-hidden']))
                           ->widgetClassName('dropdown-toggle-split');
        } elseif ($this->split) {
            $toggle = $this->split;
        } else {
            $toggle = $this->toggle;
        }

        $parent = $this->getParent();
        $options = ['aria-expanded' => 'false'];

        if ($parent instanceof self) {
            $options['class'] = 'dropdown-item dropdown-toggle';
            $options['data-bs-auto-close'] = 'outside';
            $options['aria-haspopup'] = 'true';

            if (!$this->split) {
                $toggle = $toggle->item($this->getDefaultItem());
            }

        } else {
            $options['class'] = 'dropdown-toggle';
        }

        if ($toggle->getTag() !== 'button') {
            $options['role'] = 'button';
        }

        return $toggle->toggle($this->type->toggleComponent())
                ->addOptions($options);
    }

    protected function prepareLink(Link $link, int $index): Link
    {
        $link = parent::prepareLink($link, $index);

        if ($link->getUrl() === null) {

            if (empty($link->getLabel())) {
                return $link->widgetClassName('dropdown-divider', true);
            }

            return $link->widgetClassName('dropdown-header', true);
        }

        return $link;
    }

    protected function prepareMenu(): Tag
    {
        $classNames = [];
        $tag = parent::prepareMenu();
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

        if ($menu === '') {
            return $menu;
        }

        if ($toggleButton = $this->prepareToggle()) {

            if (!$toggleButton->isVisible()) {
                return '';
            }

            if ($this->split) {
                $splitButton = $toggleButton;
                $item = $this->toggle?->getItem();
                $itemClassName = MenuType::BtnGroup->value . ' ' . $this->direction->value;
            } else {
                $splitButton = null;
                $item = $toggleButton->getItem();
                $itemClassName = $this->direction->value;
            }

            if ($item === null) {
                return $toggleButton . $splitButton . $menu;
            }

            return $item->begin(['class' => $itemClassName]) . $splitButton . $menu . $item::end();
        }

        return $menu;
    }

    /**
     * @param string|Stringable $item
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function renderItem(mixed $item, int $index): string
    {
        if ($item instanceof Link) {
            $link = $this->prepareLink($item, $index);

            return ($link->getItem() ?? $link)->render();
        }

        if ($item instanceof self) {
            return $item->setParent($this)->render();
        }

        return $this->encode ? Html::encode($item) : (string)$item;
    }
}
