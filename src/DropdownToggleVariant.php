<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Variants for the dropdown toggle component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
 */
enum DropdownToggleVariant: string
{
    case PRIMARY = 'btn-primary';
    case SECONDARY = 'btn-secondary';
    case SUCCESS = 'btn-success';
    case DANGER = 'btn-danger';
    case WARNING = 'btn-warning';
    case INFO = 'btn-info';
    case LIGHT = 'btn-light';
    case LINK = 'btn-link';
    case DARK = 'btn-dark';
    case NAV_LINK = 'nav-link';
}
