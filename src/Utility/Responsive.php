<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Utility;

/**
 * Responsive utilities.
 *
 * @see https://getbootstrap.com/docs/5.3/extend/approach/#responsive
 */
enum Responsive: string
{
    /**
     * Extra small devices (portrait phones, less than 576px).
     */
    case SM = 'sm';
    /**
     * Small devices (landscape phones, 576px and up).
     */
    case MD = 'md';
    /**
     * Medium devices (tablets, 768px and up).
     */
    case LG = 'lg';
    /**
     * Large devices (desktops, 992px and up).
     */
    case XL = 'xl';
    /**
     * Extra large devices (large desktops, 1200px and up).
     */
    case XXL = 'xxl';
}
