<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Variants for the dropdown toggle component.
 *
 * - `PRIMARY`: The primary variant.
 * - `SECONDARY`: The secondary variant.
 * - `SUCCESS`: The success variant.
 * - `DANGER`: The danger variant.
 * - `WARNING`: The warning variant.
 * - `INFO`: The info variant.
 * - `LIGHT`: The light variant.
 * - `LINK`: The link variant.
 * - `DARK`: The dark variant.
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
}
