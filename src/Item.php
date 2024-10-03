<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;

/**
 * Item renders item for Tabs|Nav.
 *
 * {@see Link::item()} for details
 *
 * @psalm-suppress MissingConstructor
 */
final class Item extends Widget
{
    private Link $link;

    /**
     * @psalm-var non-empty-string $tag
     */
    private string $tag = 'li';
    private array $options = [];
    private ?string $widgetClassName = null;
    private ?Dropdown $dropdown = null;
    private DropDirection $dropDirection = DropDirection::Down;

    /**
     * @var self[]|Link[]
     */
    private array $items = [];

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    /**
     * @psalm-param non-empty-string $tag
     */
    public function tag(string $tag): self
    {
        $new = clone $this;
        $new->tag = $tag;

        return $new;
    }

    public function widgetClassName(?string $name): self
    {
        $new = clone $this;
        $new->widgetClassName = $name;

        return $new;
    }

    public function link(Link $link): self
    {
        $new = clone $this;
        $new->link = $link;

        return $new;
    }

    public function getLink(): Link
    {
        return $this->link;
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs-with-dropdowns
     */
    public function items(self|Link ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     *
     * @return self[]|Link[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function dropdown(?Dropdown $dropdown): self
    {
        $new = clone $this;
        $new->dropdown = $dropdown;

        return $new;
    }

    public function dropDirection(DropDirection $direction): self
    {
        $new = clone $this;
        $new->dropDirection = $direction;

        return $new;
    }

    /**
     * @psalm-suppress PossiblyUndefinedMethod
     */
    private function prepareDropdownItems(self|Link ...$items): array
    {
        $array = [];

        foreach ($items as $i => $item) {

            $isItem = $item instanceof self;
            /** @var Link $link */
            $link = $isItem ? $item->getLink() : $item;

            $array[$i] = [
                'label' => $link->getLabel(),
                'encode' => $link->isEncoded(),
                'url' => $link->getUrl(),
                'active' => $link->isActive(),
                'disabled' => $link->isDisabled(),
                'visible' => $link->isVisible(),
            ];

            if ($isItem) {
                $array[$i]['items'] = $this->prepareDropdownItems(...$item->getItems());
            }
        }

        return $array;
    }

    private function prepareDropdown(self|Link ...$items): ?Dropdown
    {
        $items = $this->prepareDropdownItems(...$items);

        if ($items === []) {
            return null;
        }

        /** @var Dropdown $dropdown */
        $dropdown = $this->dropdown ?? Dropdown::widget();

        return $dropdown->items($items);
    }

    public function render(): string
    {
        if (!$this->link->isVisible()) {
            return '';
        }

        $link = $this->link;
        $options = $this->options;
        $classNames = $this->widgetClassName ? ['widget' => $this->widgetClassName] : [];

        if ($this->link->getPane() && !isset($options['role'])) {
            $options['role'] = 'presentation';
        }

        if ($dropdown = $this->prepareDropdown(...$this->items)) {

            $classNames[] = $this->dropDirection->value;
            $addOptions = [
                'class' => 'dropdown-toggle',
                'aria-expanded' => 'false',
            ];

            if ($link->getTag() !== 'button') {
                $addOptions['role'] = 'button';
            }

            $link = $link->toggle('dropdown')
                         ->addOptions($addOptions);
        }

        Html::addCssClass($options, $classNames);

        return Html::tag($this->tag, $link . $dropdown, $options)
                ->encode(false)
                ->render();
    }
}
