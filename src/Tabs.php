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
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/
 *
 * @psalm-suppress MethodSignatureMismatch
 */
final class Tabs extends AbstractNav
{
    /**
     * @psalm-var non-empty-string $tag
     */
    private string $contentTag = 'div';
    protected MenuType $type = MenuType::Tabs;
    private array $contentOptions = [];
    private bool $renderContent = true;
    protected int|string|null $activeItem = 0;

    /**
     * @psalm-param non-empty-string $tag
     */
    public function contentTag(string $tag): self
    {
        $new = clone $this;
        $new->contentTag = $tag;

        return $new;
    }

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

    protected function prepareMenu(string $item, string ...$items): Tag
    {
        return parent::prepareMenu($item, ...$items)
                ->attribute('role', 'tablist');
    }

    protected function prepareLink(Link $link, int $index): Link
    {
        $link = parent::prepareLink($link, $index);

        if ($link->getPane() === null) {
            return $link;
        }

        return $link->toggle($this->type->toggleComponent());
    }

    public function render(): string
    {
        $tabs = parent::render();

        if ($tabs !== '' && $this->renderContent) {
            $tabs .= $this->renderTabContent();
        }

        return $tabs;
    }

    public function renderTabContent(): string
    {
        $panes = [];

        /** @var Dropdown|Link $item */
        foreach ($this->getVisibleItems() as $item) {
            /** @var Link $link */
            $link = $item instanceof Dropdown ? $item->getToggle() : $item;

            if ($pane = $link->getPane()) {
                $panes[] = $pane->render();
            }
        }

        if ($panes === []) {
            return '';
        }

        $options = $this->contentOptions;

        Html::addCssClass($options, ['widget' => 'tab-content']);

        return Html::tag($this->contentTag)
                ->attributes($options)
                ->content(...$panes)
                ->encode(false)
                ->render();
    }
}
