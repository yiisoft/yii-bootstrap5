<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Nav;

/**
 * Tests for Nav widget.
 *
 * NavTest
 */
final class NavTest extends TestCase
{
    public function testRender(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                    'disabled' => true,
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
                [
                    'label' => 'Dropdown2',
                    'visible' => false,
                    'items' => [
                        ['label' => 'Page4', 'content' => 'Page4'],
                        ['label' => 'Page5', 'content' => 'Page5'],
                    ],
                ],
                '<li class="dropdown-divider"></li>',
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(RuntimeException::class);
        Nav::widget()
            ->items([['content' => 'Page1']])
            ->render();
    }

    public function testRenderDropdownWithDropdownOptions(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
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
                    ],
                ],
                [
                    'label' => 'Dropdown2',
                    'visible' => false,
                    'items' => [
                        ['label' => 'Page4', 'content' => 'Page4'],
                        ['label' => 'Page5', 'content' => 'Page5'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="test1" class="test dropdown-menu" aria-expanded="false" data-id="t1">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEmptyItems(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
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
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="nav-item"><a class="nav-link" href="#">Page4</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActive(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->withoutActivateItems()
            ->items([
                [
                    'label' => 'Item1',
                    'active' => true,
                ],
                [
                    'label' => 'Item2',
                    'url' => '/site/index',
                ],
            ])
            ->render();

        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="nav-item"><a class="nav-link" href="/site/index">Item2</a></li></ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActive(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
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
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link active" href="#">Item1</a></li>
        <li class="nav-item"><a class="nav-link active" href="/site/index">Item2</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActiveSubitems(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->withoutActivateItems()
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
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Item2</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item" href="site/index">Page2</a></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActiveSubitems(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
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
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Item2</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item" href="/site/index">Page2</a></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/96
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/157
     */
    public function testDeepActivateParents(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->activateParents()
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
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link active" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li class="dropdown" aria-expanded="false"><a class="active dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Sub-dropdown</a><ul id="w2-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page</h6></li>
        </ul></li>
        </ul></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabel(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Page1</span>',
                    'content' => 'Page1',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Page1&lt;/span&gt;</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Nav::widget()
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Page1</span>',
                    'content' => 'Page1',
                ],
            ])
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <ul id="w1-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#"><span><i class=fas fas-test></i>Page1</span></a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownClass(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
            ])
            ->dropdownClass(Dropdown::class)
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
            ])
            ->options(['class' => 'text-link'])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="text-link nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownEncodeLabels(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
                '<li class="dropdown-divider"></li>',
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Nav::widget()
            ->withoutEncodeLabels()
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
                '<li class="dropdown-divider"></li>',
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w2-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown"><span><i class=fas fas-test></i>Dropdown1</span></a><ul id="w3-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMainOptions(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->itemOptions([
                'class' => 'custom-item-class',
            ])
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="custom-item-class dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMainLinkOptions(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->linkOptions([
                'class' => 'custom-link-class',
            ])
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="custom-link-class dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMainDropdownOptions(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->dropdownOptions([
                'class' => 'dropdown-menu-dark',
            ])
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="w1-dropdown" class="dropdown-menu-dark dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testAdditionalActiveClass(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->activeClass('custom-active-class')
            ->items([
                [
                    'active' => true,
                    'label' => '<span><i class=fas fas-test></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3', 'visible' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link active custom-active-class" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testHomeLink(): void
    {
        // Home link is active.
        Nav::counter(0);
        $expected = <<<HTML
        <ul id="w0-nav" class="nav"><li class="nav-item"><a class="nav-link active" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Nav::widget()
                ->currentPath('/home')
                ->items([
                    [
                        'label' => 'Home',
                        'url' => '/home',
                    ],
                    [
                        'label' => 'Item1',
                        'url' => '/item1',
                    ],
                ])
                ->render()
        );

        // Home link is not active.
        $expected = <<<HTML
        <ul id="w1-nav" class="nav"><li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Nav::widget()
                ->currentPath('/home')
                ->items([
                    [
                        'label' => 'Home',
                        'url' => '/home',
                        'active' => false,
                    ],
                    [
                        'label' => 'Item1',
                        'url' => '/item1',
                    ],
                ])
                ->render()
        );

        // Home link and item1 is active.
        $expected = <<<HTML
        <ul id="w2-nav" class="nav"><li class="nav-item"><a class="nav-link active" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Nav::widget()
                ->currentPath('/home')
                ->items([
                    [
                        'label' => 'Home',
                        'url' => '/home',
                    ],
                    [
                        'label' => 'Item1',
                        'url' => '/item1',
                        'active' => true,
                    ],
                ])
                ->render()
        );

        // Home link is not active and item1 is active.
        $expected = <<<HTML
        <ul id="w3-nav" class="nav"><li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Nav::widget()
                ->currentPath('/item1')
                ->items([
                    [
                        'label' => 'Home',
                        'url' => '/home',
                    ],
                    [
                        'label' => 'Item1',
                        'url' => '/item1',
                    ],
                ])
                ->render()
        );
    }
}
