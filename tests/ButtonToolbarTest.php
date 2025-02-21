<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Yii\Bootstrap5\Button;
use Yiisoft\Yii\Bootstrap5\ButtonGroup;
use Yiisoft\Yii\Bootstrap5\ButtonToolbar;
use Yiisoft\Yii\Bootstrap5\ButtonVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `ButtonToolbar` widget.
 */
#[Group('button-toolbar')]
final class ButtonToolbarTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" data-id="123" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->addAttributes(['data-id' => '123'])
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $buttonToolbar = ButtonToolbar::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->buttonGroups(
                ButtonGroup::widget()
                    ->buttons(
                        Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                    )
                    ->id(false),
            )
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar test-class bg-primary" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar test-class bg-primary test-class-1 test-class-2" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $buttonToolbar = ButtonToolbar::widget()
            ->addCssStyle('color: red;')
            ->buttonGroups(
                ButtonGroup::widget()
                    ->buttons(
                        Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                    )
                    ->id(false),
            )
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" style="color: red;" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" style="color: red; font-weight: bold;" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $buttonToolbar = ButtonToolbar::widget()
            ->addCssStyle('color: red;')
            ->buttonGroups(
                ButtonGroup::widget()
                    ->buttons(
                        Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                        Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                    )
                    ->id(false),
            )
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" style="color: red;" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" style="color: red;" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->addCssStyle('color: blue;', false)->render(),
        );
    }

    public function testAriaLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->ariaLabel('Toolbar with button groups')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" data-id="123" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->attribute('data-id', '123')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar custom-class another-class bg-primary" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->addClass('test-class')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->id(false)
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="btn-toolbar" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id('test-id')
                ->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id('')
                ->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testIdWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="btn-toolbar" role="toolbar">
            <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->attributes(['id' => 'test-id'])
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                )
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $buttonToolbar = ButtonToolbar::widget();

        $this->assertNotSame($buttonToolbar, $buttonToolbar->addAttributes([]));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->addClass(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->addClass(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->addCssStyle(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->ariaLabel(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->ariaLabel(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->attribute('', ''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->attributes([]));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->buttonGroups());
        $this->assertNotSame($buttonToolbar, $buttonToolbar->class(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->id(false));
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/button-group/#button-toolbar
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            <div class="btn-group me-2" aria-label="Second group" role="group">
            <button type="button" class="btn btn-secondary">5</button>
            <button type="button" class="btn btn-secondary">6</button>
            <button type="button" class="btn btn-secondary">7</button>
            </div>
            <div class="btn-group" aria-label="Third group" role="group">
            <button type="button" class="btn btn-info">8</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->ariaLabel('Toolbar with button groups')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                    ButtonGroup::widget()
                        ->addClass('me-2')
                        ->ariaLabel('Second group')
                        ->buttons(
                            Button::widget()->id(false)->label('5'),
                            Button::widget()->id(false)->label('6'),
                            Button::widget()->id(false)->label('7'),
                        )
                        ->id(false),
                    ButtonGroup::widget()
                        ->ariaLabel('Third group')
                        ->buttons(
                            Button::widget()->id(false)->label('8')->variant(ButtonVariant::INFO),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testRenderWithEmptyButtonGroups(): void
    {
        $this->assertEmpty(ButtonToolbar::widget()->render());
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/button-group/#button-toolbar
     */
    public function testTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            <div class="input-group">
            <div id="btnGroupAddon" class="input-group-text">@</div>
            <input class="form-control" aria-label="Input group example" aria-describedby="btnGroupAddon" placeholder="Input group example">
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->ariaLabel('Toolbar with button groups')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('2')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('3')->variant(ButtonVariant::PRIMARY),
                            Button::widget()->id(false)->label('4')->variant(ButtonVariant::PRIMARY),
                        )
                        ->id(false),
                    Div::tag()
                        ->addClass('input-group')
                        ->content(
                            "\n",
                            Div::tag()->class('input-group-text')->content('@')->id('btnGroupAddon'),
                            "\n",
                            Input::text()
                                ->attributes(
                                    [
                                        'aria-label' => 'Input group example',
                                        'aria-describedby' => 'btnGroupAddon',
                                        'placeholder' => 'Input group example',
                                    ]
                                )
                                ->class('form-control'),
                            "\n",
                        ),
                )
                ->id(false)
                ->render(),
        );
    }
}
