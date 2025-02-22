<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Variants for the dropdown toggle component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
 */
enum DropdownTogglerVariant: string
{
    /**
     * The primary variant.
     */
    case PRIMARY = 'btn-primary';
    /**
     * The secondary variant.
     */
    case SECONDARY = 'btn-secondary';
    /**
     * The success variant.
     */
    case SUCCESS = 'btn-success';
    /**
     * The danger variant.
     */
    case DANGER = 'btn-danger';
    /**
     * The warning variant.
     */
    case WARNING = 'btn-warning';
    /**
     * The info variant.
     */
    case INFO = 'btn-info';
    /**
     * The light variant.
     */
    case LIGHT = 'btn-light';
    /**
     * The link variant.
     */
    case LINK = 'btn-link';
    /**
     * The dark variant.
     */
    case DARK = 'btn-dark';
}
