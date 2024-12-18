<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\NavStyles;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `Nav` widget.
 *
 * @group nav
 */
final class NavTest extends \PHPUnit\Framework\TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" data-test="test">
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
                ->addAttributes(['data-test' => 'test'])
                ->items(
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $navWidget = Nav::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->items(
                NavLink::item('Active', '#', active: true),
                NavLink::item('Link', url: '#'),
                NavLink::item('Link', url: '#'),
                NavLink::item('Disabled', '#', disabled: true),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav test-class bg-primary">
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
            $navWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav test-class bg-primary test-class-1 test-class-2">
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
            $navWidget->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $navWidget = Nav::widget()
            ->addCssStyle(['color' => 'red'])
            ->items(
                NavLink::item('Active', '#', active: true),
                NavLink::item('Link', url: '#'),
                NavLink::item('Link', url: '#'),
                NavLink::item('Disabled', '#', disabled: true),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" style="color: red;">
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
            $navWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" style="color: red; font-weight: bold;">
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
            $navWidget->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $navWidget = Nav::widget()
            ->addCssStyle(['color' => 'red'])
            ->items(
                NavLink::item('Active', '#', active: true),
                NavLink::item('Link', url: '#'),
                NavLink::item('Link', url: '#'),
                NavLink::item('Disabled', '#', disabled: true),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" style="color: red;">
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
            $navWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" style="color: red;">
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
            $navWidget->addCssStyle('color: blue;', false)->render(),
        );
    }

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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#base-nav
     */
    public function testBaseNavWithTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="nav">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            <a class="nav-link" href="#">Link</a>
            <a class="nav-link" href="#">Link</a>
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </nav>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->tag('nav')
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav custom-class another-class bg-primary">
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
                ->addClass('test-class')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->items(
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#horizontal-alignment
     */
    public function testHorizontalAlignment(): void
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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::HORIZONTAL_ALIGNMENT)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $navWidget = Nav::widget();

        $this->assertNotSame($navWidget, $navWidget->addAttributes([]));
        $this->assertNotSame($navWidget, $navWidget->addClass(''));
        $this->assertNotSame($navWidget, $navWidget->addCssStyle(''));
        $this->assertNotSame($navWidget, $navWidget->class(''));
        $this->assertNotSame($navWidget, $navWidget->items(NavLink::item('')));
        $this->assertNotSame($navWidget, $navWidget->styles(NavStyles::FILL));
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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
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
                    NavLink::item('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        ),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#fill-and-justify
     */
    public function testPillsWithFill(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Much longer nav link</a>
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
                    NavLink::item('Active', '#', active: true),
                    Navlink::item('Much longer nav link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS, NavStyles::FILL)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#fill-and-justify
     */
    public function testPillsWithJustify(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Much longer nav link</a>
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
                    NavLink::item('Active', '#', active: true),
                    Navlink::item('Much longer nav link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS, NavStyles::JUSTIFY)
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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
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
                    NavLink::item('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        ),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
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
                    NavLink::item('Active', '#', active: true),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Link', url: '#'),
                    NavLink::item('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::VERTICAL)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#working-with-flex-utilities
     */
    public function testWorkingWithFlexUtilities(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            <a class="nav-link active" href="#" aria-current="page">Longer nav link</a>
            <a class="nav-link" href="#">Link</a>
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </nav>
            HTML,
            Nav::widget()
                ->addClass('flex-sm-row')
                ->items(
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Longer nav link', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyles::PILLS, NavStyles::VERTICAL)
                ->tag('nav')
                ->render(),
        );
    }
}
