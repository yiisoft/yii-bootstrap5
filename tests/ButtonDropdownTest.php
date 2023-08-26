<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonDropdown;
use Yiisoft\Yii\Bootstrap5\Dropdown;

/**
 * Tests for ButtonDropdown widget
 *
 * ButtonDropdownTest
 */
final class ButtonDropdownTest extends TestCase
{
    public function testRender(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingDropdownItems(): void
    {
        $html = ButtonDropdown::widget()->render();
        $this->assertEmpty($html);
    }

    public function testDirection(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->direction(ButtonDropdown::DIRECTION_LEFT)
            ->label('Action')
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropleft btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSplit(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->direction(ButtonDropdown::DIRECTION_DOWN)
            ->label('Split dropdown')
            ->split()
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w2-button" class="btn">Split dropdown</button>
        <button id="w1-button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button>
        <ul id="w3-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonOptions(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->buttonOptions(['class' => 'btn-lg'])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn-lg btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownClass(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->dropdownClass(Dropdown::class)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items(
                [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => '<span><i class=fas fas-tests>ItemB></i></span>', 'url' => '#'],
                ]
            )
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">&lt;span&gt;&lt;i class=fas fas-tests&gt;ItemB&gt;&lt;/i&gt;&lt;/span&gt;</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = ButtonDropdown::widget()
            ->items(
                [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => '<span><i class=fas fas-tests>ItemB></i></span>', 'url' => '#'],
                ]
            )
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <div id="w3-button-dropdown" class="dropdown btn-group"><button id="w4-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w5-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#"><span><i class=fas fas-tests>ItemB></i></span></a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->options(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="testMe dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderContainer(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withoutRenderContainer()
            ->render();
        $expected = <<<'HTML'
        <button id="w0-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w1-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTagName(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->tagName('a')
            ->render();

        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><a id="w1-button" class="btn dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">Button</a>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><h6 class="dropdown-header">ItemB</h6></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testLabelOptions(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->label('Custom label')
            ->withLabelOptions([
                'class' => 'd-none d-lg-inline-block',
            ])
            ->withoutEncodeLabels()
            ->render();

        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="d-none d-lg-inline-block">Custom label</span></button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><h6 class="dropdown-header">ItemB</h6></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCustomDropdown(): void
    {
        $dropdown = Dropdown::widget()
            ->withAlignment(Dropdown::ALIGNMENT_END);

        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->dropdownClass($dropdown)
            ->render();

        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><h6 class="dropdown-header">ItemB</h6></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTheme(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withoutRenderContainer()
            ->withDarkTheme()
            ->render();
        $expected = <<<'HTML'
        <button id="w0-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-theme="dark">Button</button>

        <ul id="w1-dropdown" class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withLightTheme()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-dropdown" class="dropdown btn-group" data-bs-theme="light"><button id="w1-button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="w2-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

    }
}
