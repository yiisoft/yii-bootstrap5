<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Button;
use Yiisoft\Yii\Bootstrap4\ButtonGroup;

/**
 * Tests for Button widget.
 *
 * ButtonGroupTest
 */
final class ButtonGroupTest extends TestCase
{
    public function testContainerOptions(): void
    {
        ButtonGroup::counter(0);

        $html = ButtonGroup::widget()
            ->buttons([
                ['label' => 'button-A'],
                ['label' => 'button-B', 'visible' => true],
                ['label' => 'button-C', 'visible' => false],
                Button::widget()
                    ->label('button-D')
                    ->render()
            ])
            ->render();

        $expected = <<<HTML
<div id="w1-button-group" class="btn-group" role="group"><button type="button" id="w2-button" class="btn">button-A</button>
<button type="button" id="w3-button" class="btn">button-B</button>
<button id="w0-button" class="btn">button-D</button></div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }
}
