<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Auto close behavior for dropdowns.
 *
 * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
 */
enum DropdownAutoClose: string
{
    /**
     * The dropdown will be closed by clicking outside or inside the dropdown menu.
     */
    case TRUE = 'true';
    /**
     * The dropdown will be closed by clicking the toggle button and manually calling hide or toggle method.
     * (Also will not be closed by pressing `Esc` key)
     */
    case FALSE = 'false';
    /**
     * The dropdown will be closed (only) by clicking inside the dropdown menu.
     */
    case INSIDE = 'inside';
    /**
     * The dropdown will be closed (only) by clicking outside the dropdown menu.
     */
    case OUTSIDE = 'outside';
}
