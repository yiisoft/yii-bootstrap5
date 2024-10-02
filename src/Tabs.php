<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

final class Tabs extends AbstractMenu
{
    use NavTrait;

    protected MenuType $type = MenuType::Tabs;
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
        $tag = parent::prepareNav()->attribute('role', 'tablist');

        if ($this->vertical) {
            return $tag->addClass($this->vertical->formatClassName('flex', 'column'));
        }

        return $tag;
    }

    protected function prepareLink(Link $link, int $index): Link
    {
        $link = parent::prepareLink($link, $index);

        if ($link->getPane() === null) {
            return $link;
        }

        return $link->toggle($this->type->toggleComponent());
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
