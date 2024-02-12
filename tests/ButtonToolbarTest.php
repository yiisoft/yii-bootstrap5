<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\ButtonToolbar;

/**
 * Tests for `ButtonToolbar` widget.
 */
final class ButtonToolbarTest extends TestCase
{
    public function testRender(): void
    {
        $html = ButtonToolbar::widget()
            ->id('TEST_ID')
            ->options([
                'aria-label' => 'Toolbar with button groups',
            ])
            ->buttonGroups([
                ButtonGroup::widget()
                    ->id('BG1')
                    ->options([
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ])
                    ->buttons([
                        ['label' => '1', 'options' => ['id' => 'BTN1']],
                        ['label' => '2', 'options' => ['id' => 'BTN2']],
                        ['label' => '3', 'options' => ['id' => 'BTN3']],
                        ['label' => '4', 'options' => ['id' => 'BTN4']],
                    ])
                    ->render(),
                [
                    'options' => [
                        'id' => 'BG2',
                        'aria-label' => 'Second group',
                    ],
                    'buttons' => [
                        ['label' => '5', 'options' => ['id' => 'BTN5']],
                        ['label' => '6', 'options' => ['id' => 'BTN6']],
                        ['label' => '7', 'options' => ['id' => 'BTN7']],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar"><div id="BG1" class="mr-2 btn-group" aria-label="First group" role="group"><button type="button" id="BTN1" class="btn">1</button>
        <button type="button" id="BTN2" class="btn">2</button>
        <button type="button" id="BTN3" class="btn">3</button>
        <button type="button" id="BTN4" class="btn">4</button></div>
        <div id="BG2" class="btn-group" aria-label="Second group" role="group"><button type="button" id="BTN5" class="btn">5</button>
        <button type="button" id="BTN6" class="btn">6</button>
        <button type="button" id="BTN7" class="btn">7</button></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonGroupEmpty(): void
    {
        $html = ButtonToolbar::widget()
            ->id('TEST_ID')
            ->buttonGroups([[]])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-toolbar" role="toolbar"></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonOptions(): void
    {
        $html = ButtonToolbar::widget()
            ->id('TEST_ID')
            ->buttonGroups([
                [
                    'options' => ['id' => 'BG1'],
                    'buttons' => [
                        ['label' => '1', 'options' => ['id' => 'BTN1', 'class' => 'btn-secondary', 'tabindex' => 2, 'type' => 'reset']],
                        ['label' => '2', 'options' => ['id' => 'BTN2', 'class' => 'btn-primary', 'tabindex' => 1, 'type' => 'submit']],
                    ],
                    'class' => ['mr-2'],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-toolbar" role="toolbar"><div id="BG1" class="btn-group" role="group"><button type="reset" id="BTN1" class="btn-secondary btn" tabindex="2">1</button>
        <button type="submit" id="BTN2" class="btn-primary btn" tabindex="1">2</button></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testAdditionalContent(): void
    {
        $addHtml = <<<'HTML'
        <div class="input-group">
        <div class="input-group-prepend">
        <div class="input-group-text" id="btnGroupAddon">@</div>
        </div>
        <input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
        </div>
        HTML;
        $html = ButtonToolbar::widget()
            ->id('TEST_ID')
            ->options([
                'aria-label' => 'Toolbar with button groups',
            ])
            ->buttonGroups([
                [
                    'options' => [
                        'id' => 'BG1',
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ],
                    'buttons' => [
                        ['label' => '1', 'options' => ['id' => 'BTN1']],
                        ['label' => '2', 'options' => ['id' => 'BTN2']],
                        ['label' => '3', 'options' => ['id' => 'BTN3']],
                        ['label' => '4', 'options' => ['id' => 'BTN4']],
                    ],
                ],
                $addHtml,
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar"><div id="BG1" class="mr-2 btn-group" aria-label="First group" role="group"><button type="button" id="BTN1" class="btn">1</button>
        <button type="button" id="BTN2" class="btn">2</button>
        <button type="button" id="BTN3" class="btn">3</button>
        <button type="button" id="BTN4" class="btn">4</button></div>
        <div class="input-group">
        <div class="input-group-prepend">
        <div class="input-group-text" id="btnGroupAddon">@</div>
        </div>
        <input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
        </div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
