<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

final class NavTabs extends AbstractNav
{
    protected ?string $type = self::NAV_TABS;
    private array $contentOptions = [];
    private bool $renderContent = true;
    protected int|string|null $activeItem = 0;

    public function tabContentOptions(array $options): self
    {
        $new = clone $this;
        $new->contentOptions = $options;

        return $new;
    }

    public function renderContent(bool $render): self
    {
        $new = clone $this;
        $new->renderContent = $render;

        return $new;
    }

    public function render(): string
    {
        $tabs = parent::render();

        if ($tabs !== '' && $this->renderContent) {
            $tabs .= $this->renderTabContent();
        }

        return $tabs;
    }

    protected function prepareNav(): Tag
    {
        return parent::prepareNav()->attribute('role', 'tablist');
    }

    protected function prepareLink(NavLink $link, int $index): NavLink
    {
        $link = parent::prepareLink($link, $index);

        if ($link->getPane() === null) {
            return $link;
        }

        $type = $this->type === self::NAV_PILLS ? 'pill' : 'tab';

        return $link->setOption('data-bs-toggle', $type);
    }

    public function renderTabContent(): string
    {
        $panes = [];
        $options = $this->contentOptions;

        Html::addCssClass($options, ['widget' => 'tab-content']);

        foreach ($this->getVisibleItems() as $item) {
            if ($item instanceof NavItem) {
                $panes[] = (string)$item->getLink()->getPane();
            } else {
                $panes[] = (string)$item->getPane();
            }
        }

        return Html::div(implode('', $panes), $options)
                ->encode(false)
                ->render();
    }
}
