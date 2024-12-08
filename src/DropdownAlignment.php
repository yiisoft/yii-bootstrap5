<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Alignment for the dropdown component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
 */
enum DropdownAlignment: string
{
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle.
     */
    case END = 'dropdown-menu-end';
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle on the small breakpoint.
     */
    case SM_END = 'dropdown-menu-sm-end';
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle on the medium breakpoint.
     */
    case MD_END = 'dropdown-menu-md-end';
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle on the large breakpoint.
     */
    case LG_END = 'dropdown-menu-lg-end';
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle on the extra-large breakpoint.
     */
    case XL_END = 'dropdown-menu-xl-end';
    /**
     * Aligns the dropdown menu to the end of the dropdown toggle on the extra-extra-large breakpoint.
     */
    case XXL_END = 'dropdown-menu-xxl-end';
    /**
     * Aligns the dropdown menu to the start of the dropdown toggle.
     */
    case SM_START = 'dropdown-menu-sm-start';
    /**
     * Aligns the dropdown menu to the start of the dropdown toggle on the medium breakpoint.
     */
    case MD_START = 'dropdown-menu-md-start';
    /**
     * Aligns the dropdown menu to the start of the dropdown toggle on the large breakpoint.
     */
    case LG_START = 'dropdown-menu-lg-start';
    /**
     * Aligns the dropdown menu to the start of the dropdown toggle on the extra-large breakpoint.
     */
    case XL_START = 'dropdown-menu-xl-start';
    /**
     * Aligns the dropdown menu to the start of the dropdown toggle on the extra-extra-large breakpoint.
     */
    case XXL_START = 'dropdown-menu-xxl-start';
}
