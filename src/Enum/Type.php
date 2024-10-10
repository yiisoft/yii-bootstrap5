<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

/**
 * Is an enumeration of types for bootstrap5.
 */
enum Type: string
{
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';
    case LIGHT = 'light';
    case DARK = 'dark';
}
