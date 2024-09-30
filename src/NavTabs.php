<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Override;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\NavType;

final class NavTabs extends AbstractNav
{
    protected ?NavType $type = NavType::Tabs;
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

        /** @var NavType $type */
        $type = $this->type ?? NavType::Tabs;

        return $link->toggle($type->toggleComponent());
    }

    public function renderTabContent(): string
    {
        $panes = [];
        $options = $this->contentOptions;

        Html::addCssClass($options, ['widget' => 'tab-content']);

        foreach ($this->getVisibleLinks() as $link) {
            $panes[] = (string)$link->getPane();
        }

        return Html::div(implode('', $panes), $options)
                ->encode(false)
                ->render();
    }
}
