<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Direction for the dropdown component.
 *
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
