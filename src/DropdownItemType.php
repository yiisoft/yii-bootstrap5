<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 * Defines the types of items that can be used in a Bootstrap dropdown.
 *
 * @see \Yiisoft\Bootstrap5\DropdownItem
 */
enum DropdownItemType: string
{
    /**
     * A clickable button item.
     */
    case BUTTON = 'button';
    /**
     * Custom HTML content item.
     */
    case CUSTOM_CONTENT = 'custom-content';
    /**
     * A horizontal divider line.
     */
    case DIVIDER = 'divider';
    /**
     * A header item for grouping other items.
     */
    case HEADER = 'header';
    /**
     * A standard link item.
     */
    case LINK = 'link';
    /**
     * A text-only item.
     */
    case TEXT = 'text';
}
