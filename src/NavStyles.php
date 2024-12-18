<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 *  Styles for the nav component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/navs-tabs/#horizontal-alignment
 */
enum NavStyles: string
{
    case FILL = 'nav-fill';
    case HORIZONTAL_ALIGNMENT = 'justify-content-center';
    case JUSTIFY = 'nav-justified';
    case PILLS = 'nav-pills';
    case TABS = 'nav-tabs';
    case UNDERLINE = 'nav-underline';
    case VERTICAL = 'flex-column';
}
