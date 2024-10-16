<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\{Button, ButtonGroup, ButtonToolbar, ButtonType};
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `ButtonToolbar` widget.
 *
 * @group button-toolbar
 */
final class ButtonToolbarTest extends TestCase
{
    public function testAddClass(): void
    {
        $buttonToolbar = ButtonToolbar::widget()
            ->addClass('test-class')
            ->ariaLabel('Toolbar with button groups')
            ->buttonGroups(
                ButtonGroup::widget()
                    ->addClass('me-2')
                    ->ariaLabel('First group')
                    ->buttons(
                        Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                        Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                        Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                        Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
                    )
                    ->id(false),
            )
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar test-class" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
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
            <div class="btn-toolbar test-class test-class-1" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            $buttonToolbar->addClass('test-class-1')->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="btn-toolbar" data-id="1" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
            <button type="button" class="btn btn-primary">1</button>
            <button type="button" class="btn btn-primary">2</button>
            <button type="button" class="btn btn-primary">3</button>
            <button type="button" class="btn btn-primary">4</button>
            </div>
            </div>
            HTML,
            ButtonToolbar::widget()
                ->attributes(['data-id' => '1'])
                ->ariaLabel('Toolbar with button groups')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
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
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
                        )
                        ->id(false),
                )
                ->id('test')
                ->render(),
        );
    }

    public function testIdWithEmpty(): void
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
            </div>
            HTML,
            ButtonToolbar::widget()
                ->ariaLabel('Toolbar with button groups')
                ->buttonGroups(
                    ButtonGroup::widget()
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
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
            <div class="btn-toolbar" aria-label="Toolbar with button groups" role="toolbar">
            <div class="btn-group me-2" aria-label="First group" role="group">
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
                        ->addClass('me-2')
                        ->ariaLabel('First group')
                        ->buttons(
                            Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
                        )
                        ->id(false),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $buttonToolbar = ButtonToolbar::widget();

        $this->assertNotSame($buttonToolbar, $buttonToolbar->addClass(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->ariaLabel(''));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->attributes([]));
        $this->assertNotSame($buttonToolbar, $buttonToolbar->buttonGroups());
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
                            Button::widget()->id(false)->label('1')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('2')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('3')->type(ButtonType::PRIMARY),
                            Button::widget()->id(false)->label('4')->type(ButtonType::PRIMARY),
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
                            Button::widget()->id(false)->label('8')->type(ButtonType::INFO),
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
}
