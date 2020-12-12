<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonDropdown;

/**
 * Tests for ButtonDropdown widget
 *
 * ButtonDropdownTest
 */
final class ButtonDropdownTest extends TestCase
{
    public function testContainerOptions(): void
    {
        $containerClass = 'testClass';

        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->direction(ButtonDropdown::DIRECTION_UP)
            ->options([
                'class' => $containerClass,
            ])
            ->label('Action')
            ->dropdown([
                'items' => [
                    ['label' => 'DropdownA', 'url' => '/'],
                    ['label' => 'DropdownB', 'url' => '#'],
                ],
            ])
            ->render();

        $this->assertStringContainsString("$containerClass dropup btn-group", $html);
    }

    public function testDirection(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->direction(ButtonDropdown::DIRECTION_LEFT)
            ->label('Action')
            ->dropdown([
                'items' => [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => 'ItemB', 'url' => '#'],
                ],
            ])
            ->render();

        $expected = <<<EXPECTED
<div id="w0-button-dropdown" class="dropleft btn-group"><button id="w0-button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>

<ul id="w1-dropdown" class="dropdown-menu" aria-expanded="false">
<li><a class="dropdown-item" href="#">ItemA</a></li>
<li><a class="dropdown-item" href="#">ItemB</a></li>
</ul></div>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testSplit(): void
    {
        ButtonDropdown::counter(0);

        $html = ButtonDropdown::widget()
            ->direction(ButtonDropdown::DIRECTION_DOWN)
            ->label('Split dropdown')
            ->split(true)
            ->dropdown([
                'items' => [
                    ['label' => 'ItemA', 'url' => '#'],
                    ['label' => 'ItemB', 'url' => '#'],
                ],
            ])
            ->render();

        $expected = <<<EXPECTED
<div id="w0-button-dropdown" class="dropdown btn-group"><button id="w1-button" class="btn">Split dropdown</button>
<button id="w0-button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
<ul id="w2-dropdown" class="dropdown-menu" aria-expanded="false">
<li><a class="dropdown-item" href="#">ItemA</a></li>
<li><a class="dropdown-item" href="#">ItemB</a></li>
</ul></div>
EXPECTED;

        $this->assertEqualsWithoutLE($expected, $html);
    }
}
