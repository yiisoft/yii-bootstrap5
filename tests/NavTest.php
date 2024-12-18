<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\NavStyles;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Nav` widget.
 *
 * @group nav
 */
final class NavTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#base-nav
     */
    public function testBaseNav(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#horizontal-alignment
     */
    public function testHorizontal(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav justify-content-center">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::HORIZONTAL)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#pills
     */
    public function testPills(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-pills">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#pills-with-dropdowns
     */
    public function testPillsWithDropdown(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-pills">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="#">Separated link</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        ),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs
     */
    public function testTabs(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-tabs">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::TABS)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs-with-dropdowns
     */
    public function testTabsWithDropdown(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-tabs">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="#">Separated link</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        ),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::TABS)
            ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#underline
     */
    public function testUnderline(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-underline">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::UNDERLINE)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#vertical
     */
    public function testVertical(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::create('Active', '#', active: true),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Link', url: '#'),
                    NavLink::create('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::VERTICAL)
                ->render(),
        );
    }
}
