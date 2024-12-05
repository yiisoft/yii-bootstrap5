<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Button;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownAlignment;
use Yiisoft\Yii\Bootstrap5\DropdownDirection;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\DropdownToggleVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `Dropdown` widget.
 *
 * @group dropdown
 */
final class DropdownTest extends \PHPUnit\Framework\TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown" data-test="test">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->addAttributes(['data-test' => 'test'])
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $dropdownWidget = Dropdown::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->items(
                DropdownItem::link('Action', '#'),
                DropdownItem::link('Another action', '#'),
                DropdownItem::link('Something else here', '#'),
            );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown test-class bg-primary">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown test-class bg-primary test-class-1 test-class-2">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $dropdownWidget = Dropdown::widget()
            ->addCssStyle(['color' => 'red'])
            ->items(
                DropdownItem::link('Action', '#'),
                DropdownItem::link('Another action', '#'),
                DropdownItem::link('Something else here', '#'),
            );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown" style="color: red;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown" style="color: red; font-weight: bold;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $dropdownWidget = Dropdown::widget()
            ->addCssStyle(['color' => 'red'])
            ->items(
                DropdownItem::link('Action', '#'),
                DropdownItem::link('Another action', '#'),
                DropdownItem::link('Something else here', '#'),
            );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown" style="color: red;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
                <div class="dropdown" style="color: red;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
                </ul>
                </div>
                HTML,
            $dropdownWidget->addCssStyle('color: blue;', false)->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::END)
                ->toggleContent('Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAligmentSMEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">SM Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-sm-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::SM_END)
                ->toggleContent('SM Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAligmentMDEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">MD Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-md-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::MD_END)
                ->toggleContent('MD Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAligmentLGEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">LG Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-lg-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::LG_END)
                ->toggleContent('LG Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAligmentXLEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">XL Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-xl-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::XL_END)
                ->toggleContent('XL Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAligmentXXLEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">XXL Right-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-xxl-end">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::XXL_END)
                ->toggleContent('XXL Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentSMStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">SM Left-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-sm-start">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::SM_START)
                ->toggleContent('SM Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentMDStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">MD Left-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-md-start">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::MD_START)
                ->toggleContent('MD Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentLGStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">LG Left-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-lg-start">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::LG_START)
                ->toggleContent('LG Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentXLStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">XL Left-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-xl-start">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::XL_START)
                ->toggleContent('XL Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentXXLStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">XXL Left-aligned menu</button>
            <ul class="dropdown-menu dropdown-menu-xxl-start">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->alignment(DropdownAlignment::XXL_START)
                ->toggleContent('XXL Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoCloseOnClick(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="true" data-bs-toggle="dropdown" aria-expanded="false">Default dropdown</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->autoCloseOnClick(true)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->toggleContent('Default dropdown')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoCloseOnClickWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">Manual close</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->autoCloseOnClick(false)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->toggleContent('Manual close')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoCloseOnClickInside(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="inside" data-bs-toggle="dropdown" aria-expanded="false">Clickeable inside</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->autoCloseOnClickInside()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->toggleContent('Clickeable inside')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoCloseOnClickOutside(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">Clickeable outside</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Menu Item</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->autoCloseOnClickOutside()
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->toggleContent('Clickeable outside')
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown custom-class another-class">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->addClass('test-class')
                ->class('custom-class', 'another-class')
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    public function testContainerWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            HTML,
            Dropdown::widget()
                ->container(false)
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    public function testContainerClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="test-class">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->containerClass('test-class')
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#centered
     */
    public function testDirectionWithCentered(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown-center">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->direction(DropdownDirection::CENTERED)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropup
     */
    public function testDirectionWithDropup(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropup">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->direction(DropdownDirection::DROPUP)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropup-centered
     */
    public function testDirectionWithDropupCentered(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropup-center dropup">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->direction(DropdownDirection::DROPUP_CENTERED)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropend
     */
    public function testDirectionWithDropend(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropend">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->direction(DropdownDirection::DROPEND)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropstart
     */
    public function testDirectionWithDropstart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group dropstart">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->direction(DropdownDirection::DROPSTART)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $dropdownWidget = Dropdown::widget();

        $this->assertNotSame($dropdownWidget, $dropdownWidget->addAttributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->addClass(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->addCssStyle([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->alignment(DropdownAlignment::END));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->attributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->autoCloseOnClick(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->autoCloseOnClickInside(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->autoCloseOnClickOutside(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->class(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->container(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->containerClass(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->direction(DropdownDirection::DROPSTART));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->items(new DropdownItem('')));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->theme('light'));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleAsLink(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleAttributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleContent(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleId(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSizeLarge());
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSizeSmall());
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSplit(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSplitContent(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleTag(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleUrl(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleVariant(DropdownToggleVariant::DANGER));
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-items
     */
    public function testMenuItemsWithButtons(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <button type="button" class="dropdown-item">Action</button>
            </li>
            <li>
            <button type="button" class="dropdown-item">Another action</button>
            </li>
            <li>
            <button type="button" class="dropdown-item">Something else here</button>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#', button: true),
                    DropdownItem::link('Another action', '#', button: true),
                    DropdownItem::link('Something else here', '#', button: true),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#active
     */
    public function testMenuItemsWithDropdownItemActive(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Regular link</a>
            </li>
            <li>
            <a class="dropdown-item active" href="#" aria-current="true">Active link</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another link</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Regular link', '#'),
                    DropdownItem::link('Active link', '#', active: true),
                    DropdownItem::link('Another link', '#'),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#disabled
     */
    public function testMenuItemsWithDropdownItemDisabled(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Regular link</a>
            </li>
            <li>
            <a class="dropdown-item disabled" href="#" aria-disabled="true">Disabled link</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another link</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Regular link', '#'),
                    DropdownItem::link('Disabled link', '#', disabled: true),
                    DropdownItem::link('Another link', '#'),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-items
     */
    public function testMenuItemsWithDropdownItemButtonWithText(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <span class="dropdown-item-text">Dropdown item text</span>
            </li>
            <li>
            <button type="button" class="dropdown-item">Action</button>
            </li>
            <li>
            <button type="button" class="dropdown-item">Another action</button>
            </li>
            <li>
            <button type="button" class="dropdown-item">Something else here</button>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::text('Dropdown item text'),
                    DropdownItem::link('Action', '#', button: true),
                    DropdownItem::link('Another action', '#', button: true),
                    DropdownItem::link('Something else here', '#', button: true),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-items
     */
    public function testMenuItemsWithDropdownItemWithHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <h6 class="dropdown-header">Dropdown header</h6>
            </li>
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::header('Dropdown header'),
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-items
     */
    public function testMenuItemsWithDropdownItemWithText(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <span class="dropdown-item-text">Dropdown item text</span>
            </li>
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::text('Dropdown item text'),
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertEmpty(Dropdown::widget()->render());
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
     */
    public function testSingleButton(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
     */
    public function testSingleButtonWithLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown link</a>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleAsLink()
                ->toggleContent('Dropdown link')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
     */
    public function testSingleButtonWithVariantDanger(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <a class="btn btn-danger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown link</a>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleAsLink()
                ->toggleContent('Dropdown link')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/customize/color-modes/
     */
    public function testThemeLight(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown" data-bs-theme="light">
            <button type="button" id="dropdownLight" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Light dropdown</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownLight">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->theme('light')
                ->toggleContent('Light dropdown')
                ->toggleId('dropdownLight')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/customize/color-modes/
     */
    public function testThemeDark(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown" data-bs-theme="dark">
            <button type="button" id="dropdownDark" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dark dropdown</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownDark">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->theme('dark')
                ->toggleContent('Dark dropdown')
                ->toggleId('dropdownDark')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropdown-options
     */
    public function testToggleAttributesWithDataBSoffset(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-offset="10,20" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleAttributes(['data-bs-offset' => '10,20'])
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropdown-options
     */
    public function testToggleAttributesWithLinkAndDataBSoffset(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" data-bs-offset="10,20" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</a>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleAsLink()
                ->toggleAttributes(['data-bs-offset' => '10,20'])
                ->render(),
        );
    }

    public function testToggleAttributesWithSplitAndDataBSReference(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-secondary">Danger</button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-reference="parent" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </button>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleAttributes(['data-bs-reference' => 'parent'])
                ->toggleContent('Toggle dropdown')
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->render(),
        );
    }

    public function testToggleId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" id="test-id" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu" aria-labelledby="test-id">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleId('test-id')
                ->render(),
        );
    }

    public function testToggleSizeLarge(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Large button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleContent('Large button')
                ->toggleSizeLarge()
                ->render(),
        );
    }

    public function testToggleSizeSmall(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Small button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleContent('Small button')
                ->toggleSizeSmall()
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#split-button
     */
    public function testToggleSplit(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-danger">Danger</button>
            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </button>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#sizing
     */
    public function testToggleSplitWithSizeLarge(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-danger btn-lg">Danger</button>
            <button type="button" class="btn btn-danger btn-lg dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </button>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleSizeLarge()
                ->render(),
        );
    }

    public function testToggleSplitWithLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <a class="btn btn-danger" role="button">Danger</a>
            <a class="btn btn-danger dropdown-toggle dropdown-toggle-split" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </a>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleAsLink()
                ->toggleContent('Toggle dropdown')
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->render(),
        );
    }

    public function testToggleSplitWithLinkAndSizeLarge(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <a class="btn btn-danger btn-lg" role="button">Danger</a>
            <a class="btn btn-danger btn-lg dropdown-toggle dropdown-toggle-split" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </a>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleAsLink()
                ->toggleContent('Toggle dropdown')
                ->toggleSizeLarge()
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->render(),
        );
    }

    public function testToggleSplitWithLinkAndSizeSmall(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <a class="btn btn-danger btn-sm" role="button">Danger</a>
            <a class="btn btn-danger btn-sm dropdown-toggle dropdown-toggle-split" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </a>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleAsLink()
                ->toggleContent('Toggle dropdown')
                ->toggleSizeSmall()
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#sizing
     */
    public function testToggleSplitWithSizeSmall(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group">
            <button type="button" class="btn btn-danger btn-sm">Danger</button>
            <button type="button" class="btn btn-danger btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle dropdown</span>
            </button>
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
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                    DropdownItem::divider(),
                    DropdownItem::link('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleSizeSmall()
                ->render(),
        );
    }

    public function testToggleTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown custom button</button>
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
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::link('Action', '#'),
                    DropdownItem::link('Another action', '#'),
                    DropdownItem::link('Something else here', '#'),
                )
                ->toggleTag(
                    Button::tag()
                        ->addAttributes(
                            [
                                'data-bs-toggle' => 'dropdown',
                                'aria-expanded' => 'false',
                            ],
                        )
                        ->addClass('btn btn-primary dropdown-toggle')
                        ->content('Dropdown custom button')
                )
                ->render(),
        );
    }
}
