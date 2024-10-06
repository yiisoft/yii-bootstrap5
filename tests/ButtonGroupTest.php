<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;
use Yiisoft\Html\Tag\Label;
use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Link;

/**
 * Tests for `ButtonGroup` widget.
 */
final class ButtonGroupTest extends TestCase
{
    public function testRender(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->items(
                Link::widget()->label('button-A')->id('BTN1'),
                Link::widget()->label('button-B')->id('BTN2'),
                Link::widget()->label('button-C')->visible(false),
                Link::widget()->label('button-D')->id('BTN4')
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="button" id="BTN1" class="btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button>
        <button type="button" id="BTN4" class="btn">button-D</button></div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testButtonOptions(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->items(
                Link::widget()->label('button-A')->id('BTN1')->options(['class' => 'btn-primary', 'type' => 'submit']),
                Link::widget()->label('button-B')->id('BTN2'),
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group"><button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button></div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public static function sizeDataProvider(): array
    {
        return [
            [Size::Small],
            [Size::Large],
            [null],
        ];
    }

    /**
     * @dataProvider sizeDataProvider
     */
    public function testSize(?Size $size): void
    {
        $widget = ButtonGroup::widget()
            ->id('TEST_ID')
            ->items(
                Link::widget()->label('button-A')->id('BTN1')->options(['class' => 'btn-primary', 'type' => 'submit']),
                Link::widget()->label('button-B')->id('BTN2'),
            );

        $widget = match ($size) {
            Size::Small => $widget->small(),
            Size::Large => $widget->large(),
            null => $widget->normal(),
        };

        if ($size) {
            $this->assertStringStartsWith('<div id="TEST_ID" class="btn-group ' . $size->formatClassName('btn-group') . '" role="group">', (string)$widget);
        } else {
            $this->assertStringStartsWith('<div id="TEST_ID" class="btn-group" role="group">', (string)$widget);
        }
    }

    public function testOptions(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->options([
                'aria-label' => 'Test label',
            ])
            ->items(
                Link::widget()->label('button-A')->id('BTN1')->options(['class' => 'btn-primary', 'type' => 'submit']),
                Link::widget()->label('button-B')->id('BTN2'),
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" aria-label="Test label" role="group">
        <button type="submit" id="BTN1" class="btn-primary btn">button-A</button>
        <button type="button" id="BTN2" class="btn">button-B</button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public static function verticalDataProvider(): array
    {
        return [
            [false, MenuType::BtnGroup->value],
            [true, MenuType::BtnGroupVertical->value],
        ];
    }

    /**
     * @dataProvider verticalDataProvider
     */
    public function testVertical(bool $vertical, string $expected): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->vertical($vertical)
            ->items(
                Link::widget()->label('button-A')->id('BTN1')->options(['class' => 'btn-primary', 'type' => 'submit']),
                Link::widget()->label('button-B')->id('BTN2'),
            )
            ->render();

        $this->assertStringStartsWith('<div id="TEST_ID" class="' . $expected . '" role="group">', $html);
    }

    public function testCheckboxes(): void
    {
        $label = Label::tag()->attributes(['class' => 'btn btn-outline-primary']);

        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->items(
                Checkbox::tag()->id('btncheck1'),
                $label->forId('btncheck1')->content('Checkbox 1'),
                Checkbox::tag()->id('btncheck2')->sideLabel('Checkbox 2', ['class' => 'btn btn-outline-primary']),
                Checkbox::tag()->id('btncheck3')->label('Checkbox 3', ['class' => 'btn btn-outline-primary']),
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group">
        <input type="checkbox" id="btncheck1" class="btn-check">
        <label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>
        <input type="checkbox" id="btncheck2" class="btn-check">
         <label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>
        <label class="btn btn-outline-primary">
        <input type="checkbox" id="btncheck3" class="btn-check">
         Checkbox 3
        </label>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testRadio(): void
    {
        $radio = Radio::tag()->name('btnradio');
        $label = Label::tag()->attributes(['class' => 'btn btn-outline-primary']);

        $html = ButtonGroup::widget()
            ->id('TEST_ID')
            ->items(
                $radio->id('btncheck1'),
                $label->forId('btncheck1')->content('Radio 1'),
                $radio->id('btncheck2')->sideLabel('Radio 2', ['class' => 'btn btn-outline-primary']),
                $radio->id('btncheck3')->label('Radio 3', ['class' => 'btn btn-outline-primary']),
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group">
        <input type="radio" id="btncheck1" class="btn-check" name="btnradio">
        <label class="btn btn-outline-primary" for="btncheck1">Radio 1</label>
        <input type="radio" id="btncheck2" class="btn-check" name="btnradio">
         <label class="btn btn-outline-primary" for="btncheck2">Radio 2</label>
        <label class="btn btn-outline-primary">
        <input type="radio" id="btncheck3" class="btn-check" name="btnradio">
         Radio 3
        </label>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testDropdown(): void
    {
        $html = ButtonGroup::widget()
            ->id('TEST_ID')
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
                        Link::widget()->id('')->url('#')->label('Dropdown link'),
                    )
            )
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="btn-group" role="group">
        <button type="button" id class="btn-primary btn">1</button>
        <button type="button" id class="btn-primary btn">2</button>
        <div class="dropdown btn-group">
        <button type="button" id class="btn btn-primary dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Dropdown</button>
        <ul id="test-dropdown" class="dropdown-menu">
        <li><a id class="dropdown-item" href="#">Dropdown link</a></li>
        <li><a id class="dropdown-item" href="#">Dropdown link</a></li>
        </ul>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testImmutable(): void
    {
        $group = ButtonGroup::widget();

        $this->assertNotSame($group, $group->vertical(true));
        $this->assertNotSame($group, $group->small());
        $this->assertNotSame($group, $group->large());
        $this->assertNotSame($group, $group->normal());
        $this->assertNotSame($group, $group->items());
    }
}
