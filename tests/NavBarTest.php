<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Collapse;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavBar;
use Yiisoft\Yii\Bootstrap5\Offcanvas;

/**
 * Tests for `NavBar` widget.
 */
final class NavBarTest extends TestCase
{
    public function testRender(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->brandText('My Company')
            ->brandUrl('/')
            ->withTheme(null)
            ->options([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar-inverse navbar-static-top navbar-frontend navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImage(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->brandImage('/images/test.jpg')
            ->brandUrl('/')
            ->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg" alt></a>',
            $html
        );
    }

    public function testbrandUrl(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->brandText('Yii Framework')
            ->brandUrl('/index.php')
            ->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/index.php">Yii Framework</a>',
            $html
        );
    }

    public function testBrandText(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->brandText('Yii Framework')
            ->brandUrl('')
            ->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<span class="navbar-brand">Yii Framework</span>',
            $html
        );
    }

    public function testBrandImageText(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->brandText('Yii Framework')
            ->brandImage('/images/test.jpg')
            ->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg" alt>Yii Framework</a>',
            $html
        );
    }

    public function testNavAndForm(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->brandText('My Company')
            ->brandUrl('/')
            ->begin();
        $html .= Nav::widget()
            ->id('N_ID')
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                [
                    'label' => 'Dropdown',
                    'dropdownOptions' => ['id' => 'D_ID'],
                    'items' => [
                        ['label' => 'Action', 'url' => '#'],
                        ['label' => 'Another action', 'url' => '#'],
                        '-',
                        ['label' => 'Something else here', 'url' => '#'],
                    ],
                ],
            ])
            ->options(['class' => ['mr-auto']])
            ->render();

        $html .= <<<'HTML'
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        HTML;

        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        <ul id="N_ID" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul></li></ul><form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form></div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testCollapseOptions(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID', 'class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="testMe collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandOptions(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->brandText('My App')
            ->brandOptions(['class' => 'text-dark'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="text-dark navbar-brand" href="/">My App</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImageAttributes(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->brandImage('empty.gif')
            ->brandImageAttributes(['width' => 100, 'height' => 100])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/"><img src="empty.gif" width="100" height="100" alt></a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testScreenReaderToggleText(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->screenReaderToggleText('Toggler navigation')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggler navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerContent(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->withToggleLabel('<div class="navbar-toggler-icon"></div>')
            ->collapseOptions(['id' => 'C_ID'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><div class="navbar-toggler-icon"></div></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerOptions(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->withToggleOptions(['class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="testMe navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testRenderInnerContainer(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->withoutRenderInnerContainer()
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testInnerContainerOptions(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->collapseOptions(['id' => 'C_ID'])
            ->innerContainerOptions(['class' => 'text-link'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-lg">
        <div class="text-link">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="C_ID" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutCollapse(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->brandText('My Company')
            ->expandSize(null)
            ->brandUrl('/')
            ->begin();
        $html .= Nav::widget()
            ->id('D_ID1')
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                [
                    'label' => 'Dropdown',
                    'dropdownOptions' => ['id' => 'D_ID2'],
                    'items' => [
                        ['label' => 'Action', 'url' => '#'],
                        ['label' => 'Another action', 'url' => '#'],
                        '-',
                        ['label' => 'Something else here', 'url' => '#'],
                    ],
                ],
            ])
            ->options(['class' => ['mr-auto']])
            ->render();
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <ul id="D_ID1" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="D_ID2" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul></li></ul></div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public static function expandSizeDataProvider(): array
    {
        return [
            [
                NavBar::EXPAND_SM,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-sm">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],

            [
                NavBar::EXPAND_MD,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-md">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],

            [
                NavBar::EXPAND_LG,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-lg">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],

            [
                NavBar::EXPAND_XL,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-xl">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],

            [
                NavBar::EXPAND_XXL,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-xxl">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider expandSizeDataProvider
     */
    public function testExpandSize(string $size, string $expected): void
    {
        $html = NavBar::widget()
                ->id('TEST_ID')
                ->collapseOptions(['id' => 'C_ID'])
                ->options([
                    'id' => 'expanded-navbar',
                ])
                ->expandSize($size)
            ->begin() . NavBar::end();

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOffcanvas(): void
    {
        $offcanvas = Offcanvas::widget()->id('O_ID')->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->withWidget($offcanvas)
            ->expandSize(null)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" aria-label="Toggle navigation" aria-controls="O_ID" data-bs-target="#O_ID">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="O_ID" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="O_ID-title">
        <header class="offcanvas-header">
        <h5 id="O_ID-title" class="offcanvas-title">Navbar offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content in navbar offcanvas</p>
        </div>
        </div>
        </div>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testExpandedOffcanvas(): void
    {
        $offcanvas = Offcanvas::widget()
            ->id('O_ID')
            ->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->withWidget($offcanvas)
            ->expandSize(NavBar::EXPAND_XL)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar navbar-expand-xl">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" aria-label="Toggle navigation" aria-controls="O_ID" data-bs-target="#O_ID">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="O_ID" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="O_ID-title">
        <header class="offcanvas-header">
        <h5 id="O_ID-title" class="offcanvas-title">Navbar offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content in navbar offcanvas</p>
        </div>
        </div>
        </div>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testCollapseExternalContent(): void
    {
        $html = NavBar::widget()
            ->id('TEST_ID')
            ->innerContainerOptions([
                'class' => 'container-fluid',
            ])
            ->withToggle(true)
            ->withToggleOptions([
                'data' => [
                    'bs-target' => '#navbarToggleExternalContent',
                ],
                'aria' => [
                    'controls' => 'navbarToggleExternalContent',
                    'expanded' => 'false',
                ],
            ])
            ->expandSize(null)
            ->begin();
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="TEST_ID" class="navbar">
        <div class="container-fluid">
        <button type="button" class="navbar-toggler" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" data-bs-toggle="collapse" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        </div>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public static function colorThemeDataProvider(): array
    {
        return [
            [
                NavBar::THEME_LIGHT,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-lg navbar-light" data-bs-theme="light">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],

            [
                NavBar::THEME_DARK,
                <<<HTML
                <nav id="expanded-navbar" class="navbar navbar-expand-lg navbar-dark" data-bs-theme="dark">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="C_ID" data-bs-target="#C_ID" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="C_ID" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider colorThemeDataProvider
     */
    public function testColorTheme(string $theme, string $expected): void
    {
        $html = NavBar::widget()
            ->collapseOptions(['id' => 'C_ID'])
            ->withTheme($theme)
            ->options([
                'id' => 'expanded-navbar',
            ])
            ->begin();
        $html .= NavBar::end();

        $this->assertEqualsHTML($expected, $html);
    }

    public static function toggleWidgetDataProvider(): array
    {
        return [
            [
                Collapse::widget()->id('T_ID'),
                '<button type="button" data-bs-toggle="collapse" aria-controls="T_ID" data-bs-target="#T_ID" aria-expanded="false"></button>',
            ],

            [
                Offcanvas::widget()->id('T_ID'),
                '<button type="button" data-bs-toggle="offcanvas" aria-controls="T_ID" data-bs-target="#T_ID"></button>',
            ],

            [
                null,
                <<<'HTML'
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                </span>
                </button>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider toggleWidgetDataProvider
     */
    public function testToggle(Collapse|Offcanvas|null $widget, string $expected): void
    {
        $navBar = NavBar::widget()
            ->id('TEST_ID')
            ->withWidget($widget);

        $this->assertEqualsHTML(
            $expected,
            $navBar->renderToggle()->render()
        );
    }
}
