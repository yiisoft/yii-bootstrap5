<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Utility;

/**
 * Text colors.
 *
 * @see https://getbootstrap.com/docs/5.3/utilities/colors/#colors
 */
enum TextColor: string
{
    /**
     * Primary text color.
     */
    case PRIMARY = 'text-primary';
    /**
     * Primary text color with emphasis.
     */
    case PRIMARY_EMPHASIS = 'text-primary-emphasis';
    /**
     * Secondary text color.
     */
    case SECONDARY = 'text-secondary';
    /**
     * Secondary text color with emphasis.
     */
    case SECONDARY_EMPHASIS = 'text-secondary-emphasis';
    /**
     * Success text color.
     */
    case SUCCESS = 'text-success';
    /**
     * Success text color with emphasis.
     */
    case SUCCESS_EMPHASIS = 'text-success-emphasis';
    /**
     * Danger text color.
     */
    case DANGER = 'text-danger';
    /**
     * Danger text color with emphasis.
     */
    case DANGER_EMPHASIS = 'text-danger-emphasis';
    /**
     * Warning text color.
     */
    case WARNING = 'text-warning';
    /**
     * Warning text color with emphasis.
     */
    case WARNING_EMPHASIS = 'text-warning-emphasis';
    /**
     * Info text color.
     */
    case INFO = 'text-info';
    /**
     * Info text color with emphasis.
     */
    case INFO_EMPHASIS = 'text-info-emphasis';
    /**
     * Light text color.
     */
    case LIGHT = 'text-light';
    /**
     * Light text color with emphasis.
     */
    case LIGHT_EMPHASIS = 'text-light-emphasis';
    /**
     * Dark text color.
     */
    case DARK = 'text-dark';
    /**
     * Dark text color with emphasis.
     */
    case DARK_EMPHASIS = 'text-dark-emphasis';
    /**
     * Body text color.
     */
    case BODY = 'text-body';
    /**
     * Body text color with emphasis.
     */
    case BODY_EMPHASIS = 'text-body-emphasis';
    /**
     * Secondary body text color.
     */
    case BODY_SECONDARY = 'text-body-secondary';
    /**
     * Tertiary body text color.
     */
    case BODY_TERTIARY = 'text-body-tertiary';
    /**
     * Black text color.
     */
    case BLACK = 'text-black';
    /**
     * White text color.
     */
    case WHITE = 'text-white';
}
