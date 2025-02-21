<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Utility;

/**
 * Toggler types.
 */
enum TogglerType: string
{
    /**
     * Button toggle type.
     */
    case BUTTON = 'button';
    /**
     * Collapse toggle type.
     */
    case COLLAPSE = 'collapse';
    /**
     * Dropdown toggle type.
     */
    case DROPDOWN = 'dropdown';
    /**
     * Modal toggle type.
     */
    case MODAL = 'modal';
    /**
     * Popover toggle type.
     */
    case POPOVER = 'popover';
    /**
     * Tooltip toggle type.
     */
    case TOOLTIP = 'tooltip';
}
