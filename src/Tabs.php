<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

/**
 * Tabs renders an tabs, pills or underline bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Tabs::widget()
 *     ->items(
 *          Link::widget()->url('/path-1')->label('Label 1'),
 *          Link::widget()->url('/path-2')->label(Html::img('src.jpg'))->encode(false),
 *          Dropdown::widget()
 *              ->toggle(
 *                  Link::widget()->label('Child Dropdown')
 *              )
 *              ->items(
 *                  Link::widget()->url('/child-1')->label('Child 1'),
 *                  Link::widget()->url('/child-2')->label('Child 2'),
 *              )
 *     );
 * ```
 *
 * or
 *
 * ```php
 * $tabs = Tabs::widget()
 *     ->renderContent(false)
 *     ->items(
 *          Link::widget()
 *              ->label('Label 1')
 *              ->pane(
 *                  TabPane::widget()->content('Content for tab 1')
 *              ),
 *          Link::widget()
 *              ->url('/some-url')
 *              ->label(Html::img('src.jpg'))
 *              ->encode(false),
 *     );
 *
 * echo $tabs;
 * echo Alert::widget()->body('Body');
 * echo $tabs->renderTabContent();
 *
 * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/
 *
 * @psalm-suppress MethodSignatureMismatch
 */
final class Tabs extends AbstractNav
{
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

    protected function prepareMenu(): Tag
    {
        return parent::prepareMenu()->attribute('role', 'tablist');
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

        /** @var Link $link */
        foreach ($this->getVisibleItems() as $link) {
            $panes[] = (string)$link->getPane();
        }

        return Html::div(implode('', $panes), $options)
                ->encode(false)
                ->render();
    }
}
