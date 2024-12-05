<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Direction for the dropdown component.
 *
 * - `CENTERED`: Make the dropdown menu centered below the toggle with `.dropdown-center` on the parent element.
 * - `DROPUP`: Trigger dropdown menus above elements by adding `.dropup` to the parent element.
 * - `DROPUP_CENTERED`: Make the dropup menu centered above the toggle with `.dropup-center` on the parent element.
 * - `DROPEND`: Trigger dropdown menus at the right of the elements by adding `.dropend` to the parent element.
 * - `DROPSTART`: Trigger dropdown menus at the left of the elements by adding `.dropstart` to the parent element.
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#directions
 */
enum DropdownDirection: string
{
    case CENTERED = 'dropdown-center';
    case DROPUP = 'btn-group dropup';
    case DROPUP_CENTERED = 'dropup-center dropup';
    case DROPEND = 'btn-group dropend';
    case DROPSTART = 'btn-group dropstart';
}
