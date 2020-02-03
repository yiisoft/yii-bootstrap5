<?php

declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Nav;

/**
 * Tests for Nav widget.
 *
 * NavTest
 */
class NavTest extends TestCase
{
    public function testIds(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3'],
                    ]
                ],
                [
                    'label' => 'Dropdown2',
                    'visible' => false,
                    'items' => [
                        ['label' => 'Page4', 'content' => 'Page4'],
                        ['label' => 'Page5', 'content' => 'Page5'],
                    ]
                ]
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Dropdown1</a><div id="w1-dropdown" class="dropdown-menu"><h6 class="dropdown-header">Page2</h6>
<h6 class="dropdown-header">Page3</h6></div></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    public function testRenderDropdownWithDropdownOptions(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'Dropdown1',
                    'dropdownOptions' => ['class' => 'test', 'data-id' => 't1', 'id' => 'test1'],
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3'],
                    ]
                ],
                [
                    'label' => 'Dropdown2',
                    'visible' => false,
                    'items' => [
                        ['label' => 'Page4', 'content' => 'Page4'],
                        ['label' => 'Page5', 'content' => 'Page5'],
                    ]
                ]
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Dropdown1</a><div id="test1" class="test dropdown-menu" data-id="t1"><h6 class="dropdown-header">Page2</h6>
<h6 class="dropdown-header">Page3</h6></div></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    public function testEmptyItems(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'items' => null,
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3'],
                    ],
                ],
                [
                    'label' => 'Page4',
                    'items' => [],
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Dropdown1</a><div id="w1-dropdown" class="dropdown-menu"><h6 class="dropdown-header">Page2</h6>
<h6 class="dropdown-header">Page3</h6></div></li>
<li class="nav-item"><a class="nav-link" href="#">Page4</a></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActive(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->activateItems(false)
            ->items([
                [
                    'label' => 'Item1',
                    'active' => true,
                ],
                [
                    'label' => 'Item2',
                    'url' => '/site/index',
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
<li class="nav-item"><a class="nav-link" href="/site/index">Item2</a></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActive(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->currentPath('/site/index')
            ->items([
                [
                    'label' => 'Item1',
                    'active' => true,
                ],
                [
                    'label' => 'Item2',
                    'url' => '/site/index',
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link active" href="#">Item1</a></li>
<li class="nav-item"><a class="nav-link active" href="/site/index">Item2</a></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActiveSubitems(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->activateItems(false)
            ->currentPath('/site/index')
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => 'site/index'],
                        ['label' => 'Page3', 'content' => 'Page3', 'active' => true],
                    ],
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Item2</a><div id="w1-dropdown" class="dropdown-menu"><a class="dropdown-item" href="site/index">Page2</a>
<h6 class="dropdown-header">Page3</h6></div></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActiveSubitems(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => '/site/index'],
                        ['label' => 'Page3', 'content' => 'Page3', 'active' => true],
                    ],
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
<li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Item2</a><div id="w1-dropdown" class="dropdown-menu"><a class="dropdown-item" href="/site/index">Page2</a>
<h6 class="dropdown-header">Page3</h6></div></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/96
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/157
     */
    public function testDeepActivateParents(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Nav::counter(0);

        echo Nav::widget()
            ->activateParents(true)
            ->items([
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub-dropdown',
                            'items' => [
                                ['label' => 'Page', 'content' => 'Page', 'active' => true],
                            ],
                        ],
                    ],
                ],
            ]);

        $expected = <<<EXPECTED
<ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link active" href="#" data-toggle="dropdown">Dropdown</a><div id="w1-dropdown" class="dropdown-menu"><div class="dropdown active" aria-expanded="false">
<a class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">Sub-dropdown</a>
<div id="w2-dropdown" class="dropdown-submenu dropdown-menu"><h6 class="dropdown-header">Page</h6></div>
</div></div></li></ul>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }
}
