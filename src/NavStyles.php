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
    case HORIZONTAL = 'nav justify-content-center';
    case PILLS = 'nav nav-pills';
    case TABS = 'nav nav-tabs';
    case UNDERLINE = 'nav nav-underline';
    case VERTICAL = 'nav flex-column';
}
