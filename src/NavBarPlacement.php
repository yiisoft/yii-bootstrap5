<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 * The placement of a Bootstrap5 navbar.
 *
 * @see https://getbootstrap.com/docs/5.3/components/navbar/#placement
 */
enum NavBarPlacement: string
{
    /**
     * Fixed to the bottom of the viewport.
     */
    case FIXED_BOTTOM = 'fixed-bottom';
    /**
     * Fixed to the top of the viewport.
     */
    case FIXED_TOP = 'fixed-top';
    /**
     * Sticks to the bottom of the viewport when scrolling.
     */
    case STICKY_BOTTOM = 'sticky-bottom';
    /**
     * Sticks to the top of the viewport when scrolling.
     */
    case STICKY_TOP = 'sticky-top';
}
