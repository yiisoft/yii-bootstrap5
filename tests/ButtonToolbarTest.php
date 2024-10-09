<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\ButtonToolbar;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Link;

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
            ->items(
                ButtonGroup::widget()
                    ->id('BG1')
                    ->options([
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ])
                    ->items(
                        Link::widget()->id('BTN1')->label('1'),
                        Link::widget()->id('BTN2')->label('2'),
                        Link::widget()->id('BTN3')->label('3'),
                        Link::widget()->id('BTN4')->label('4'),
                    ),
                ButtonGroup::widget()
                    ->id('BG2')
                    ->options([
                        'aria-label' => 'Second group',
                    ])
                    ->items(
                        Link::widget()->id('BTN5')->label('5'),
                        Link::widget()->id('BTN6')->label('6'),
                        Link::widget()->id('BTN7')->label('7'),
                    ),
            )
            ->render();
        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
        <div id="BG1" class="mr-2 btn-group" aria-label="First group" role="group">
        <button type="button" id="BTN1" class="btn">1</button>
        <button type="button" id="BTN2" class="btn">2</button>
        <button type="button" id="BTN3" class="btn">3</button>
        <button type="button" id="BTN4" class="btn">4</button>
        </div>
        <div id="BG2" class="btn-group" aria-label="Second group" role="group">
        <button type="button" id="BTN5" class="btn">5</button>
        <button type="button" id="BTN6" class="btn">6</button>
        <button type="button" id="BTN7" class="btn">7</button>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testButtonGroupEmpty(): void
    {
        $html = ButtonToolbar::widget()
            ->id('TEST_ID')
            ->items()
            ->render();

        $this->assertEmpty($html);
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
            ->items(
                ButtonGroup::widget()
                    ->id('BG1')
                    ->options([
                        'aria-label' => 'First group',
                        'class' => ['mr-2'],
                    ])
                    ->items(
                        Link::widget()->id('BTN1')->label('1'),
                        Link::widget()->id('BTN2')->label('2'),
                        Link::widget()->id('BTN3')->label('3'),
                        Link::widget()->id('BTN4')->label('4'),
                    ),
                $addHtml,
            )
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
        $this->assertEqualsHTML($expected, $html);
    }

    public function testImmutable(): void
    {
        $toolbar = ButtonToolbar::widget();

        $this->assertNotSame($toolbar, $toolbar->items());
    }

    public function testActivateParents(): void
    {
        $html = ButtonToolbar::widget()
                    ->id('TEST_TOOLBAR')
                    ->activateParents(true)
                    ->items(
                        ButtonGroup::widget()
                            ->id('TEST_ID')
                            ->activateParents(true)
                            ->items(
                                Link::widget()->id('')->options(['class' => 'btn-primary'])->label('1'),
                                Link::widget()->id('')->options(['class' => 'btn-primary'])->label('2'),
                                Dropdown::widget()
                                    ->id('test-dropdown')
                                    ->toggle(
                                        Link::widget()->id('')->label('Dropdown')->options(['class' => 'btn btn-primary'])
                                    )
                                    ->items(
                                        Link::widget()->id('')->url('#')->label('Dropdown link'),
                                        Link::widget()->id('')->url('#')->label('Dropdown link')->active(true),
                                    )
                            )
                    )
                    ->render();

        $expected = <<<'HTML'
        <div id="TEST_TOOLBAR" class="btn-toolbar" role="toolbar">
        <div id="TEST_ID" class="btn-group" role="group">
        <button type="button" id class="btn-primary btn">1</button>
        <button type="button" id class="btn-primary btn">2</button>
        <div class="dropdown btn-group">
        <button type="button" id class="btn btn-primary dropdown-toggle active" aria-expanded="false" data-bs-toggle="dropdown">Dropdown</button>
        <ul id="test-dropdown" class="dropdown-menu">
        <li><a id class="dropdown-item" href="#">Dropdown link</a></li>
        <li><a id class="dropdown-item active" href="#">Dropdown link</a></li>
        </ul>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }
}
