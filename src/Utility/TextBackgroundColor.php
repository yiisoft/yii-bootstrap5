<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Utility;

/**
 * Text background color enum.
 *
 * @see https://getbootstrap.com/docs/5.3/helpers/color-background/
 */
enum TextBackgroundColor: string
{
    /**
     * "Primary text" color background.
     */
    case PRIMARY = 'text-bg-primary';
    /**
     * "Secondary text" color background.
     */
    case SECONDARY = 'text-bg-secondary';
    /**
     * "Success text" color background.
     */
    case SUCCESS = 'text-bg-success';
    /**
     * "Danger text" color background.
     */
    case DANGER = 'text-bg-danger';
    /**
     * "Warning text" color background.
     */
    case WARNING = 'text-bg-warning';
    /**
     * "Info text" color background.
     */
    case INFO = 'text-bg-info';
    /**
     * "Light text" color background.
     */
    case LIGHT = 'text-bg-light';
    /**
     * "Dark text" color background.
     */
    case DARK = 'text-bg-dark';
}
