<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Utility;

/**
 * Background colors.
 *
 * @see https://getbootstrap.com/docs/5.3/utilities/background/#background-color
 */
enum BackgroundColor: string
{
    /**
     * Black background color.
     */
    case BLACK = 'bg-black';
    /**
     * White background color.
     */
    case BODY = 'bg-body';
    /**
     * Secondary body background color.
     */
    case BODY_SECONDARY = 'bg-body-secondary';
    /**
     * Tertiary body background color.
     */
    case BODY_TERTIARY = 'bg-body-tertiary';
    /**
     * Dark background color.
     */
    case DANGER = 'bg-danger';
    /**
     * Subtle dark background color.
     */
    case DANGER_SUBTLE = 'bg-danger-subtle';
    /**
     * Dark background color.
     */
    case DARK = 'bg-dark';
    /**
     * Subtle dark background color.
     */
    case DARK_SUBTLE = 'bg-dark-subtle';
    /**
     * Info background color.
     */
    case INFO = 'bg-info';
    /**
     * Subtle info background color.
     */
    case INFO_SUBTLE = 'bg-info-subtle';
    /**
     * Light background color.
     */
    case LIGHT = 'bg-light';
    /**
     * Subtle light background color.
     */
    case LIGHT_SUBTLE = 'bg-light-subtle';
    /**
     * Primary background color.
     */
    case PRIMARY = 'bg-primary';
    /**
     * Subtle primary background color.
     */
    case PRIMARY_SUBTLE = 'bg-primary-subtle';
    /**
     * Secondary background color.
     */
    case SECONDARY = 'bg-secondary';
    /**
     * Subtle secondary background color.
     */
    case SECONDARY_SUBTLE = 'bg-secondary-subtle';
    /**
     * Success background color.
     */
    case SUCCESS = 'bg-success';
    /**
     * Subtle success background color.
     */
    case SUCCESS_SUBTLE = 'bg-success-subtle';
    /**
     * Transparent background color.
     */
    case TRANSPARENT = 'bg-transparent';
    /**
     * Warning background color.
     */
    case WARNING = 'bg-warning';
    /**
     * Subtle warning background color.
     */
    case WARNING_SUBTLE = 'bg-warning-subtle';
    /**
     * White background color.
     */
    case WHITE = 'bg-white';
}
