<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 * Direction for the dropdown component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#directions
 */
enum DropdownDirection: string
{
    /**
     * Make the dropdown menu centered below the toggle with `.dropdown-center` on the parent element.
     */
    case CENTERED = 'dropdown-center';
    /**
     * Trigger dropdown menus above elements by adding `.dropup` to the parent element.
     */
    case DROPUP = 'btn-group dropup';
    /**
     * Make the dropup menu centered above the toggle with `.dropup-center` on the parent element.
     */
    case DROPUP_CENTERED = 'dropup-center dropup';
    /**
     * Trigger dropdown menus at the right of the elements by adding `.dropend` to the parent element.
     */
    case DROPEND = 'btn-group dropend';
    /**
     * Trigger dropdown menus at the left of the elements by adding `.dropstart` to the parent element.
     */
    case DROPSTART = 'btn-group dropstart';
}
