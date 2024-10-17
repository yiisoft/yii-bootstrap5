<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\{Button, ButtonGroup, ButtonType};
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `ButtonGroup` widget.
 *
 * @group button-group
 */
final class ButtonGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testAddClass(): void
    {
        $buttonGroupWidget = ButtonGroup::widget()
            ->addClass('test-class')
            ->buttons(
                Button::widget()->id(false)->label('Button B'),
                Button::widget()->id(false)->label('Button A')->type(ButtonType::PRIMARY),
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
                    Button::widget()->id(false)->label('Button B'),
                    Button::widget()->id(false)->label('Button A')->type(ButtonType::PRIMARY),
                )
                ->id(false)
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
                    Button::widget()->id(false)->label('Button B'),
                    Button::widget()->id(false)->label('Button A')->type(ButtonType::PRIMARY),
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
                    Button::widget()->id(false)->label('Button B'),
                    Button::widget()->id(false)->label('Button A')->type(ButtonType::PRIMARY),
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
                    Button::widget()->id(false)->label('Button B'),
                    Button::widget()->id(false)->label('Button A')->type(ButtonType::PRIMARY),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $buttonGroup = ButtonGroup::widget();

        $this->assertNotSame($buttonGroup, $buttonGroup->addClass(''));
        $this->assertNotSame($buttonGroup, $buttonGroup->ariaLabel(''));
        $this->assertNotSame($buttonGroup, $buttonGroup->attributes([]));
        $this->assertNotSame($buttonGroup, $buttonGroup->buttons(Button::widget()));
        $this->assertNotSame($buttonGroup, $buttonGroup->id(false));
        $this->assertNotSame($buttonGroup, $buttonGroup->large());
        $this->assertNotSame($buttonGroup, $buttonGroup->small());
        $this->assertNotSame($buttonGroup, $buttonGroup->vertical());
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#sizing
     */
    public function testLarge(): void
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
                    Button::widget()->id(false)->label('Left')->type(ButtonType::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Middle')->type(ButtonType::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Right')->type(ButtonType::OUTLINE_DARK),
                )
                ->large()
                ->id(false)
                ->render(),
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
                    Button::widget()->label('Left')->id(false)->type(ButtonType::PRIMARY),
                    Button::widget()->label('Middle')->id(false)->type(ButtonType::PRIMARY),
                    Button::widget()->label('Right')->id(false)->type(ButtonType::PRIMARY),
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
                    Button::widget()->label('Left')->id(false)->type(ButtonType::DANGER),
                    Button::widget()->label('Middle')->id(false)->type(ButtonType::WARNING),
                    Button::widget()->label('Rigth')->id(false)->type(ButtonType::SUCCESS),
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
                    Button::widget()->label('Left')->id(false)->type(ButtonType::OUTLINE_PRIMARY),
                    Button::widget()->label('Middle')->id(false)->type(ButtonType::OUTLINE_SECONDARY),
                    Button::widget()->label('Right')->id(false)->type(ButtonType::OUTLINE_SUCCESS),
                )
                ->id(false)
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/button-group/#sizing
     */
    public function testSmall(): void
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
                    Button::widget()->id(false)->label('Left')->type(ButtonType::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Middle')->type(ButtonType::OUTLINE_DARK),
                    Button::widget()->id(false)->label('Right')->type(ButtonType::OUTLINE_DARK),
                )
                ->small()
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
                    Button::widget()->id(false)->label('Top')->type(ButtonType::DARK),
                    Button::widget()->id(false)->label('Middle')->type(ButtonType::DARK),
                    Button::widget()->id(false)->label('Bottom')->type(ButtonType::DARK),
                )
                ->id(false)
                ->vertical()
                ->render(),
        );
    }
}
