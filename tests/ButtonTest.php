<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Yii\Bootstrap5\{Button, ButtonType};
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Button` widget
 *
 * @group button
 */
final class ButtonTest extends TestCase
{
    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testActive(): void
    {
        $buttonWidget = Button::widget()->active()->label('Active toggle button')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary active" aria-pressed="true" data-bs-toggle="button">Active toggle button</button>
            HTML,
            $buttonWidget->render(),
        );

        $buttonWidget = $buttonWidget->active(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Active toggle button</button>
            HTML,
            $buttonWidget->render(),
        );
    }

    public function testAddClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary test-class">Label</button>
            HTML,
            Button::widget()->addClass('test-class')->label('Label')->id(false)->render(),
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
                    Button::widget()->label('Block button')->id(false)->type(ButtonType::PRIMARY),
                    PHP_EOL,
                    Button::widget()->label('Block button')->id(false),
                    PHP_EOL,
                )
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
            <button type="button" class="btn btn-secondary" disabled>Label</button>
            HTML,
            $buttonWidget->render(),
        );

        $buttonWidget = $buttonWidget->disabled(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary">Label</button>
            HTML,
            $buttonWidget->render(),
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
        $this->assertNotSame($button, $button->addClass(''));
        $this->assertNotSame($button, $button->attributes([]));
        $this->assertNotSame($button, $button->dataBsToggle(''));
        $this->assertNotSame($button, $button->disabled());
        $this->assertNotSame($button, $button->id(false));
        $this->assertNotSame($button, $button->label('', false));
        $this->assertNotSame($button, $button->large());
        $this->assertNotSame($button, $button->link());
        $this->assertNotSame($button, $button->reset());
        $this->assertNotSame($button, $button->small());
        $this->assertNotSame($button, $button->submit());
        $this->assertNotSame($button, $button->tagName('a'));
        $this->assertNotSame($button, $button->type(ButtonType::PRIMARY));
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

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#sizes
     */
    public function testLarge(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary btn-lg">Label</button>
            HTML,
            Button::widget()->label('Label')->id(false)->large()->render(),
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
            Button::widget()->label('Label')->id(false)->link()->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#toggle-states
     */
    public function testLinkWithActive(): void
    {
        $buttonWidget = Button::widget()->active()->label('Active toggle link')->id(false)->link();

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary active" aria-pressed="true" data-bs-toggle="button" role="button">Active toggle link</a>
            HTML,
            $buttonWidget->render(),
        );

        $buttonWidget = $buttonWidget->active(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Active toggle link</a>
            HTML,
            $buttonWidget->render(),
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
            Button::widget()->dataBsToggle('button')->label('Toggle link')->id(false)->link()->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#disabled-state
     */
    public function testLinkWithDisabled(): void
    {
        $buttonWidget = Button::widget()->disabled()->label('Label')->id(false)->link();

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary disabled" aria-disabled="true" role="button">Label</a>
            HTML,
            $buttonWidget->render(),
        );

        $buttonWidget = $buttonWidget->disabled(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <a class="btn btn-secondary" role="button">Label</a>
            HTML,
            $buttonWidget->render(),
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
            Button::widget()->id(false)->reset()->render(),
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
            Button::widget()->id(false)->reset()->label('Clear')->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#sizes
     */
    public function testSmall(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-secondary btn-sm">Label</button>
            HTML,
            Button::widget()->label('Label')->id(false)->small()->render(),
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
            Button::widget()->id(false)->submit()->render(),
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
            Button::widget()->id(false)->submit()->label('Send')->render(),
        );
    }

    /**
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#button-tags
     */
    public function testTagName(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <input type="button" class="btn btn-secondary" value="Input">
            HTML,
            Button::widget()->id(false)->label('Input')->tagName('input')->render(),
        );
    }

    public function testTagNameWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tag name, use "button", "input", or "a".');

        Button::widget()->tagName('')->render();
    }

    public function testTagNameWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid tag name, use "button", "input", or "a".');

        Button::widget()->tagName('test')->render();
    }

    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\ButtonProvider::type()
     *
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#examples
     * @see https://getbootstrap.com/docs/5.2/components/buttons/#outline-buttons
     */
    public function testType(ButtonType $buttonType, string $expected): void
    {
        Assert::equalsWithoutLE(
            $expected,
            Button::widget()
                ->label('A simple ' . $buttonType->value . ' check it out!')
                ->id(false)
                ->type($buttonType)
                ->render(),
        );
    }
}
