<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Button;
use Yiisoft\Yii\Bootstrap5\ButtonGroup;

/**
 * Tests for `ButtonGroup` widget.
 */
final class ButtonGroupTest extends TestCase
{
    public function testRender(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->buttons([
                ['label' => 'button-A', 'options' => ['id' => 'BTN1']],
                ['label' => 'button-B', 'visible' => true, 'options' => ['id' => 'BTN2']],
                ['label' => 'button-C', 'visible' => false],
                Button::widget()
                    ->id('BTN4')
                    ->label('button-D')
                    ->render(),
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="button" id="BTN1" class="btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button>
        <button id="BTN4" class="btn">button-D</button></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonOptions(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->buttons([
                ['label' => 'button-A', 'options' => ['class' => 'btn-primary', 'type' => 'submit', 'id' => 'BTN1']],
                ['label' => 'button-B', 'options' => ['id' => 'BTN2']],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabes(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->buttons([
                ['label' => 'button-A', 'options' => ['class' => 'btn-primary', 'type' => 'submit', 'id' => 'BTN1']],
                ['label' => '<span><i class=fas fas-test></i>button-B</span>', 'options' => ['id' => 'BTN2']],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn">&lt;span&gt;&lt;i class=fas fas-test&gt;&lt;/i&gt;button-B&lt;/span&gt;</button></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->buttons([
                ['label' => 'button-A', 'options' => ['class' => 'btn-primary', 'type' => 'submit', 'id' => 'BTN1']],
                ['label' => '<span><i class=fas fas-test></i>button-B</span>', 'options' => ['id' => 'BTN2']],
            ])
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn"><span><i class=fas fas-test></i>button-B</span></button></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->buttons([
                ['label' => 'button-A', 'options' => ['class' => 'btn-primary', 'type' => 'submit', 'id' => 'BTN1']],
                ['label' => 'button-B', 'options' => ['id' => 'BTN2']],
            ])
            ->options(['class' => 'btn-lg'])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-lg btn-group" role="group"><button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
