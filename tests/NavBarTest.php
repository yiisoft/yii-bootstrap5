<?php

declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Nav;
use Yiisoft\Yii\Bootstrap4\NavBar;

/**
 * Tests for NavBar widget.
 *
 * NavBarTest
 */
final class NavBarTest extends TestCase
{
    public function testRender(): void
    {
        ob_start();
        ob_implicit_flush(0);

        NavBar::counter(0);

        NavBar::begin()
            ->brandLabel('My Company')
            ->brandUrl('/')
            ->options([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->start();

        echo NavBar::end();

        $expected = <<<EXPECTED
<nav id="w0-navbar" class="navbar-inverse navbar-static-top navbar-frontend navbar">
<div class="container">
<a class="navbar-brand" href="/">My Company</a>
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
<div id="w0-collapse" class="collapse navbar-collapse">
</div>
</div>
</nav>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    public function testBrandImage(): void
    {
        ob_start();
        ob_implicit_flush(0);

        NavBar::counter(0);

        NavBar::begin()
            ->brandImage('/images/test.jpg')
            ->brandUrl('/')
            ->start();

        echo NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg" alt=""></a>',
            ob_get_clean()
        );
    }

    public function testBrandLink(): void
    {
        ob_start();
        ob_implicit_flush(0);

        NavBar::counter(0);

        NavBar::begin()
            ->brandLabel('Yii Framework')
            ->brandUrl('/index.php')
            ->start();

        echo NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/index.php">Yii Framework</a>',
            ob_get_clean()
        );
    }

    public function testBrandSpan(): void
    {
        ob_start();
        ob_implicit_flush(0);

        NavBar::counter(0);

        NavBar::begin()
            ->brandLabel('Yii Framework')
            ->brandUrl('')
            ->start();

        echo NavBar::end();

        $this->assertStringContainsString(
            '<span class="navbar-brand">Yii Framework</span>',
            ob_get_clean()
        );
    }

    public function testNavAndForm(): void
    {
        ob_start();
        ob_implicit_flush(0);

        NavBar::counter(0);

        NavBar::begin()
            ->brandLabel('My Company')
            ->brandUrl('/')
            ->start();

        echo Nav::widget()
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                ['label' => 'Dropdown', 'items' => [
                        ['label' => 'Action', 'url' => '#'],
                        ['label' => 'Another action', 'url' => '#'],
                        '-',
                        ['label' => 'Something else here', 'url' => '#'],
                    ]
                ]
            ])
            ->options(['class' => ['mr-auto']]);

        echo <<<HTML
<form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
HTML;

        echo NavBar::end();

        $expected = <<<EXPECTED
<nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
<div class="container">
<a class="navbar-brand" href="/">My Company</a>
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#w0-collapse" aria-controls="w0-collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
<div id="w0-collapse" class="collapse navbar-collapse">
<ul id="w1-nav" class="mr-auto nav"><li class="nav-item"><a class="nav-link" href="#">Home</a></li>
<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Dropdown</a><div id="w2-dropdown" class="dropdown-menu"><a class="dropdown-item" href="#">Action</a>
<a class="dropdown-item" href="#">Another action</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="#">Something else here</a></div></li></ul><form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form></div>
</div>
</nav>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }
}
