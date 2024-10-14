<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Is an enumeration of types for the alert component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/alerts/#examples
 */
enum AlertType: string
{
    case PRIMARY = 'alert-primary';
    case SECONDARY = 'alert-secondary';
    case SUCCESS = 'alert-success';
    case DANGER = 'alert-danger';
    case WARNING = 'alert-warning';
    case INFO = 'alert-info';
    case LIGHT = 'alert-light';
    case DARK = 'alert-dark';
}
