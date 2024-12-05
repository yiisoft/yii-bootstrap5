<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Alignment for the dropdown component.
 *
 * - `END`: Aligns the dropdown menu to the end of the dropdown toggle.
 * - `SM_END`: Aligns the dropdown menu to the end of the dropdown toggle on the small breakpoint.
 * - `MD_END`: Aligns the dropdown menu to the end of the dropdown toggle on the medium breakpoint.
 * - `LG_END`: Aligns the dropdown menu to the end of the dropdown toggle on the large breakpoint.
 * - `XL_END`: Aligns the dropdown menu to the end of the dropdown toggle on the extra-large breakpoint.
 * - `XXL_END`: Aligns the dropdown menu to the end of the dropdown toggle on the extra-extra-large breakpoint.
 * - `SM_START`: Aligns the dropdown menu to the start of the dropdown toggle on the small breakpoint.
 * - `MD_START`: Aligns the dropdown menu to the start of the dropdown toggle on the medium breakpoint.
 * - `LG_START`: Aligns the dropdown menu to the start of the dropdown toggle on the large breakpoint.
 * - `XL_START`: Aligns the dropdown menu to the start of the dropdown toggle on the extra-large breakpoint.
 * - `XXL_START`: Aligns the dropdown menu to the start of the dropdown toggle on the extra-extra-large breakpoint.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
 */
enum DropdownAlignment: string
{
    case END = 'dropdown-menu-end';
    case SM_END = 'dropdown-menu-sm-end';
    case MD_END = 'dropdown-menu-md-end';
    case LG_END = 'dropdown-menu-lg-end';
    case XL_END = 'dropdown-menu-xl-end';
    case XXL_END = 'dropdown-menu-xxl-end';
    case SM_START = 'dropdown-menu-sm-start';
    case MD_START = 'dropdown-menu-md-start';
    case LG_START = 'dropdown-menu-lg-start';
    case XL_START = 'dropdown-menu-xl-start';
    case XXL_START = 'dropdown-menu-xxl-start';
}
