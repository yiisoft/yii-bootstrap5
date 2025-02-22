<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\NavStyle;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `Nav` widget.
 */
#[Group('nav')]
final class NavTest extends TestCase
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $navWidget = Nav::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->items(
                NavLink::to('Active', '#', active: true),
                NavLink::to('Link', url: '#'),
                NavLink::to('Link', url: '#'),
                NavLink::to('Disabled', '#', disabled: true),
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
                NavLink::to('Active', '#', active: true),
                NavLink::to('Link', url: '#'),
                NavLink::to('Link', url: '#'),
                NavLink::to('Disabled', '#', disabled: true),
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
                NavLink::to('Active', '#', active: true),
                NavLink::to('Link', url: '#'),
                NavLink::to('Link', url: '#'),
                NavLink::to('Disabled', '#', disabled: true),
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

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav" data-test="test">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->attributes(['data-test' => 'test'])
                ->items(NavLink::to('Active', '#', active: true))
                ->render(),
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->render(),
        );
    }

    public function testCurrentPath(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="/test/link" aria-current="page">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link/another-link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->currentPath('/test/link')
                ->items(
                    NavLink::to('Active', '/test'),
                    NavLink::to('Link', '/test/link'),
                    NavLink::to('Link', '/test/link/another-link'),
                    NavLink::to('Disabled', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testCurrentPathAndActivateItemsWithFalseValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">Active</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link/another-link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->activateItems(false)
                ->currentPath('/test/link')
                ->items(
                    NavLink::to('Active', '/test'),
                    NavLink::to('Link', '/test/link'),
                    NavLink::to('Link', '/test/link/another-link'),
                    NavLink::to('Disabled', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testDropdownAndCurrentPath(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">Active</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="/test/link/action">Action</a>
            </li>
            <li>
            <a class="dropdown-item active" href="/test/link/another-action" aria-current="true">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/something-else">Something else here</a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/separated-link">Separated link</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->currentPath('/test/link/another-action')
                ->items(
                    NavLink::to('Active', '/test'),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '/test/link/action'),
                            DropdownItem::link('Another action', '/test/link/another-action'),
                            DropdownItem::link('Something else here', '/test/link/something-else'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '/test/link/separated-link'),
                        )
                        ->togglerContent('Dropdown'),
                    NavLink::to('Link', '/test/link'),
                    NavLink::to('Disabled', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testDropdownAndCurrentPathAndActivateItemsWithFalseValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">Active</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="/test/link/action">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/another-action">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/something-else">Something else here</a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/separated-link">Separated link</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->activateItems(false)
                ->currentPath('/test/link/another-action')
                ->items(
                    NavLink::to('Active', '/test'),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '/test/link/action'),
                            DropdownItem::link('Another action', '/test/link/another-action'),
                            DropdownItem::link('Something else here', '/test/link/something-else'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '/test/link/separated-link'),
                        )
                        ->togglerContent('Dropdown'),
                    NavLink::to('Link', '/test/link'),
                    NavLink::to('Disabled', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testDropdownExplicitActive(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">Active</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="/test/link/action">Action</a>
            </li>
            <li>
            <a class="dropdown-item active" href="/test/link/another-action" aria-current="true">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/something-else">Something else here</a>
            </li>
            <li>
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="/test/link/separated-link">Separated link</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/test/link">Link</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::to('Active', '/test'),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '/test/link/action'),
                            DropdownItem::link('Another action', '/test/link/another-action', active: true),
                            DropdownItem::link('Something else here', '/test/link/something-else'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '/test/link/separated-link'),
                        )
                        ->togglerContent('Dropdown'),
                    NavLink::to('Link', '/test/link'),
                    NavLink::to('Disabled', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testEncodeLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test">&lt;b&gt;Active&lt;/b&gt;</a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true">&lt;b&gt;Disabled&lt;b&gt;</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::to('<b>Active</b>', '/test'),
                    NavLink::to('<b>Disabled<b>', '/test/disabled', disabled: true),
                )
                ->render(),
        );
    }

    public function testEncodeLabelWithFalseValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/test"><b>Active</b></a>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="/test/disabled" aria-disabled="true"><b>Disabled<b></a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::to('<b>Active</b>', '/test', encodeLabel: false),
                    NavLink::to('<b>Disabled<b>', '/test/disabled', disabled: true, encodeLabel: false),
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::HORIZONTAL_ALIGNMENT)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $navWidget = Nav::widget();

        $this->assertNotSame($navWidget, $navWidget->activateItems(false));
        $this->assertNotSame($navWidget, $navWidget->addAttributes([]));
        $this->assertNotSame($navWidget, $navWidget->addClass(''));
        $this->assertNotSame($navWidget, $navWidget->addCssStyle(''));
        $this->assertNotSame($navWidget, $navWidget->attributes([]));
        $this->assertNotSame($navWidget, $navWidget->class(''));
        $this->assertNotSame($navWidget, $navWidget->currentPath(''));
        $this->assertNotSame($navWidget, $navWidget->fade(false));
        $this->assertNotSame($navWidget, $navWidget->items(NavLink::to('')));
        $this->assertNotSame($navWidget, $navWidget->paneAttributes([]));
        $this->assertNotSame($navWidget, $navWidget->styles(NavStyle::TABS));
    }

    public function testNavLinkWithAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item" data-test="test">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(NavLink::to('Active', '#', active: true, attributes: ['data-test' => 'test']))
                ->render(),
        );
    }

    public function testNavLinkWithUrlAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link active" href="#" data-test="test" aria-current="page">Active</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(NavLink::to('Active', '#', active: true, urlAttributes: ['data-test' => 'test']))
                ->render(),
        );
    }

    public function testNavLinkWithVisibleFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="nav">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            </ul>
            HTML,
            Nav::widget()
                ->items(
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Invisible', '#', visible: false),
                )
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::PILLS)
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
                    NavLink::to('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        )
                        ->togglerContent('Dropdown'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::PILLS)
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
                    NavLink::to('Active', '#', active: true),
                    Navlink::to('Much longer nav link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::PILLS, NavStyle::FILL)
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
                    NavLink::to('Active', '#', active: true),
                    Navlink::to('Much longer nav link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::PILLS, NavStyle::JUSTIFY)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#javascript-behavior
     */
    public function testPillsWithNavLinkTab(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul id="pills-tab" class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
            <button type="button" id="pills-home-tab" class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-home-tab-pane" role="tab" aria-controls="pills-home-tab-pane" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="pills-profile-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-profile-tab-pane" role="tab" aria-controls="pills-profile-tab-pane" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="pills-contact-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-contact-tab-pane" role="tab" aria-controls="pills-contact-tab-pane" aria-selected="false">Contact</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="pills-disabled-tab" class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-disabled-tab-pane" role="tab" aria-controls="pills-disabled-tab-pane" aria-selected="false">Disabled</button>
            </li>
            </ul>
            <div class="tab-content">
            <div id="pills-home-tab-pane" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">This is some placeholder content the Home tab's associated content.</div>
            <div id="pills-profile-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">This is some placeholder content the Profile tab's associated content.</div>
            <div id="pills-contact-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">This is some placeholder content the Contact tab's associated content.</div>
            <div id="pills-disabled-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">This is some placeholder content the Disabled tab's associated content.</div>
            </div>
            HTML,
            Nav::widget()
                ->addClass('mb-3')
                ->id('pills-tab')
                ->items(
                    NavLink::tab(
                        'Home',
                        "This is some placeholder content the Home tab's associated content.",
                        true,
                        paneId: 'pills-home-tab',
                    ),
                    NavLink::tab(
                        'Profile',
                        "This is some placeholder content the Profile tab's associated content.",
                        paneId: 'pills-profile-tab',
                    ),
                    NavLink::tab(
                        'Contact',
                        "This is some placeholder content the Contact tab's associated content.",
                        paneId: 'pills-contact-tab',
                    ),
                    NavLink::tab(
                        'Disabled',
                        "This is some placeholder content the Disabled tab's associated content.",
                        paneId: 'pills-disabled-tab',
                    ),
                )
                ->styles(NavStyle::PILLS)
            ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#supported-content
     */
    public function testNavBar(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::NAVBAR)
                ->render(),
        );
    }

    public function testRenderWithEmptyItems(): void
    {
        $this->assertEmpty(Nav::widget()->render());
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::TABS)
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
                    NavLink::to('Active', '#', active: true),
                    Dropdown::widget()
                        ->items(
                            DropdownItem::link('Action', '#'),
                            DropdownItem::link('Another action', '#'),
                            DropdownItem::link('Something else here', '#'),
                            DropdownItem::divider(),
                            DropdownItem::link('Separated link', '#'),
                        )
                        ->togglerContent('Dropdown'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::TABS)
            ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#javascript-behavior
     */
    public function testTabsWithNavLinkTab(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <ul id="nav-tabs" class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
            <button type="button" id="home-tab" class="nav-link active" data-bs-toggle="tab" data-bs-target="#home-tab-pane" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="profile-tab" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="contact-tab" class="nav-link" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Contact</button>
            </li>
            <li class="nav-item" role="presentation">
            <button type="button" id="disabled-tab" class="nav-link" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Disabled</button>
            </li>
            </ul>
            <div class="tab-content">
            <div id="home-tab-pane" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" tabindex="0">This is some placeholder content the Home tab's associated content.</div>
            <div id="profile-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">This is some placeholder content the Profile tab's associated content.</div>
            <div id="contact-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">This is some placeholder content the Contact tab's associated content.</div>
            <div id="disabled-tab-pane" class="tab-pane fade" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">This is some placeholder content the Disabled tab's associated content.</div>
            </div>
            HTML,
            Nav::widget()
                ->id('nav-tabs')
                ->items(
                    NavLink::tab(
                        'Home',
                        "This is some placeholder content the Home tab's associated content.",
                        true,
                        paneId: 'home-tab',
                    ),
                    NavLink::tab(
                        'Profile',
                        "This is some placeholder content the Profile tab's associated content.",
                        paneId: 'profile-tab',
                    ),
                    NavLink::tab(
                        'Contact',
                        "This is some placeholder content the Contact tab's associated content.",
                        paneId: 'contact-tab',
                    ),
                    NavLink::tab(
                        'Disabled',
                        "This is some placeholder content the Disabled tab's associated content.",
                        paneId: 'disabled-tab',
                    ),
                )
                ->styles(NavStyle::TABS)
            ->render(),
        );
    }

    public function testThrowExceptionForFadeWithoutTabsOrPills(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Fade effect can only be used with tabs or pills.');

        Nav::widget()->fade(true)->render();
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::UNDERLINE)
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
                    NavLink::to('Active', '#', active: true),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Link', url: '#'),
                    NavLink::to('Disabled', '#', disabled: true),
                )
                ->styles(NavStyle::VERTICAL)
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
                ->styles(NavStyle::PILLS, NavStyle::VERTICAL)
                ->tag('nav')
                ->render(),
        );
    }
}
