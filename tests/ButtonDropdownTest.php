<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonDropdown;
use Yiisoft\Yii\Bootstrap5\Dropdown;

/**
 * Tests for `ButtonDropdown` widget
 */
final class ButtonDropdownTest extends TestCase
{
    public function testRender(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
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
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->direction(ButtonDropdown::DIRECTION_LEFT)
            ->label('Action')
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropleft btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSplit(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->direction(ButtonDropdown::DIRECTION_DOWN)
            ->label('Split dropdown')
            ->split()
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn">Split dropdown</button>
        <button id="B_ID" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="visually-hidden">Toggle Dropdown</span></button>
        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonOptions(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->buttonOptions(['class' => 'btn-lg', 'id' => 'B_ID'])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn-lg btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDropdownClass(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([
                ['label' => 'ItemA', 'url' => '#'],
                ['label' => 'ItemB', 'url' => '#'],
            ])
            ->dropdownClass(Dropdown::class)
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items(
                [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => '<span><i class=fas fas-tests>ItemB></i></span>', 'url' => '#'],
                ]
            )
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">&lt;span&gt;&lt;i class=fas fas-tests&gt;ItemB&gt;&lt;/i&gt;&lt;/span&gt;</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items(
                [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => '<span><i class=fas fas-tests>ItemB></i></span>', 'url' => '#'],
                ]
            )
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#"><span><i class=fas fas-tests>ItemB></i></span></a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->options(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="testMe dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderContainer(): void
    {
        $html = ButtonDropdown::widget()
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withoutRenderContainer()
            ->render();
        $expected = <<<'HTML'
        <button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTagName(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->tagName('a')
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><a id="B_ID" class="btn dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">Button</a>

        <ul id="D_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><h6 class="dropdown-header">ItemB</h6></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testLabelOptions(): void
    {
        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->label('Custom label')
            ->withLabelOptions([
                'class' => 'd-none d-lg-inline-block',
            ])
            ->withoutEncodeLabels()
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="d-none d-lg-inline-block">Custom label</span></button>

        <ul id="D_ID" class="dropdown-menu">
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

        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->dropdownOptions(['id' => 'D_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB']])
            ->dropdownClass($dropdown)
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="D_ID" class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><h6 class="dropdown-header">ItemB</h6></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTheme(): void
    {
        $html = ButtonDropdown::widget()
            ->dropdownOptions(['id' => 'DD_ID'])
            ->buttonOptions(['id' => 'B_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withoutRenderContainer()
            ->withDarkTheme()
            ->render();
        $expected = <<<'HTML'
        <button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-theme="dark">Button</button>

        <ul id="DD_ID" class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = ButtonDropdown::widget()
            ->id('TEST_ID')
            ->buttonOptions(['id' => 'B_ID'])
            ->dropdownOptions(['id' => 'DD_ID'])
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->withLightTheme()
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown btn-group" data-bs-theme="light"><button id="B_ID" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Button</button>

        <ul id="DD_ID" class="dropdown-menu">
        <li><a class="dropdown-item" href="#">ItemA</a></li>
        <li><a class="dropdown-item" href="#">ItemB</a></li>
        </ul></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
