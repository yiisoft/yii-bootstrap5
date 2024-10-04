<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

/**
 * Nav renders an nav bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Nav::widget()
 *     ->activeItem('/path-2')
 *     ->links(
 *          Link::widget()->url('/path-1')->label('Label 1'),
 *          Link::widget()->url('/path-2')->label(Html::img('src.jpg'))->encode(false),
 *     );
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/
 *
 * @psalm-suppress MethodSignatureMismatch
 */
final class Nav extends AbstractNav
{
    use NavTrait;

    protected MenuType $type = MenuType::Nav;

    protected function prepareNav(): Tag
    {
        $tag = parent::prepareNav();

        if ($this->vertical) {
            return $tag->addClass($this->vertical->formatClassName('flex', 'column'));
        }

        return $tag;
    }
}
