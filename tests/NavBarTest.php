<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Img;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavBar;
use Yiisoft\Yii\Bootstrap5\NavBarExpand;
use Yiisoft\Yii\Bootstrap5\NavBarPlacement;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\NavStyle;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `NavBar` widget.
 *
 * @group navbar
 */
final class NavBarTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#text
     */
    public function testBrandText(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#text
     */
    public function testBrandTextAsLink(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->brandUrl('#')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">NavBar</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#image
     */
    public function testBrandAsImage(): void
    {
        $html = NavBar::widget()
            ->brandImage('/docs/5.3/assets/brand/bootstrap-logo.svg')
            ->brandImageAttributes(
                [
                    'alt' => 'bootstrap',
                    'width' => 30,
                    'height' => 24,
                ],
            )
            ->brandUrl('#')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" width="30" height="24" alt="bootstrap">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#image
     */
    public function testBrandAsImageWithStringable(): void
    {
        $html = NavBar::widget()
            ->brandImage(
                Img::tag()
                    ->alt('bootstrap')
                    ->height(24)
                    ->src('/docs/5.3/assets/brand/bootstrap-logo.svg')
                    ->width(30)
            )
            ->brandUrl('#')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" width="30" height="24" alt="bootstrap">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#image-and-text
     */
    public function testBrandAsImageAndText(): void
    {
        $html = NavBar::widget()
            ->brandImage('/docs/5.3/assets/brand/bootstrap-logo.svg')
            ->brandImageAttributes(
                [
                    'alt' => 'bootstrap',
                    'width' => 30,
                    'height' => 24,
                ],
            )
            ->brandText('NavBar')
            ->brandUrl('#')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">
            <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" width="30" height="24" alt="bootstrap">
            NavBar
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#containers
     */
    public function testContainer(): void
    {
        $html = NavBar::widget()
            ->container(true)
            ->containerAttributes(['class' => 'container'])
            ->brandText('NavBar')
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="container">
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            </div>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#containers
     */
    public function testContainerResponsive(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->innerContainerAttributes(['class' => 'container-md'])
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-md">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors
     */
    public function testExpandWithSm(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->expand(NavBarExpand::SM)
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-sm">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors
     */
    public function testExpandWithMd(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->expand(NavBarExpand::MD)
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors
     */
    public function testExpandWithLg(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->expand(NavBarExpand::LG)
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors
     */
    public function testExpandWithXl(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->expand(NavBarExpand::XL)
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-xl">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors
     */
    public function testExpandWithXxl(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->expand(NavBarExpand::XXL)
            ->id('navbar')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-xxl">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#placement
     */
    public function testPlacementWithFixedBottom(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->id('navbar')
            ->placement(NavBarPlacement::FIXED_BOTTOM)
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg fixed-bottom">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#placement
     */
    public function testPlacementWithFixedTop(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->id('navbar')
            ->placement(NavBarPlacement::FIXED_TOP)
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#placement
     */
    public function testPlacementWithStickyBottom(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->id('navbar')
            ->placement(NavBarPlacement::STICKY_BOTTOM)
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg sticky-bottom">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#placement
     */
    public function testPlacementWithStickyTop(): void
    {
        $html = NavBar::widget()
            ->brandText('NavBar')
            ->id('navbar')
            ->placement(NavBarPlacement::STICKY_TOP)
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">NavBar</span>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navbar/#color-schemes
     */
    public function testTheme(): void
    {
        $html = NavBar::widget()
            ->addClass(BackgroundColor::BODY_TERTIARY)
            ->brandText('NavBar')
            ->brandUrl('#')
            ->id('navbar')
            ->theme('dark')
            ->begin();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">NavBar</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">

            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }

    public function testRender(): void
    {
        $html = NavBar::widget()
            ->addClass(BackgroundColor::BODY_TERTIARY)
            ->brandText('NavBar')
            ->brandUrl('#')
            ->id('navbarSupportedContent')
            ->begin();
        $html .= Nav::widget()
            ->items(
                NavLink::item('Home', '#', active: true),
                NavLink::item(label: 'Link', url: '#'),
                Dropdown::widget()
                    ->items(
                        DropdownItem::link('Action', '#'),
                        DropdownItem::link('Another action', '#'),
                        DropdownItem::divider(),
                        DropdownItem::link('Something else here', '#'),
                    ),
                NavLink::item('Disabled', '#', disabled: true),
            )
            ->styles(NavStyle::NAVBAR)
            ->render();
        $html .= NavBar::end();

        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">NavBar</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
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
            <hr class="dropdown-divider">
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </li>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            </ul>
            </div>
            </div>
            </nav>
            HTML,
            $html,
        );
    }
}
