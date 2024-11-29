<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Utility;

/**
 * Background colors.
 *
 * @see https://getbootstrap.com/docs/5.3/utilities/background/#background-color
 */
enum BackgroundColor: string
{
    case BLACK = 'bg-black';
    case BODY = 'bg-body';
    case BODY_SECONDARY = 'bg-body-secondary';
    case BODY_TERTIARY = 'bg-body-tertiary';
    case DANGER = 'bg-danger';
    case DANGER_SUBTLE = 'bg-danger-subtle';
    case DARK = 'bg-dark';
    case DARK_SUBTLE = 'bg-dark-subtle';
    case INFO = 'bg-info';
    case INFO_SUBTLE = 'bg-info-subtle';
    case LIGHT = 'bg-light';
    case LIGHT_SUBTLE = 'bg-light-subtle';
    case PRIMARY = 'bg-primary';
    case PRIMARY_SUBTLE = 'bg-primary-subtle';
    case SECONDARY = 'bg-secondary';
    case SECONDARY_SUBTLE = 'bg-secondary-subtle';
    case SUCCESS = 'bg-success';
    case SUCCESS_SUBTLE = 'bg-success-subtle';
    case TRANSPARENT = 'bg-transparent';
    case WARNING = 'bg-warning';
    case WARNING_SUBTLE = 'bg-warning-subtle';
    case WHITE = 'bg-white';
}
