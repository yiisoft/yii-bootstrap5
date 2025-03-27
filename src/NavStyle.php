<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 *  Styles for the nav component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/navs-tabs/#horizontal-alignment
 */
enum NavStyle: string
{
    /**
     * Take that same HTML, but use `.nav-borders` instead.
     */
    case FILL = 'nav-fill';
    /**
     * Change the horizontal alignment of your nav with flexbox utilities. By default, navs are left-aligned, but you
     * can change them to center or right-aligned.
     */
    case HORIZONTAL_ALIGNMENT = 'justify-content-center';
    /**
     * All horizontal space will be occupied by nav links, but unlike the `.nav-fill` above, every nav item will be the
     * same width.
     */
    case JUSTIFY = 'nav-justified';
    /**
     * Horizontal navigation component for the top of an application. It is the most common navigation pattern for
     * desktop apps. Use it with `.navbar-nav` to apply the default styling.
     */
    case NAVBAR = 'navbar-nav me-auto mb-2 mb-lg-0';
    /**
     * Take that same HTML, but use `.nav-pills` instead.
     */
    case PILLS = 'nav-pills';
    /**
     * Takes the basic nav from above and adds the `.nav-tabs` class to generate a tabbed interface. Use them to create
     * tabbable regions with our tab JavaScript plugin.
     */
    case TABS = 'nav-tabs';
    /**
     * Take that same HTML, but use `.nav-underline` instead.
     */
    case UNDERLINE = 'nav-underline';
    /**
     * Stack your navigation by changing the flex item direction with the `.flex-column` utility. Need to stack them on
     * some viewports but not others? Use the responsive versions (e.g., `.flex-sm-column`).
     */
    case VERTICAL = 'flex-column';
}
