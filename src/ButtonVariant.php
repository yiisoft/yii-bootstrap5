<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Variants for the {@see Button} component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/buttons/#variants
 * @see https://getbootstrap.com/docs/5.3/components/buttons/#outline-buttons
 */
enum ButtonVariant: string
{
    /**
     * Primary button variant.
     */
    case PRIMARY = 'btn-primary';
    /**
     * Secondary button variant.
     */
    case SECONDARY = 'btn-secondary';
    /**
     * Success button variant.
     */
    case SUCCESS = 'btn-success';
    /**
     * Danger button variant.
     */
    case DANGER = 'btn-danger';
    /**
     * Warning button variant.
     */
    case WARNING = 'btn-warning';
    /**
     * Info button variant.
     */
    case INFO = 'btn-info';
    /**
     * Light button variant.
     */
    case LIGHT = 'btn-light';
    /**
     * Link button variant.
     */
    case LINK = 'btn-link';
    /**
     * Dark button variant.
     */
    case DARK = 'btn-dark';
    /**
     * Outline primary button variant.
     */
    case OUTLINE_PRIMARY = 'btn-outline-primary';
    /**
     * Outline secondary button variant.
     */
    case OUTLINE_SECONDARY = 'btn-outline-secondary';
    /**
     * Outline success button variant.
     */
    case OUTLINE_SUCCESS = 'btn-outline-success';
    /**
     * Outline danger button variant.
     */
    case OUTLINE_DANGER = 'btn-outline-danger';
    /**
     * Outline warning button variant.
     */
    case OUTLINE_WARNING = 'btn-outline-warning';
    /**
     * Outline info button variant.
     */
    case OUTLINE_INFO = 'btn-outline-info';
    /**
     * Outline light button variant.
     */
    case OUTLINE_LIGHT = 'btn-outline-light';
    /**
     * Outline dark button variant.
     */
    case OUTLINE_DARK = 'btn-outline-dark';
}
