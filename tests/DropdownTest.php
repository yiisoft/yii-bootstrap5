<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Dropdown;

/**
 * Tests for `Dropdown` widget.
 */
final class DropdownTest extends TestCase
{
    public function testRender(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items([
                [
                    'label' => 'Page1',
                    'url' => '#',
                    'disabled' => true,
                ],
                [
                    'label' => 'Page2',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Dropdown1',
                    'url' => '#test',
                    'submenuOptions' => ['id' => 'ID2'],
                    'items' => [
                        ['label' => 'Page2'],
                        ['label' => 'Page3'],
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
        <ul id="TEST_ID" class="dropdown-menu">
        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Page1</a></li>
        <li><a class="dropdown-item active" href="#">Page2</a></li>
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" href="#test" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Dropdown1</a><ul id="ID2" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderString(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('Some string content')
            ->render();

        $expected = '<div id="TEST_ID" class="dropdown-menu">Some string content</div>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderStringableContent(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(Html::p('Some stringable p-tag content'))
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu"><p>Some stringable p-tag content</p></div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testAlignment(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('I\'m alignment end dropdown')
            ->withAlignment(Dropdown::ALIGNMENT_END)
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu dropdown-menu-end">I'm alignment end dropdown</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('I\'m alignment end, but xl start dropdown')
            ->withAlignment(Dropdown::ALIGNMENT_END, Dropdown::ALIGNMENT_XL_START)
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu dropdown-menu-end dropdown-menu-xl-start">I'm alignment end, but xl start dropdown</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOuterContent(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(null)
            ->begin();
        $html .= 'I\'m very-very-very-very long content';
        $html .= Dropdown::end();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu">I'm very-very-very-very long content</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTheme(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('I\'m dark dropdown')
            ->withDarkTheme()
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">I'm dark dropdown</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('I\'m light dropdown')
            ->withLightTheme()
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu" data-bs-theme="light">I'm light dropdown</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items('I\'m blue dropdown')
            ->withTheme('blue')
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu" data-bs-theme="blue">I'm blue dropdown</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(RuntimeException::class);
        Dropdown::widget()
            ->items([['url' => '#test']])
            ->render();
    }

    public function testSubMenuOptions(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items([
                [
                    'label' => 'Dropdown1',
                    'submenuOptions' => ['id' => 'ID1'],
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
                '-',
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page3', 'content' => 'Page4'],
                        ['label' => 'Page4', 'content' => 'Page5'],
                    ],
                    'submenuOptions' => [
                        'id' => 'ID2',
                        'class' => 'submenu-override',
                    ],
                ],
            ])
            ->submenuOptions(['class' => 'submenu-list'])
            ->render();
        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Dropdown1</a><ul id="ID1" class="submenu-list dropdown-menu">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul></li>
        <li><hr class="dropdown-divider"></li>
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Dropdown2</a><ul id="ID2" class="submenu-override dropdown-menu">
        <li><h6 class="dropdown-header">Page3</h6></li>
        <li><h6 class="dropdown-header">Page4</h6></li>
        </ul></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testForms(): void
    {
        $form = <<<'HTML'
        <form class="px-4 py-3">
        <div class="form-group">
        <label for="exampleDropdownFormEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
        Remember me
        </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        HTML;
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items([
                $form,
                '-',
                ['label' => 'New around here? Sign up', 'url' => '#'],
                ['label' => '-'],
                ['label' => 'Forgot password?', 'url' => '#'],
                ['label' => '-', 'visible' => false],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li><form class="px-4 py-3">
        <div class="form-group">
        <label for="exampleDropdownFormEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
        Remember me
        </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        </form></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">New around here? Sign up</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Forgot password?</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeTags(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(Html::p('Some stringable p-tag content'))
            ->withEncodeTags(true)
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu">&lt;p&gt;Some stringable p-tag content&lt;/p&gt;</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items([
                [
                    'label' => '<span><i class=fas fastest></i>Dropdown1</span>',
                    'submenuOptions' => ['id' => 'ID2'],
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">&lt;span&gt;&lt;i class=fas fastest&gt;&lt;/i&gt;Dropdown1&lt;/span&gt;</a><ul id="ID2" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->withoutEncodeLabels()
            ->items([
                [
                    'label' => '<span><i class=fas fastest></i>Dropdown1</span>',
                    'submenuOptions' => ['id' => 'ID2'],
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button"><span><i class=fas fastest></i>Dropdown1</span></a><ul id="ID2" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMainOptions(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->withoutEncodeLabels()
            ->itemOptions([
                'class' => 'main-item-class',
            ])
            ->linkOptions([
                'class' => 'main-link-class',
            ])
            ->items([
                [
                    'label' => 'Label 1',
                    'url' => '#',
                ],
                [
                    'label' => 'Label 2',
                    'url' => '#',
                    'options' => [
                        'id' => 'custom-item-id',
                        'class' => 'custom-item-class',
                    ],
                    'linkOptions' => [
                        'class' => 'custom-link-class',
                    ],
                ],
            ])
            ->render();

        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="main-item-class"><a class="main-link-class dropdown-item" href="#">Label 1</a></li>
        <li id="custom-item-id" class="custom-item-class"><a class="custom-link-class dropdown-item" href="#">Label 2</a></li>
        </ul>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }
}
