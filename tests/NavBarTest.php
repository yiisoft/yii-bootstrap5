<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

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
    public function testRender(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandText('My Company')
            ->brandUrl('/')
            ->theme(null)
            ->options([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar-inverse navbar-static-top navbar-frontend navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImage(): void
    {
        NavBar::counter(0);

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
        NavBar::counter(0);

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
        NavBar::counter(0);

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
        NavBar::counter(0);

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
        NavBar::counter(0);

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
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        <ul id="w1-nav" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="w2-dropdown" class="dropdown-menu" aria-expanded="false">
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
        NavBar::counter(0);

        $html = NavBar::widget()
            ->collapseOptions(['class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="testMe collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandText('My App')
            ->brandOptions(['class' => 'text-dark'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <a class="text-dark navbar-brand" href="/">My App</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBrandImageAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandImage('empty.gif')
            ->brandImageAttributes(['width' => 100, 'height' => 100])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <a class="navbar-brand" href="/"><img src="empty.gif" width="100" height="100" alt></a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testScreenReaderToggleText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->screenReaderToggleText('Toggler navigation')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggler navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerContent(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->togglerContent('<div class="navbar-toggler-icon"></div>')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><div class="navbar-toggler-icon"></div></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testTogglerOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->togglerOptions(['class' => 'testMe'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="container">

        <button type="button" class="testMe navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testRenderInnerContainer(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->withoutRenderInnerContainer()
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testInnerContainerOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->innerContainerOptions(['class' => 'text-link'])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light">
        <div class="text-link">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-navbar-collapse" aria-controls="w0-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-navbar-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutCollapse(): void
    {
        NavBar::counter(0);

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
        <nav id="w0-navbar" class="navbar navbar-light">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <ul id="w1-nav" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="w2-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul></li></ul></div>
        </nav>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testExpandSize(): void
    {
        $sizes = [
            NavBar::EXPAND_SM,
            NavBar::EXPAND_MD,
            NavBar::EXPAND_LG,
            NavBar::EXPAND_XL,
            NavBar::EXPAND_XXL,
        ];

        $NavBar = NavBar::widget()->options([
            'id' => 'expanded-navbar',
        ]);

        foreach ($sizes as $size) {
            $html = $NavBar
                    ->expandSize($size)
                    ->begin() . NavBar::end();
            $expected = <<<HTML
            <nav id="expanded-navbar" class="navbar {$size} navbar-light">
            <div class="container">
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#expanded-navbar-collapse" aria-controls="expanded-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div id="expanded-navbar-collapse" class="collapse navbar-collapse">
            </div>
            </div>
            </nav>
            HTML;

            $this->assertEqualsHTML($expected, $html);
        }
    }

    public function testOffcanvas(): void
    {
        NavBar::counter(0);

        $offcanvas = Offcanvas::widget()->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->offcanvas($offcanvas)
            ->expandSize(null)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="w1-navbar" class="navbar navbar-light">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#w0-offcanvas" aria-controls="w0-offcanvas" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Navbar offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        NavBar::counter(0);

        $offcanvas = Offcanvas::widget()->title('Navbar offcanvas title');
        $html = NavBar::widget()
            ->offcanvas($offcanvas)
            ->expandSize(NavBar::EXPAND_XL)
            ->begin();
        $html .= '<p>Some content in navbar offcanvas</p>';
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="w1-navbar" class="navbar navbar-expand-xl navbar-light">
        <div class="container">
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#w0-offcanvas" aria-controls="w0-offcanvas" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Navbar offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        NavBar::counter(0);

        $html = NavBar::widget()
            ->innerContainerOptions([
                'class' => 'container-fluid',
            ])
            ->togglerOptions([
                'data' => [
                    'bs-target' => '#navbarToggleExternalContent',
                ],
                'aria' => [
                    'controls' => 'navbarToggleExternalContent',
                ],
            ])
            ->expandSize(null)
            ->begin();
        $html .= NavBar::end();

        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-light">
        <div class="container-fluid">
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        </div>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testColorTheme(): void
    {
        $themes = [
            NavBar::THEME_LIGHT => [
                'bg-light',
                'bg-white',
            ],
            NavBar::THEME_DARK => [
                'bg-dark',
                'bg-primary',
            ],
        ];

        foreach ($themes as $theme => $classNames) {
            foreach ($classNames as $class) {
                $html = NavBar::widget()
                    ->theme($theme)
                    ->options([
                        'class' => $class,
                        'id' => 'expanded-navbar',
                    ])
                    ->begin();
                $html .= NavBar::end();
                $expected = <<<HTML
                <nav id="expanded-navbar" class="{$class} navbar navbar-expand-lg {$theme}">
                <div class="container">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#expanded-navbar-collapse" aria-controls="expanded-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div id="expanded-navbar-collapse" class="collapse navbar-collapse">
                </div>
                </div>
                </nav>
                HTML;

                $this->assertEqualsHTML($expected, $html);
            }
        }
    }
}
