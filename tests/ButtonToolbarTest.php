<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\ButtonToolbar;

/**
 * Tests for ButtonToolbar widget.
 *
 * ButtonToolbarTest
 */
final class ButtonToolbarTest extends TestCase
{
    public function testRender(): void
    {
        ButtonToolbar::counter(0);

        $html = ButtonToolbar::widget()
            ->options([
                'aria-label' => 'Toolbar with button groups',
            ])
            ->buttonGroups([
                ButtonGroup::widget()
                    ->options([
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ])
                    ->buttons([
                        ['label' => '1'],
                        ['label' => '2'],
                        ['label' => '3'],
                        ['label' => '4'],
                    ])
                    ->render(),
                [
                    'options' => [
                        'aria-label' => 'Second group',
                    ],
                    'buttons' => [
                        ['label' => '5'],
                        ['label' => '6'],
                        ['label' => '7'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w5-button-toolbar" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar"><div id="w0-button-group" class="mr-2 btn-group" aria-label="First group" role="group"><button type="button" id="w1-button" class="btn">1</button>
        <button type="button" id="w2-button" class="btn">2</button>
        <button type="button" id="w3-button" class="btn">3</button>
        <button type="button" id="w4-button" class="btn">4</button></div>
        <div id="w6-button-group" class="btn-group" aria-label="Second group" role="group"><button type="button" id="w7-button" class="btn">5</button>
        <button type="button" id="w8-button" class="btn">6</button>
        <button type="button" id="w9-button" class="btn">7</button></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonGroupEmpty(): void
    {
        ButtonToolbar::counter(0);

        $html = ButtonToolbar::widget()
            ->buttonGroups([[]])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-toolbar" class="btn-toolbar" role="toolbar"></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testButtonOptions(): void
    {
        ButtonToolbar::counter(0);

        $html = ButtonToolbar::widget()
            ->buttonGroups([
                [
                    'buttons' => [
                        ['label' => '1', 'options' => ['class' => 'btn-secondary', 'tabindex' => 2, 'type' => 'reset']],
                        ['label' => '2', 'options' => ['class' => 'btn-primary', 'tabindex' => 1, 'type' => 'submit']],
                    ],
                    'class' => ['mr-2'],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-toolbar" class="btn-toolbar" role="toolbar"><div id="w1-button-group" class="btn-group" role="group"><button type="reset" id="w2-button" class="btn-secondary btn" tabindex="2">1</button>
        <button type="submit" id="w3-button" class="btn-primary btn" tabindex="1">2</button></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testAdditionalContent(): void
    {
        ButtonToolbar::counter(0);

        $addHtml = <<<'HTML'
        <div class="input-group">
        <div class="input-group-prepend">
        <div class="input-group-text" id="btnGroupAddon">@</div>
        </div>
        <input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
        </div>
        HTML;
        $html = ButtonToolbar::widget()
            ->options([
                'aria-label' => 'Toolbar with button groups',
            ])
            ->buttonGroups([
                [
                    'options' => [
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ],
                    'buttons' => [
                        ['label' => '1'],
                        ['label' => '2'],
                        ['label' => '3'],
                        ['label' => '4'],
                    ],
                ],
                $addHtml,
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-button-toolbar" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar"><div id="w1-button-group" class="mr-2 btn-group" aria-label="First group" role="group"><button type="button" id="w2-button" class="btn">1</button>
        <button type="button" id="w3-button" class="btn">2</button>
        <button type="button" id="w4-button" class="btn">3</button>
        <button type="button" id="w5-button" class="btn">4</button></div>
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
