<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Yii\Bootstrap5\Button;
use Yiisoft\Yii\Bootstrap5\ButtonType;
use Yiisoft\Yii\Bootstrap5\ButtonVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Button` widget
 *
 * @group button
 */
final class ButtonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testActive(): void
    {
        $buttonWidget = Button::widget()->active()->label('Active toggle button')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary active" data-bs-toggle="button" aria-pressed="true">Active toggle button</button>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Active toggle button</button>
            HTML,
            $buttonWidget->active(false)->render(),
        );
    }

    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary test-class-definition" data-test="test">Label</button>
            HTML,
            Button::widget(config: ['attributes()' => [['class' => 'test-class-definition']]])
                ->addAttributes(['data-test' => 'test'])
                ->label('Label')
                ->id(false)
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $buttonWidget = Button::widget()->addClass('test-class', null)->label('Label')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary test-class">Label</button>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary test-class test-class-1 test-class-2">Label</button>
            HTML,
            $buttonWidget->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $buttonWidget = Button::widget()
            ->addCssStyle(
                [
                    '--bs-btn-padding-y' => '.25rem',
                    '--bs-btn-padding-x' => '.5rem',
                    '--bs-btn-font-size' => '.75rem',
                ]
            )
            ->label('Label')
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Label</button>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: 12px;">Label</button>
            HTML,
            $buttonWidget->addCssStyle('--bs-btn-font-size: 12px;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $buttonWidget = Button::widget()
            ->addCssStyle(
                [
                    '--bs-btn-padding-y' => '.25rem',
                    '--bs-btn-padding-x' => '.5rem',
                    '--bs-btn-font-size' => '.75rem',
                ]
            )
            ->label('Label')
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Label</button>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Label</button>
            HTML,
            $buttonWidget->addCssStyle('--bs-btn-font-size: 12px;', false)->render(),
        );
    }

    public function testAriaExpanded(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" aria-expanded="true">Label</button>
            HTML,
            Button::widget()->ariaExpanded()->label('Label')->id(false)->render(),
        );
    }

    public function testAriaExpandedWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" aria-expanded="false">Label</button>
            HTML,
            Button::widget()->ariaExpanded(false)->label('Label')->id(false)->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary test-class">Label</button>
            HTML,
            Button::widget()->attributes(['class' => 'test-class'])->label('Label')->id(false)->render(),
        );
    }

    public function testAttributesWithId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" id="test-id" class="btn btn-secondary test-class">Label</button>
            HTML,
            Button::widget()
                ->attributes(['class' => 'test-class', 'id' => 'test-id'])
                ->label('Label')
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#block-buttons
     */
    public function testBlock(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary">Block button</button>
            <button type="button" class="btn btn-secondary">Block button</button>
            </div>
            HTML,
            Div::tag()
                ->class('d-grid gap-2')
                ->content(
                    PHP_EOL,
                    Button::widget()->label('Block button')->id(false)->variant(ButtonVariant::PRIMARY),
                    PHP_EOL,
                    Button::widget()->label('Block button')->id(false),
                    PHP_EOL,
                )
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary custom-class another-class">Label</button>
            HTML,
            Button::widget()
                ->addClass('test-class-1', 'test-class-2')
                ->class('custom-class', 'another-class')
                ->label('Label')
                ->id(false)
                ->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testDataBsToggle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" data-bs-toggle="button">Toggle button</button>
            HTML,
            Button::widget()->dataBsToggle('button')->label('Toggle button')->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#disabled-state
     */
    public function testDisabled(): void
    {
        $buttonWidget = Button::widget()->disabled()->label('Label')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary" disabled data-bs-toggle="button">Label</button>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Label</button>
            HTML,
            $buttonWidget->disabled(false)->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" id="test" class="btn btn-secondary">Label</button>
            HTML,
            Button::widget()->id('test')->label('Label')->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Label</button>
            HTML,
            Button::widget()->id('')->label('Label')->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Label</button>
            HTML,
            Button::widget()->id(false)->label('Label')->render(),
        );
    }

    public function testImmutability(): void
    {
        $button = Button::widget();

        $this->assertNotSame($button, $button->active());
        $this->assertNotSame($button, $button->addAttributes([]));
        $this->assertNotSame($button, $button->addClass(''));
        $this->assertNotSame($button, $button->addCssStyle(''));
        $this->assertNotSame($button, $button->attributes([]));
        $this->assertNotSame($button, $button->dataBsToggle(''));
        $this->assertNotSame($button, $button->disabled());
        $this->assertNotSame($button, $button->id(false));
        $this->assertNotSame($button, $button->label('', false));
        $this->assertNotSame($button, $button->largeSize());
        $this->assertNotSame($button, $button->normalSize());
        $this->assertNotSame($button, $button->smallSize());
        $this->assertNotSame($button, $button->type(ButtonType::LINK));
        $this->assertNotSame($button, $button->url(''));
        $this->assertNotSame($button, $button->variant(ButtonVariant::PRIMARY));
    }

    public function testLabelWithEncodeFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary"><Label></button>
            HTML,
            Button::widget()->label('<Label>', false)->id(false)->render(),
        );
    }

    public function testLabelWithEncodeTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">&lt;Label&gt;</button>
            HTML,
            Button::widget()->label('<Label>')->id(false)->render(),
        );
    }

    public function testLabelWithStringable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary"><span>Stringable</span></button>
            HTML,
            Button::widget()->label(Span::tag()->content('Stringable'), false)->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#sizes
     */
    public function testLargeSize(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary btn-lg">Label</button>
            HTML,
            Button::widget()->label('Label')->id(false)->largeSize()->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Label</a>
            HTML,
            Button::link('Label')->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testLinkWithActive(): void
    {
        $buttonWidget = Button::link('Active toggle link')->active()->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary active" data-bs-toggle="button" aria-pressed="true" role="button">Active toggle link</a>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Active toggle link</a>
            HTML,
            $buttonWidget->active(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testLinkWithDataBsToggle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" data-bs-toggle="button" role="button">Toggle link</a>
            HTML,
            Button::link('Toggle link')->dataBsToggle()->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#disabled-state
     */
    public function testLinkWithDisabled(): void
    {
        $buttonWidget = Button::link('Label')->disabled()->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary disabled" data-bs-toggle="button" aria-disabled="true" role="button">Label</a>
            HTML,
            $buttonWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Label</a>
            HTML,
            $buttonWidget->disabled(false)->render(),
        );
    }

    public function testLinkWithUrl(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" href="/test" role="button">Label</a>
            HTML,
            Button::link('Label', '/test')->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#sizes
     */
    public function testNormalSize(): void
    {
        $button = Button::widget()->label('Label')->id(false)->largeSize();

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Label</button>
            HTML,
            $button->normalSize()->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testReset(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="reset" class="btn btn-secondary" value="Reset">
            HTML,
            Button::reset()->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testResetWithLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="reset" class="btn btn-secondary" value="Clear">
            HTML,
            Button::reset('Clear')->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#sizes
     */
    public function testSmallSize(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary btn-sm">Label</button>
            HTML,
            Button::widget()->label('Label')->id(false)->smallSize()->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testSubmit(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="submit" class="btn btn-secondary" value="Submit">
            HTML,
            Button::submit()->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testSubmitWithLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="submit" class="btn btn-secondary" value="Send">
            HTML,
            Button::submit('Send')->id(false)->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testToggleState(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="button">Toggle button</button>
            HTML,
            Button::widget()
                ->dataBsToggle()
                ->label('Toggle button')
                ->id(false)
                ->variant(ButtonVariant::PRIMARY)
                ->render(),
        );
    }

    public function testTypeWithLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Label</a>
            HTML,
            Button::widget()->label('Label')->id(false)->type(ButtonType::LINK)->render(),
        );
    }

    public function testTypeWithLinkAndUrl(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" href="/test" role="button">Label</a>
            HTML,
            Button::widget()->label('Label')->id(false)->type(ButtonType::LINK)->url('/test')->render(),
        );
    }

    public function testTypeWithReset(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="reset" class="btn btn-secondary" value="Reset">
            HTML,
            Button::widget()->id(false)->label('Reset')->type(ButtonType::RESET)->render(),
        );
    }

    public function testTypeWithResetAndLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="reset" class="btn btn-secondary" value="Clear">
            HTML,
            Button::widget()->id(false)->type(ButtonType::RESET)->label('Clear')->render(),
        );
    }

    public function testTypeWithSubmit(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="submit" class="btn btn-secondary" value="Submit">
            HTML,
            Button::widget()->id(false)->label('Submit')->type(ButtonType::SUBMIT)->render(),
        );
    }

    public function testTypeWithSubmitAndLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="submit" class="btn btn-secondary" value="Send">
            HTML,
            Button::widget()->id(false)->label('Send')->type(ButtonType::SUBMIT)->render(),
        );
    }

    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\ButtonProvider::variant
     *
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#examples
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#outline-buttons
     */
    public function testVariant(ButtonVariant $buttonVariant, string $expected): void
    {
        Assert::equalsWithoutLE(
            $expected,
            Button::widget()
                ->label('A simple ' . $buttonVariant->value . ' check it out!')
                ->id(false)
                ->variant($buttonVariant)
                ->render(),
        );
    }
}
