<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Toast;
use Yiisoft\Yii\Bootstrap5\Utility\AlignItems;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;
use Yiisoft\Yii\Bootstrap5\Utility\TextColor;

/**
 * Tests for `Toast` widget.
 */
#[Group('toast')]
final class ToastTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" data-id="123" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->addAttributes(['data-id' => '123'])
                ->body('Hello, world! This is a toast message.')
                ->id(false)->render(),
        );
    }

    public function testAddClass(): void
    {
        $toast = Toast::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->body('Hello, world! This is a toast message.')
            ->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast test-class bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast test-class bg-primary test-class-1 test-class-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $toast = Toast::widget()->addCssStyle('color: red;')->body('Hello, world! This is a toast message.')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" style="color: red;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" style="color: red; font-weight: bold;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $toast = Toast::widget()->addCssStyle('color: red;')->body('Hello, world! This is a toast message.')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" style="color: red;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" style="color: red;" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            $toast->addCssStyle('color: blue;', false)->render(),
        );
    }

    public function testAttribute(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" data-id="123" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->attribute('data-id', '123')
                ->body('Hello, world! This is a toast message.')
                ->id(false)
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast test-class" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->attributes(['class' => 'test-class'])
                ->body('Hello, world! This is a toast message.')
                ->id(false)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/toasts/#basic
     */
    public function testBasic(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img class="rounded me-2" src="https://example.com/150" alt="Bootstrap5">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->body('Hello, world! This is a toast message.')
                ->id(false)
                ->image('https://example.com/150', 'Bootstrap5', ['class' => 'rounded me-2'])
                ->time('11 mins ago')
                ->title('Bootstrap')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/toasts/#custom-content
     */
    public function testBodyWithStringableValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            <div class="mt-2 pt-2 border-top">
            <button type="button" class="btn btn-primary me-2">Take action</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
            </div>
            </div>
            </div>
            HTML,
            Toast::widget()
                ->addClass(AlignItems::CENTER)
                ->body(
                    Div::tag()
                        ->addClass('toast-body')
                        ->content(
                            "\n",
                            'Hello, world! This is a toast message.',
                            "\n",
                            Div::tag()
                                ->addClass('mt-2 pt-2 border-top')
                                ->content(
                                    "\n",
                                    Button::button('Take action')
                                        ->addClass('btn btn-primary me-2'),
                                    "\n",
                                    Button::button('Close')
                                        ->addClass('btn btn-secondary btn-sm')
                                        ->attribute('data-bs-dismiss', 'toast'),
                                    "\n",
                                ),
                            "\n",
                        ),
                )
                ->id(false)
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast custom-class another-class bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->addClass('test-class')
                ->body('Hello, world! This is a toast message.')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->id(false)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/toasts/#custom-content
     */
    public function testCustomContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            </div>
            HTML,
            Toast::widget()
                ->addClass(AlignItems::CENTER)
                ->content(
                    <<<HTML
                    <div class="d-flex">
                    <div class="toast-body">
                    Hello, world! This is a toast message.
                    </div>
                    button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    HTML,
                )
                ->id(false)
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()->body('Hello, world! This is a toast message.')->id('test-id')->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()->body('Hello, world! This is a toast message.')->id('')->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()->body('Hello, world! This is a toast message.')->id(false)->render(),
        );
    }

    public function testIdWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()->attributes(['id' => 'test-id'])->body('Hello, world! This is a toast message.')->render(),
        );
    }

    public function testImmutability(): void
    {
        $toast = Toast::widget();

        $this->assertNotSame($toast, $toast->addAttributes([]));
        $this->assertNotSame($toast, $toast->addClass(''));
        $this->assertNotSame($toast, $toast->addCssStyle(''));
        $this->assertNotSame($toast, $toast->attribute('', ''));
        $this->assertNotSame($toast, $toast->attributes([]));
        $this->assertNotSame($toast, $toast->body(''));
        $this->assertNotSame($toast, $toast->class(''));
        $this->assertNotSame($toast, $toast->closeButton(''));
        $this->assertNotSame($toast, $toast->container(false));
        $this->assertNotSame($toast, $toast->content(''));
        $this->assertNotSame($toast, $toast->headerAttributes([]));
        $this->assertNotSame($toast, $toast->id(''));
        $this->assertNotSame($toast, $toast->image(''));
        $this->assertNotSame($toast, $toast->time(''));
        $this->assertNotSame($toast, $toast->title(''));
        $this->assertNotSame($toast, $toast->triggerButton());
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/toasts/#live-example
     */
    public function testLive(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" id="liveToastBtn" class="btn btn-primary">Show live toast</button>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img class="rounded me-2" src="https://example.com/150" alt="Bootstrap5">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            </div>
            HTML,
            Toast::widget()
                ->body('Hello, world! This is a toast message.')
                ->id('liveToast')
                ->image('https://example.com/150', 'Bootstrap5', ['class' => 'rounded me-2'])
                ->time('11 mins ago')
                ->title('Bootstrap')
                ->triggerButton(attributes: ['id' => 'liveToastBtn'])
                ->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertEmpty(Toast::widget()->render());
    }

    /**
     * https://getbootstrap.com/docs/5.3/components/toasts/#translucent
     */
    public function testTranslucent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
            <img class="rounded me-2" src="https://example.com/150" alt="Bootstrap5">
            <strong class="me-auto">Bootstrap</strong>
            <small class="text-body-secondary">11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            Hello, world! This is a toast message.
            </div>
            </div>
            HTML,
            Toast::widget()
                ->body('Hello, world! This is a toast message.')
                ->id(false)
                ->image('https://example.com/150', 'Bootstrap5', ['class' => 'rounded me-2'])
                ->time('11 mins ago', class: TextColor::BODY_SECONDARY)
                ->title('Bootstrap')
                ->render(),
        );
    }
}
