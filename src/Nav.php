<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

/**
 * Nav renders an nav bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Nav::widget()
 *     ->activeItem('/path-2')
 *     ->items(
 *          Link::widget()->url('/path-1')->label('Label 1'),
 *          Link::widget()->url('/path-2')->label(Html::img('src.jpg'))->encode(false),
 *          Dropdown::widget()
 *              ->toggle(
 *                  Link::widget()->label('Label 3')
 *              )
 *              ->items(
 *                  Link::widget()->url('/dropdown/path-1')->label('Label 4'),
 *                  Link::widget()->url('/dropdown/path-2')->label('Label 5'),
 *              )
 *     );
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/
 *
 * @psalm-suppress MethodSignatureMismatch
 */
final class Nav extends AbstractNav
{
    protected MenuType $type = MenuType::Nav;
}
