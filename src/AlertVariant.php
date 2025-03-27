<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 * Variants for the alert component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/alerts/#examples
 */
enum AlertVariant: string
{
    /**
     * Primary variant.
     */
    case PRIMARY = 'alert-primary';
    /**
     * Secondary variant.
     */
    case SECONDARY = 'alert-secondary';
    /**
     * Success variant.
     */
    case SUCCESS = 'alert-success';
    /**
     * Danger variant.
     */
    case DANGER = 'alert-danger';
    /**
     * Warning variant.
     */
    case WARNING = 'alert-warning';
    /**
     * Info variant.
     */
    case INFO = 'alert-info';
    /**
     * Light variant.
     */
    case LIGHT = 'alert-light';
    /**
     * Dark variant.
     */
    case DARK = 'alert-dark';
}
