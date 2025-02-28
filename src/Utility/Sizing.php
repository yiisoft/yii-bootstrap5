<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Utility;

/**
 * Width and height utilities.
 *
 * @see https://getbootstrap.com/docs/5.3/utilities/sizing/
 */
enum Sizing: string
{
    /**
     * Width auto.
     */
    case WIDTH_AUTO = 'w-auto';
    /**
     * Width 25%.
     */
    case WIDTH_25 = 'w-25';
    /**
     * Width 50%.
     */
    case WIDTH_50 = 'w-50';
    /**
     * Width 75%.
     */
    case WIDTH_75 = 'w-75';
    /**
     * Width 100%.
     */
    case WIDTH_100 = 'w-100';
    /**
     * Height auto.
     */
    case HEIGHT_AUTO = 'h-auto';
    /**
     * Height 25%.
     */
    case HEIGHT_25 = 'h-25';
    /**
     * Height 50%.
     */
    case HEIGHT_50 = 'h-50';
    /**
     * Height 75%.
     */
    case HEIGHT_75 = 'h-75';
    /**
     * Height 100%.
     */
    case HEIGHT_100 = 'h-100';
}
