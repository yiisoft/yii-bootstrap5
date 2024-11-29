<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Button;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownDirection;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\DropdownToggleVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Dropdown` widget.
 *
 * @group dropdown
 */
final class DropdownTest extends \PHPUnit\Framework\TestCase
{
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
        $this->assertNotSame($dropdownWidget, $dropdownWidget->attributes([]));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->class(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->container(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->containerClass(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->direction(DropdownDirection::DROPSTART));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->id(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->itemTag('button'));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->items(new DropdownItem('')));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->theme('light'));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleButton(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleContent(''));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleLink(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSizeLarge());
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSizeSmall());
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSplit(false));
        $this->assertNotSame($dropdownWidget, $dropdownWidget->toggleSplitContent(''));
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
                ->itemTag('button')
                ->items(
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Regular link', '#'),
                    new DropdownItem('Active link', '#', active: true),
                    new DropdownItem('Another link', '#'),
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
                    new DropdownItem('Regular link', '#'),
                    new DropdownItem('Disabled link', '#', disabled: true),
                    new DropdownItem('Another link', '#'),
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
                ->itemTag('button')
                ->items(
                    new DropdownItem('Dropdown item text', text: true),
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Dropdown item text', text: true),
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->render(),
        );
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->toggleContent('Dropdown link')
                ->toggleLink()
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->toggleContent('Dropdown link')
                ->toggleLink()
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->id('dropdownLight')
                ->theme('light')
                ->toggleContent('Light dropdown')
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->id('dropdownDark')
                ->theme('dark')
                ->toggleContent('Dark dropdown')
                ->render(),
        );
    }

    public function testToggleButton(): void
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                )
                ->toggleButton(
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleLink()
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleLink()
                ->toggleSizeLarge()
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleLink()
                ->toggleSizeSmall()
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
                    new DropdownItem('Action', '#'),
                    new DropdownItem('Another action', '#'),
                    new DropdownItem('Something else here', '#'),
                    new DropdownItem(divider: true),
                    new DropdownItem('Separated link', '#'),
                )
                ->toggleContent('Toggle dropdown')
                ->toggleVariant(DropdownToggleVariant::DANGER)
                ->toggleSplit()
                ->toggleSplitContent('Danger')
                ->toggleSizeSmall()
                ->render(),
        );
    }
}
