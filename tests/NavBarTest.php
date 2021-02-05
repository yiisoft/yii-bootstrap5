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
            ->withBrandLabel('My Company')
            ->withBrandUrl('/')
            ->withOptions([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

        $html = NavBar::widget()
            ->withBrandImage('/images/test.jpg')
            ->withBrandUrl('/')
            ->begin();

        $html .= NavBar::end();
        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg" alt=""></a>',
            $html
        );
    }

    public function testBrandLink(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->withBrandLabel('Yii Framework')
            ->withBrandUrl('/index.php')
            ->begin();

        $html .= NavBar::end();
        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/index.php">Yii Framework</a>',
            $html
        );
    }

    public function testBrandSpan(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->withBrandLabel('Yii Framework')
            ->withBrandUrl('')
            ->begin();

        $html .= NavBar::end();
        $this->assertStringContainsString(
            '<span class="navbar-brand">Yii Framework</span>',
            $html
        );
    }

    public function testNavAndForm(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->withBrandLabel('My Company')
            ->withBrandUrl('/')
            ->begin();

        $html .= Nav::widget()
            ->withItems([
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
            ->withOptions(['class' => ['mr-auto']])
            ->render();

        $html .= <<< HTML
<form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
HTML;

        $html .= NavBar::end();
        $expected = <<< HTML
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
<li><div class="dropdown-divider"></div></li>
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

        $html = NavBar::widget()->withCollapseOptions(['class' => 'testMe'])->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

        $html = NavBar::widget()->withBrandLabel('My App')->withBrandOptions(['class' => 'text-dark'])->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

        $html = NavBar::widget()->withScreenReaderToggleText('Toggler navigation')->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

        $html = NavBar::widget()->withTogglerContent('<div class="navbar-toggler-icon"></div>')->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

        $html = NavBar::widget()->withTogglerOptions(['class' => 'testMe'])->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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
        $expected = <<< HTML
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

        $html = NavBar::widget()->withInnerContainerOptions(['class' => 'text-link'])->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
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

    public function testEncodeTags(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->withEncodeTags()->begin();

        $html .= NavBar::end();
        $expected = <<< HTML
<nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">

<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation">&lt;span class="navbar-toggler-icon"&gt;&lt;/span&gt;</button>
<div id="w0-collapse" class="collapse navbar-collapse">
</div>
</div>
</nav>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
