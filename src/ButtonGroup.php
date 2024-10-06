<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Generator;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;
use Yiisoft\Html\Tag\Label;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;

/**
 * ButtonGroup renders a button group bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo ButtonGroup::widget()
 *     ->item([
 *         Link::widget()->label('button-A'),
           Link::widget()->label('button-B'),
           Link::widget()->label('button-C')->visible(false),
           Link::widget()->label('button-D')
 *     ]);
 *
 *
 * echo ButtonGroup::widget()
 *     ->items([
 *         Checkbox::tag()->id('btncheck1')->sideLabel('Checkbox 1', ['class' => 'btn btn-outline-primary']),
 *         Checkbox::tag()->id('btncheck2')->sideLabel('Checkbox 2', ['class' => 'btn btn-outline-primary']),
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
final class ButtonGroup extends AbstractMenu
{
    /**
     * @psalm-var non-empty-string $tag
     */
    protected string $tag = 'div';
    protected bool|Item $defaultItem = false;
    protected MenuType $type = MenuType::BtnGroup;
    private ?Size $size = null;

    public function items(Radio|Checkbox|Label|Dropdown|Link ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/button-group/#vertical-variation
     */
    public function vertical(bool $vertical): self
    {
        $new = clone $this;
        $new->type = $vertical ? MenuType::BtnGroupVertical : MenuType::BtnGroup;

        return $new;
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/button-group/#sizing
     */
    public function small(): self
    {
        return $this->size(Size::Small);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/button-group/#sizing
     */
    public function large(): self
    {
        return $this->size(Size::Large);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/button-group/#sizing
     */
    public function normal(): self
    {
        return $this->size(null);
    }

    private function size(?Size $size): self
    {
        $new = clone $this;
        $new->size = $size;

        return $new;
    }

    public function activateParent(): void
    {
        if ($this->getActivateParents()) {
            $this->getParent()?->activateParent();
        }
    }

    protected function prepareMenu(): Tag
    {
        $tag = parent::prepareMenu()->attribute('role', 'group');

        if ($this->size) {
            return $tag->addClass($this->size->formatClassName('btn-group'));
        }

        return $tag;
    }

    /**
     * @param Radio|Checkbox|Label|Dropdown|Link $item
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    protected function renderItem(mixed $item, int $index): string
    {
        return match (true) {
            $item instanceof Checkbox || $item instanceof Radio => $item->addClass('btn-check')->render(),
            $item instanceof Label => $item->render(),
            $item instanceof Dropdown => $this->renderDropdown($item),
            default => $this->prepareLink($item, $index)->render()
        };
    }

    private function renderDropdown(Dropdown $dropdown): string
    {
        $toggle = $dropdown->getToggle();

        /** @var Item $item */
        /** @psalm-suppress PossiblyNullReference */
        $item = $toggle->getItem() ?? Item::widget()->tag($this->tag);

        return $dropdown->toggle(
            $toggle->item(
                $item->widgetClassName($this->type->itemClassName())
            )
        )
        ->setParent($this)
        ->render();
    }
}
