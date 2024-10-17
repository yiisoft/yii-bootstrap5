<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\{ButtonDropdown, Dropdown};
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `ButtonDropdown` widget
 *
 * @group button-dropdown
 */
final class ButtonDropdownTest extends \PHPUnit\Framework\TestCase
{
    public function testAddClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown test-class">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->addClass('test-class')
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown test-class">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->attributes(['class' => 'test-class'])
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testButtonId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" id="button-test-id" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->buttonId('button-test-id')
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id('test-id')
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id('')
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $buttonDropdown = ButtonDropdown::widget();

        $this->assertNotSame($buttonDropdown, $buttonDropdown->addClass(''));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->attributes([]));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->buttonId(''));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->dropdownAttributes([]));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->id(''));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->items([]));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->label(''));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->labelAttributes([]));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->labelContainer(false));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->labelEncode(false));
        $this->assertNotSame($buttonDropdown, $buttonDropdown->labelTagName('span'));
    }

    public function testLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->label('Dropdown')
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testLabelAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown"><span class="label-test-class">Dropdown</span></button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->label('Dropdown')
                ->labelAttributes(['class' => 'label-test-class'])
                ->labelContainer(true)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testLabelEncode(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">&lt;span&gt;Dropdown&lt;/span&gt;</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->label('<span>Dropdown</span>')
                ->labelEncode(true)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testLabelEncodeWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown"><span>Dropdown</span></button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->label('<span>Dropdown</span>')
                ->labelEncode(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testLabelTagName(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown"><i>Dropdown</i></button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->label('Dropdown')
                ->labelContainer(true)
                ->labelTagName('i')
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }

    public function testLabelTagNameWithException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The label tag name cannot be empty string.');

        ButtonDropdown::widget()
            ->labelContainer(true)
            ->labelTagName('')
            ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
            ->render();
    }

    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown button</button>
            <ul id="dropdown-test-id" class="dropdown-menu">
            <li><a class="dropdown-item" href="#">ItemA</a></li>
            <li><a class="dropdown-item" href="#">ItemB</a></li>
            </ul>
            </div>
            HTML,
            ButtonDropdown::widget()
                ->dropdownAttributes(['id' => 'dropdown-test-id'])
                ->id(false)
                ->items([['label' => 'ItemA', 'url' => '#'], ['label' => 'ItemB', 'url' => '#']])
                ->render(),
        );
    }
}
