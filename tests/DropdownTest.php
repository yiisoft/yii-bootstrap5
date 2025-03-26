<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Yii\Bootstrap5\ButtonSize;
use Yiisoft\Yii\Bootstrap5\ButtonVariant;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownAlignment;
use Yiisoft\Yii\Bootstrap5\DropdownAutoClose;
use Yiisoft\Yii\Bootstrap5\DropdownDirection;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `Dropdown` widget.
 */
#[Group('dropdown')]
final class DropdownTest extends TestCase
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

    public function testAddTogglerClass(): void
    {
        $dropdownWidget = Dropdown::widget()
            ->addTogglerClass('test-class', null, BackgroundColor::PRIMARY)
            ->items(
                DropdownItem::link('Action', '#'),
                DropdownItem::link('Another action', '#'),
                DropdownItem::link('Something else here', '#'),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle test-class bg-primary" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle test-class bg-primary test-class-1 test-class-2" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
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
            $dropdownWidget->addTogglerClass('test-class-1', 'test-class-2')->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentDefault(): void
    {
        // Dropdown with alignment set to `DropdownAlignment::END`
        $dropdownWidget = Dropdown::widget()
            ->items(
                DropdownItem::link('Menu Item', '#'),
                DropdownItem::link('Menu Item', '#'),
                DropdownItem::link('Menu Item', '#'),
            )
            ->alignment(DropdownAlignment::END)
            ->togglerContent('Right-aligned menu');

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
            $dropdownWidget->render(),
        );

        // Dropdown with alignment set to default
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Right-aligned menu</button>
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
            $dropdownWidget->alignment(null)->render(),
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
                ->togglerContent('Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentSMEnd(): void
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
                ->togglerContent('SM Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentMDEnd(): void
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
                ->togglerContent('MD Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentLGEnd(): void
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
                ->togglerContent('LG Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentXLEnd(): void
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
                ->togglerContent('XL Right-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#alignment-options
     */
    public function testAlignmentXXLEnd(): void
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
                ->togglerContent('XXL Right-aligned menu')
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
                ->togglerContent('SM Left-aligned menu')
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
                ->togglerContent('MD Left-aligned menu')
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
                ->togglerContent('LG Left-aligned menu')
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
                ->togglerContent('XL Left-aligned menu')
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
                ->togglerContent('XXL Left-aligned menu')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoClose(): void
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
                ->autoClose(DropdownAutoClose::TRUE)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->togglerContent('Default dropdown')
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
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="inside" data-bs-toggle="dropdown" aria-expanded="false">Clickable inside</button>
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
                ->autoClose(DropdownAutoClose::INSIDE)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->togglerContent('Clickable inside')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#auto-close-behavior
     */
    public function testAutoCloseOnClickWithManual(): void
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
                ->autoClose(DropdownAutoClose::FALSE)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->togglerContent('Manual close')
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
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">Clickable outside</button>
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
                ->autoClose(DropdownAutoClose::OUTSIDE)
                ->items(
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                    DropdownItem::link('Menu Item', '#'),
                )
                ->togglerContent('Clickable outside')
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

    public function testContainerClasses(): void
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
                ->containerClasses('test-class')
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

    public function testDropdownItemWithListContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <share class="dropdown-item text-nowrap" :link="fullLocation" v-memo="[fullLocation]" url="https://api.whatsapp.com/send?text={title} {link}"><svg class="me-2 rounded-circle bi" width="1rem" height="1rem" style="background-color: #25D366;" viewbox="0 0 16 16" fill="#fff"><use xlink:href="/assets/74b80618/bootstrap-icons.svg#whatsapp"></use></svg>WhatsApp</share>
            </li>
            </ul>
            </div>
            HTML,
            Dropdown::widget()
                ->items(
                    DropdownItem::listContent(
                        <<<HTML
                        <share class="dropdown-item text-nowrap" :link="fullLocation" v-memo="[fullLocation]" url="https://api.whatsapp.com/send?text={title} {link}"><svg class="me-2 rounded-circle bi" width="1rem" height="1rem" style="background-color: #25D366;" viewbox="0 0 16 16" fill="#fff"><use xlink:href="/assets/74b80618/bootstrap-icons.svg#whatsapp"></use></svg>WhatsApp</share>
                        HTML
                    ),
                )
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
        $this->assertNotSame($dropdownWidget, $dropdownWidget->attribute('', ''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->attributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->autoClose(DropdownAutoClose::TRUE));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->class(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->container(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->containerClasses(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->direction(DropdownDirection::DROPSTART));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->items(DropdownItem::link('')));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->theme('light'));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggler(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerAsLink(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerAttributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerClass(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerContent(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerId(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerSize(ButtonSize::SMALL));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerSplit(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerSplitContent(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerUrl(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->togglerVariant(ButtonVariant::DANGER));
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
                    DropdownItem::button('Action'),
                    DropdownItem::button('Another action'),
                    DropdownItem::button('Something else here'),
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
                    DropdownItem::link('Active link', '#')->active(true),
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
                    DropdownItem::link('Disabled link', '#')->disabled(true),
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
                    DropdownItem::button('Action'),
                    DropdownItem::button('Another action'),
                    DropdownItem::button('Something else here'),
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

    public function testNavBar(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <hr class="dropdown-divider">
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
                    DropdownItem::divider(),
                    DropdownItem::link('Something else here', '#'),
                )
                ->togglerAsLink()
                ->togglerClass('nav-link', 'dropdown-toggle')
                ->togglerContent('Dropdown')
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
                ->togglerAsLink()
                ->togglerContent('Dropdown link')
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
                ->togglerAsLink()
                ->togglerContent('Dropdown link')
                ->togglerVariant(ButtonVariant::DANGER)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#single-button
     */
    public function testSingleButtonWithVariantOutlineDanger(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <a class="btn btn-outline-danger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown link</a>
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
                ->togglerAsLink()
                ->togglerContent('Dropdown link')
                ->togglerVariant(ButtonVariant::OUTLINE_DANGER)
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
                ->togglerContent('Light dropdown')
                ->togglerId('dropdownLight')
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
                ->togglerContent('Dark dropdown')
                ->togglerId('dropdownDark')
                ->render(),
        );
    }

    public function testThrowExceptionForDropdownItemWithHeaderAndTagEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The header tag cannot be empty.');

        Dropdown::widget()->items(DropdownItem::header('content', headerTag: ''))->render();
    }

    public function testThrowExceptionForDropdownItemWithHeaderAndTagEmptyValueMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The header tag cannot be empty.');

        Dropdown::widget()->items(DropdownItem::header('content')->headerTag(''))->render();
    }

    public function testThrowExceptionForDropdownItemWithLinkAndActiveAndDisabledValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        Dropdown::widget()->items(DropdownItem::link('label', 'url', active: true, disabled: true))->render();
    }

    public function testThrowExceptionForDropdownItemWithLinkAndActiveAndDisabledValueMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        Dropdown::widget()->items(DropdownItem::link('label', 'url')->active(true)->disabled(true))->render();
    }

    public function testThrowExceptionForDropdownItemWithLinkAndActiveAndDisabledValueAndMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        Dropdown::widget()->items(DropdownItem::link('label', 'url', disabled: true)->active(true))->render();
    }

    public function testToggler(): void
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
                ->toggler(
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

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropdown-options
     */
    public function testTogglerAttributesWithDataBSoffset(): void
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
                ->togglerAttributes(['data-bs-offset' => '10,20'])
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#dropdown-options
     */
    public function testTogglerAttributesWithLinkAndDataBSoffset(): void
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
                ->togglerAsLink()
                ->togglerAttributes(['data-bs-offset' => '10,20'])
                ->render(),
        );
    }

    public function testTogglerAttributesWithSplitAndDataBSReference(): void
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
                ->togglerAttributes(['data-bs-reference' => 'parent'])
                ->togglerContent('Toggle dropdown')
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->render(),
        );
    }

    public function testTogglerId(): void
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
                ->togglerId('test-id')
                ->render(),
        );
    }

    public function testTogglerSizeLarge(): void
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
                ->togglerContent('Large button')
                ->togglerSize(ButtonSize::LARGE)
                ->render(),
        );
    }

    public function testTogglerSizeSmall(): void
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
                ->togglerContent('Small button')
                ->togglerSize(ButtonSize::SMALL)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#split-button
     */
    public function testTogglerSplit(): void
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
                ->togglerContent('Toggle dropdown')
                ->togglerVariant(ButtonVariant::DANGER)
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#sizing
     */
    public function testTogglerSplitWithSizeLarge(): void
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
                ->togglerContent('Toggle dropdown')
                ->togglerVariant(ButtonVariant::DANGER)
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->togglerSize(ButtonSize::LARGE)
                ->render(),
        );
    }

    public function testTogglerSplitWithLink(): void
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
                ->togglerAsLink()
                ->togglerContent('Toggle dropdown')
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->togglerVariant(ButtonVariant::DANGER)
                ->render(),
        );
    }

    public function testTogglerSplitWithLinkAndSizeLarge(): void
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
                ->togglerAsLink()
                ->togglerContent('Toggle dropdown')
                ->togglerSize(ButtonSize::LARGE)
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->togglerVariant(ButtonVariant::DANGER)
                ->render(),
        );
    }

    public function testTogglerSplitWithLinkAndSizeSmall(): void
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
                ->togglerAsLink()
                ->togglerContent('Toggle dropdown')
                ->togglerSize(ButtonSize::SMALL)
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->togglerVariant(ButtonVariant::DANGER)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/dropdowns/#sizing
     */
    public function testTogglerSplitWithSizeSmall(): void
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
                ->togglerContent('Toggle dropdown')
                ->togglerSize(ButtonSize::SMALL)
                ->togglerSplit()
                ->togglerSplitContent('Danger')
                ->togglerVariant(ButtonVariant::DANGER)
                ->render(),
        );
    }
}
