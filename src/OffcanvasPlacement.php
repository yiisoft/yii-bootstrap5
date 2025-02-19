<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * The placement of a Bootstrap5 offcanvas.
 *
 * @see https://getbootstrap.com/docs/5.3/components/offcanvas/#placement
 */
enum OffcanvasPlacement: string
{
    /**
     * Places offcanvas on the bottom of the viewport.
     */
    case BOTTOM = 'offcanvas-bottom';
    /**
     * Places offcanvas on the right of the viewport
     */
    case END = 'offcanvas-end';
    /**
     * Places offcanvas on the left of the viewport (shown above).
     */
    case START = 'offcanvas-start';
    /**
     * Places offcanvas on the top of the viewport.
     */
    case TOP = 'offcanvas-top';
}
