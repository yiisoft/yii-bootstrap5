<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Yii\Bootstrap5\NavBar;

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
            ->options([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar-inverse navbar-static-top navbar-frontend navbar">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandImage(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandImage('/images/test.jpg')->brandUrl('/')->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg" alt></a>',
            $html
        );
    }

    public function testbrandUrl(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('Yii Framework')->brandUrl('/index.php')->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/index.php">Yii Framework</a>',
            $html
        );
    }

    public function testBrandText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('Yii Framework')->brandUrl('')->begin();
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

        $html = NavBar::widget()->brandText('My Company')->brandUrl('/')->begin();
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
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
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
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCollapseOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->collapseOptions(['class' => 'testMe'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="testMe collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('My App')->brandOptions(['class' => 'text-dark'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="text-dark navbar-brand" href="/">My App</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testScreenReaderToggleText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->screenReaderToggleText('Toggler navigation')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggler navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTogglerContent(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->togglerContent('<div class="navbar-toggler-icon"></div>')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><div class="navbar-toggler-icon"></div></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTogglerOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->togglerOptions(['class' => 'testMe'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

        <button type="button" class="testMe navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderInnerContainer(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->withoutRenderInnerContainer()->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testInnerContainerOptions(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->innerContainerOptions(['class' => 'text-link'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="text-link">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div id="w0-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
