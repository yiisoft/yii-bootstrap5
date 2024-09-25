<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

final class NavItem extends Widget
{
    private NavLink $link;
    private string $tag = 'li';
    private array $options = [];
    private ?Dropdown $dropdown = null;

    /**
     * @var self[]|NavLink[]
     */
    private array $items = [];

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    public function tag(string $tag): self
    {
        $new = clone $this;
        $new->tag = $tag;

        return $new;
    }

    public function links(NavLink $link, self|NavLink ...$items): self
    {
        $new = clone $this;
        $new->link = $link;
        $new->items = $items;

        return $new;
    }

    public function getLink(): NavLink
    {
        return $this->link;
    }

    /**
     *
     * @return self[]|NavLink[]
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

    private function prepareDropdownItems(self|NavLink ...$items): array
    {
        $array = [];

        foreach ($items as $i => $item) {

            $isItem = $item instanceof self;
            /** @var NavLink $link */
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

    private function prepareDropdown(self|NavLink ...$items): ?Dropdown
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
        $link = $this->link;

        if (!$link->isVisible()) {
            return '';
        }

        $options = $this->options;
        $classNames = ['widget' => 'nav-item'];

        if ($this->link->getPane() && !isset($options['role'])) {
            $options['role'] = 'presentation';
        }

        if ($dropdown = $this->prepareDropdown(...$this->items)) {

            $classNames[] = 'dropdown';
            $link = $link->setOption('data-bs-toggle', 'dropdown')
                         ->setOption('aria-expanded', 'false')
                         ->addClassNames('dropdown-toggle');

            if ($link->getTag() !== 'button') {
                $link = $link->setOption('role', 'button');
            }
        }

        Html::addCssClass($options, $classNames);

        return Html::tag($this->tag, $link . $dropdown, $options)
                ->encode(false)
                ->render();
    }
}
