<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;
use Yiisoft\Yii\Bootstrap5\Button;
use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\ButtonVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `ButtonGroup` widget.
 *
 * @group button-group
 */
final class ButtonGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group test-class-definition" data-test="test" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget(config: ['attributes()' => [['class' => 'test-class-definition']]])
                ->addAttributes(['data-test' => 'test'])
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $buttonGroupWidget = ButtonGroup::widget()
            ->addClass('test-class')
            ->buttons(
                Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
            )
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group test-class" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            $buttonGroupWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group test-class test-class-1" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            $buttonGroupWidget->addClass('test-class-1')->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group test" data-test="test" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->attributes(['class' => 'test', 'data-test' => 'test'])
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testAttributesWithId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="btn-group test" data-test="test" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->attributes(['class' => 'test', 'data-test' => 'test', 'id' => 'test-id'])
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#checkbox-and-radio-button-groups
     */
    public function testButtonsWithCheckbox(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="btn-group" aria-label="Basic checkbox toggle button group" role="group">
            <input type="checkbox" id="btncheck1" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>
            <input type="checkbox" id="btncheck2" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>
            <input type="checkbox" id="btncheck3" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btncheck3">Checkbox 3</label>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Basic checkbox toggle button group')
                ->buttons(
                    Checkbox::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btncheck1')
                        ->sideLabel('Checkbox 1', ['class' => 'btn btn-outline-primary']),
                    Checkbox::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btncheck2')
                        ->sideLabel('Checkbox 2', ['class' => 'btn btn-outline-primary']),
                    Checkbox::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btncheck3')
                        ->sideLabel('Checkbox 3', ['class' => 'btn btn-outline-primary']),
                )
                ->id('test')
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#checkbox-and-radio-button-groups
     */
    public function testButtonsWithRadio(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="btn-group" aria-label="Basic radio toggle button group" role="group">
            <input type="radio" id="btnradio1" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>
            <input type="radio" id="btnradio2" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>
            <input type="radio" id="btnradio3" class="btn-check" autocomplete="off"> <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Basic radio toggle button group')
                ->buttons(
                    Radio::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btnradio1')
                        ->sideLabel('Radio 1', ['class' => 'btn btn-outline-primary']),
                    Radio::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btnradio2')
                        ->sideLabel('Radio 2', ['class' => 'btn btn-outline-primary']),
                    Radio::tag()
                        ->attributes(['autocomplete' => 'off'])
                        ->class('btn-check')
                        ->id('btnradio3')
                        ->sideLabel('Radio 3', ['class' => 'btn btn-outline-primary']),
                )
                ->id('test')
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="btn-group" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->id('test')
                ->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->id('')
                ->render(),
        );
    }

    public function testIdWIthFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-secondary">Button B</button>
            <button type="button" class="btn btn-primary">Button A</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->buttons(
                    Button::widget()->id(false)->label('Button B')->variant(ButtonVariant::SECONDARY),
                    Button::widget()->id(false)->label('Button A')->variant(ButtonVariant::PRIMARY),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $buttonGroup = ButtonGroup::widget();

        $this->assertNotSame($buttonGroup, $buttonGroup->addAttributes([]));
        $this->assertNotSame($buttonGroup, $buttonGroup->addClass(''));
        $this->assertNotSame($buttonGroup, $buttonGroup->ariaLabel(''));
        $this->assertNotSame($buttonGroup, $buttonGroup->attributes([]));
        $this->assertNotSame($buttonGroup, $buttonGroup->buttons(Button::widget()));
        $this->assertNotSame($buttonGroup, $buttonGroup->id(false));
        $this->assertNotSame($buttonGroup, $buttonGroup->largeSize());
        $this->assertNotSame($buttonGroup, $buttonGroup->normalSize());
        $this->assertNotSame($buttonGroup, $buttonGroup->smallSize());
        $this->assertNotSame($buttonGroup, $buttonGroup->vertical());
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#sizing
     */
    public function testLargeSize(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group btn-lg" aria-label="Large button group" role="group">
            <button type="button" class="btn btn-outline-dark">Left</button>
            <button type="button" class="btn btn-outline-dark">Middle</button>
            <button type="button" class="btn btn-outline-dark">Right</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Large button group')
                ->buttons(
                    Button::widget()->id(false)->label('Left')->variant(ButtonVariant::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Middle')->variant(ButtonVariant::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Right')->variant(ButtonVariant::OUTLINE_DARK),
                )
                ->largeSize()
                ->id(false)
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#sizing
     */
    public function testNormalSize(): void
    {
        $buttonGroup = ButtonGroup::widget()
            ->ariaLabel('Normal button group')
            ->buttons(
                Button::widget()->id(false)->label('Left')->variant(ButtonVariant::OUTLINE_LIGHT),
                Button::widget()->id(false)->label('Middle')->variant(ButtonVariant::OUTLINE_LIGHT),
                Button::widget()->id(false)->label('Right')->variant(ButtonVariant::OUTLINE_LIGHT),
            )
            ->largeSize()
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group" aria-label="Normal button group" role="group">
            <button type="button" class="btn btn-outline-light">Left</button>
            <button type="button" class="btn btn-outline-light">Middle</button>
            <button type="button" class="btn btn-outline-light">Right</button>
            </div>
            HTML,
            $buttonGroup->normalSize()->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/button-group/#basic-example
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group btn-lg" aria-label="Basic example" role="group">
            <button type="button" class="btn btn-primary">Left</button>
            <button type="button" class="btn btn-primary">Middle</button>
            <button type="button" class="btn btn-primary">Right</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->addClass('btn-lg')
                ->ariaLabel('Basic example')
                ->buttons(
                    Button::widget()->label('Left')->id(false)->variant(ButtonVariant::PRIMARY),
                    Button::widget()->label('Middle')->id(false)->variant(ButtonVariant::PRIMARY),
                    Button::widget()->label('Right')->id(false)->variant(ButtonVariant::PRIMARY),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testRenderWithEmptyButtons(): void
    {
        $this->assertEmpty(ButtonGroup::widget()->render());
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/button-group/#mixed-styles
     */
    public function testRenderWithMizedStyle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group" aria-label="Basic mixed styles example" role="group">
            <button type="button" class="btn btn-danger">Left</button>
            <button type="button" class="btn btn-warning">Middle</button>
            <button type="button" class="btn btn-success">Rigth</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Basic mixed styles example')
                ->buttons(
                    Button::widget()->label('Left')->id(false)->variant(ButtonVariant::DANGER),
                    Button::widget()->label('Middle')->id(false)->variant(ButtonVariant::WARNING),
                    Button::widget()->label('Rigth')->id(false)->variant(ButtonVariant::SUCCESS),
                )
                ->id(false)
                ->render(),
        );
    }

    /**
     * https://getbootstrap.com/docs/5.2/components/button-group/#outlined-styles
     */
    public function testRenderWithOutlinedStyle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group" aria-label="Basic outlined styles example" role="group">
            <button type="button" class="btn btn-outline-primary">Left</button>
            <button type="button" class="btn btn-outline-secondary">Middle</button>
            <button type="button" class="btn btn-outline-success">Right</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Basic outlined styles example')
                ->buttons(
                    Button::widget()->label('Left')->id(false)->variant(ButtonVariant::OUTLINE_PRIMARY),
                    Button::widget()->label('Middle')->id(false)->variant(ButtonVariant::OUTLINE_SECONDARY),
                    Button::widget()->label('Right')->id(false)->variant(ButtonVariant::OUTLINE_SUCCESS),
                )
                ->id(false)
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#sizing
     */
    public function testSmallSize(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group btn-sm" aria-label="Small button group" role="group">
            <button type="button" class="btn btn-outline-dark">Left</button>
            <button type="button" class="btn btn-outline-dark">Middle</button>
            <button type="button" class="btn btn-outline-dark">Right</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Small button group')
                ->buttons(
                    Button::widget()->id(false)->label('Left')->variant(ButtonVariant::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Middle')->variant(ButtonVariant::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Right')->variant(ButtonVariant::OUTLINE_DARK),
                )
                ->smallSize()
                ->id(false)
                ->render(),
        );
    }

    /**
     * https://getbootstrap.com/docs/5.2/components/button-group/#vertical-variation
     */
    public function testVertical(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-group btn-group-vertical" aria-label="Vertical button group" role="group">
            <button type="button" class="btn btn-dark">Top</button>
            <button type="button" class="btn btn-dark">Middle</button>
            <button type="button" class="btn btn-dark">Bottom</button>
            </div>
            HTML,
            ButtonGroup::widget()
                ->ariaLabel('Vertical button group')
                ->buttons(
                    Button::widget()->id(false)->label('Top')->variant(ButtonVariant::DARK),
                    Button::widget()->id(false)->label('Middle')->variant(ButtonVariant::DARK),
                    Button::widget()->id(false)->label('Bottom')->variant(ButtonVariant::DARK),
                )
                ->id(false)
                ->vertical()
                ->render(),
        );
    }
}
