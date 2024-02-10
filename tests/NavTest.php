<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Nav;

/**
 * Tests for `Nav` widget.
 */
final class NavTest extends TestCase
{
    public function testRender(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                    'disabled' => true,
                ],
                [
                    'label' => 'Dropdown1',
                    'dropdownOptions' => ['id' => 'testDd1'],
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="testDd1" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertSame($expected, $html);
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
        $html = Nav::widget()
            ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="test1" class="test dropdown-menu" data-id="t1">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEmptyItems(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'items' => null,
                ],
                [
                    'label' => 'Dropdown1',
                    'dropdownOptions' => ['id' => 'TEST_DD'],
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a><ul id="TEST_DD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="nav-item"><a class="nav-link" href="#">Page4</a></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActive(): void
    {
        $html = Nav::widget()
            ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="nav-item"><a class="nav-link" href="/site/index">Item2</a></li></ul>
        HTML;

        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActive(): void
    {
        $html = Nav::widget()
            ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link active" href="#">Item1</a></li>
        <li class="nav-item"><a class="nav-link active" href="/site/index">Item2</a></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActiveSubitems(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->withoutActivateItems()
            ->currentPath('/site/index')
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'dropdownOptions' => ['id' => 'TEST_DROPDOWN'],
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => 'site/index'],
                        ['label' => 'Page3', 'content' => 'Page3', 'active' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Item2</a><ul id="TEST_DROPDOWN" class="dropdown-menu">
        <li><a class="dropdown-item" href="site/index">Page2</a></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testImplicitActiveSubitems(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Item1',
                ],
                [
                    'label' => 'Item2',
                    'dropdownOptions' => ['id' => 'TEST_DROPDOWN'],
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => '/site/index'],
                        ['label' => 'Page3', 'content' => 'Page3', 'active' => true],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Item2</a><ul id="TEST_DROPDOWN" class="dropdown-menu">
        <li><a class="dropdown-item" href="/site/index">Page2</a></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/96
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/157
     */
    public function testDeepActivateParents(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->activateParents()
            ->items([
                [
                    'label' => 'Dropdown',
                    'dropdownOptions' => ['id' => 'DD_ID'],
                    'items' => [
                        [
                            'label' => 'Sub-dropdown',
                            'submenuOptions' => ['id' => 'SUB_ID'],
                            'items' => [
                                ['label' => 'Page', 'content' => 'Page', 'active' => true],
                            ],
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link active" href="#" data-bs-toggle="dropdown">Dropdown</a><ul id="DD_ID" class="dropdown-menu">
        <li class="dropdown" aria-expanded="false"><a class="active dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Sub-dropdown</a><ul id="SUB_ID" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page</h6></li>
        </ul></li>
        </ul></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEncodeLabel(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Page1</span>',
                    'content' => 'Page1',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Page1&lt;/span&gt;</a></li></ul>
        HTML;
        $this->assertSame($expected, $html);

        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => '<span><i class=fas fas-test></i>Page1</span>',
                    'content' => 'Page1',
                ],
            ])
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#"><span><i class=fas fas-test></i>Page1</span></a></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testDropdownClass(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
            ])
            ->dropdownClass(Dropdown::class)
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testOptions(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
            ])
            ->options(['class' => 'text-link'])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="text-link nav"><li class="nav-item"><a class="nav-link" href="#">Page1</a></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testDropdownEncodeLabels(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions(['id' => 'testDD'])
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
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="testDD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertSame($expected, $html);

        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions(['id' => 'testDD'])
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
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown"><span><i class=fas fas-test></i>Dropdown1</span></a><ul id="testDD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        <li class="dropdown-divider"></li></ul>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMainOptions(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions(['id' => 'testDD'])
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
        <ul id="test" class="nav"><li class="custom-item-class dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="testDD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testMainLinkOptions(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions(['id' => 'testDD'])
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
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="custom-link-class dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="testDD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testMainDropdownOptions(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions([
                'id' => 'testDD',
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
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="testDD" class="dropdown-menu-dark dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testAdditionalActiveClass(): void
    {
        $html = Nav::widget()
            ->id('test')
            ->dropdownOptions(['id' => 'testDD'])
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
        <ul id="test" class="nav"><li class="dropdown nav-item"><a class="dropdown-toggle nav-link active custom-active-class" href="#" data-bs-toggle="dropdown">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="testDD" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li></ul>
        HTML;

        $this->assertSame($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testHomeLink(): void
    {
        // Home link is active.
        $expected = <<<HTML
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link active" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertSame(
            $expected,
            Nav::widget()
                ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertSame(
            $expected,
            Nav::widget()
                ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link active" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertSame(
            $expected,
            Nav::widget()
                ->id('test')
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
        <ul id="test" class="nav"><li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="/item1">Item1</a></li></ul>
        HTML;
        $this->assertSame(
            $expected,
            Nav::widget()
                ->id('test')
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
