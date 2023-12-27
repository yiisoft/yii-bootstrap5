<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Collapse;
use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavBar;
use Yiisoft\Yii\Bootstrap5\Offcanvas;

/**
 * Tests for NavBar widget.
 *
 * NavBarTest
 */
final class NavBarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        NavBar::counter(0);
    }

    public function testRender(): void
    {
        $html = NavBar::widget()
            ->brandText('My Company')
            ->brandUrl('/')
            ->withTheme(null)
            ->options([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar-inverse navbar-static-top navbar-frontend navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImage(): void
    {
        $html = NavBar::widget()
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
            ->brandText('My Company')
            ->brandUrl('/')
            ->begin();
        $html .= Nav::widget()
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                ['label' => 'Dropdown', 'items' => [
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
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        <ul id="w2-nav" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="w3-dropdown" class="dropdown-menu">
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
            ->collapseOptions(['class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="testMe collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandOptions(): void
    {
        $html = NavBar::widget()
            ->brandText('My App')
            ->brandOptions(['class' => 'text-dark'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="text-dark navbar-brand" href="/">My App</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImageAttributes(): void
    {
        $html = NavBar::widget()
            ->brandImage('empty.gif')
            ->brandImageAttributes(['width' => 100, 'height' => 100])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/"><img src="empty.gif" width="100" height="100" alt></a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testScreenReaderToggleText(): void
    {
        $html = NavBar::widget()
            ->screenReaderToggleText('Toggler navigation')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggler navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerContent(): void
    {
        $html = NavBar::widget()
            ->withToggleLabel('<div class="navbar-toggler-icon"></div>')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><div class="navbar-toggler-icon"></div></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerOptions(): void
    {
        $html = NavBar::widget()
            ->withToggleOptions(['class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="container">

        <button type="button" class="testMe navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testRenderInnerContainer(): void
    {
        $html = NavBar::widget()
            ->withoutRenderInnerContainer()
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testInnerContainerOptions(): void
    {
        $html = NavBar::widget()
            ->innerContainerOptions(['class' => 'text-link'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg">
        <div class="text-link">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutCollapse(): void
    {
        $html = NavBar::widget()
            ->brandText('My Company')
            ->expandSize(null)
            ->brandUrl('/')
            ->begin();
        $html .= Nav::widget()
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                ['label' => 'Dropdown', 'items' => [
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
        <nav id="w0-navbar" class="navbar">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <ul id="w1-nav" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="w2-dropdown" class="dropdown-menu">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider expandSizeDataProvider
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     */
    public function testExpandSize(string $size, string $expected): void
    {
        $html = NavBar::widget()->options([
            'id' => 'expanded-navbar',
        ])
            ->expandSize($size)
            ->begin() . NavBar::end();

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOffcanvas(): void
    {
        $offcanvas = Offcanvas::widget()->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->withWidget($offcanvas)
            ->expandSize(null)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" aria-label="Toggle navigation" aria-controls="w1-offcanvas" data-bs-target="#w1-offcanvas">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w1-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w1-offcanvas-title" class="offcanvas-title">Navbar offcanvas title</h5>
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
        $offcanvas = Offcanvas::widget()->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->withWidget($offcanvas)
            ->expandSize(NavBar::EXPAND_XL)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-xl">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" aria-label="Toggle navigation" aria-controls="w1-offcanvas" data-bs-target="#w1-offcanvas">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w1-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w1-offcanvas-title" class="offcanvas-title">Navbar offcanvas title</h5>
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
        <nav id="w0-navbar" class="navbar">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
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
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-label="Toggle navigation" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"><span class="navbar-toggler-icon"></span></button>
                <div id="w0-collapse" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider colorThemeDataProvider
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     */
    public function testColorTheme(string $theme, string $expected): void
    {
        $html = NavBar::widget()
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
                Collapse::class,
                '<button type="button" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false"></button>',
            ],

            [
                Offcanvas::class,
                '<button type="button" data-bs-toggle="offcanvas" aria-controls="w0-offcanvas" data-bs-target="#w0-offcanvas"></button>',
            ],

            [
                null,
                <<<'HTML'
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" aria-controls="w0-navbar" data-bs-target="#w0-navbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                </span>
                </button>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider toggleWidgetDataProvider
     * @param Collapse|Offcanvas|null $widget
     */
    public function testToggle(?string $widget, string $expected): void
    {
        $widget = $widget ? $widget::widget() : null;

        $navBar = NavBar::widget()
            ->withWidget($widget);

        $this->assertEqualsHTML(
            $expected,
            $navBar->renderToggle()
                ->render()
        );
    }
}
