<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * The expand sizes for a Bootstrap5 navbar.
 *
 * @see https://getbootstrap.com/docs/5.3/components/navbar/#how-it-works
 */
enum NavBarExpand: string
{
    /**
     * Expand on small devices (≥576px).
     */
    case SM = 'navbar-expand-sm';
    /**
     * Expand on medium devices (≥768px).
     */
    case MD = 'navbar-expand-md';
    /**
     * Expand on large devices (≥992px).
     */
    case LG = 'navbar-expand-lg';
    /**
     * Expand on extra large devices (≥1200px).
     */
    case XL = 'navbar-expand-xl';
    /**
     * Expand on extra extra large devices (≥1400px).
     */
    case XXL = 'navbar-expand-xxl';
}
