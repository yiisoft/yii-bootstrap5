<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Alert;
use Yiisoft\Yii\Bootstrap5\AlertVariant;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Alert` widget.
 *
 * @group alert
 */
final class AlertTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary test-class" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->attributes(['class' => 'test-class'])->body('Body')->id(false)->render(),
        );
    }

    public function testAddCssClass(): void
    {
        $alert = Alert::widget()->addClass('test-class')->body('Body')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary test-class" role="alert">
            Body
            </div>
            HTML,
            $alert->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary test-class test-class-1" role="alert">
            Body
            </div>
            HTML,
            $alert->addClass('test-class-1')->render(),
        );
    }

    public function testBodyWithEncodeFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            <body>
            </div>
            HTML,
            Alert::widget()->body('<body>', false)->id(false)->render(),
        );
    }

    public function testBodyWithEncodeTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            &lt;body&gt;
            </div>
            HTML,
            Alert::widget()->body('<body>')->id(false)->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#dismissing
     */
    public function testDismissable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.', false)
                ->dismissable(true)
                ->fade(true)
                ->id(false)
                ->render(),
        );
    }

    public function testDismissableWithCloseButtonAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="alert alert-secondary alert-dismissible" role="alert">
            Body
            <button type="button" class="btn-lg btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->closeButtonAttributes(['class' => 'btn-lg'])
                ->dismissable(true)
                ->id('test')
                ->render(),
        );
    }

    public function testHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            <h5 class="header-class alert-heading">Alert header</h5>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->id(false)
                ->header('Alert header')
                ->headerTag('h5')
                ->headerAttributes(['class' => 'header-class'])
                ->render(),
        );
    }

    public function testHeaderTagException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag cannot be empty string.');

        Alert::widget()->header('Header')->headerTag('')->render();
    }

    public function testHeaderWithEncodeFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            <h5 class="header-class alert-heading"><header></h5>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->id(false)
                ->header('<header>', false)
                ->headerTag('h5')
                ->headerAttributes(['class' => 'header-class'])
                ->render(),
        );
    }

    public function testHeaderWithEncodeTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            <h5 class="header-class alert-heading">&lt;header&gt;</h5>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->id(false)
                ->header('<header>')
                ->headerTag('h5')
                ->headerAttributes(['class' => 'header-class'])
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="alert alert-secondary" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->id('test')->body('Body')->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->id('')->body('Body')->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->id(false)->body('Body')->render(),
        );
    }

    public function testIdWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="alert alert-secondary" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->attributes(['id' => 'test'])->body('Body')->render(),
        );
    }

    public function testImmutability(): void
    {
        $alert = Alert::widget();

        $this->assertNotSame($alert, $alert->addClass(''));
        $this->assertNotSame($alert, $alert->attributes([]));
        $this->assertNotSame($alert, $alert->body('', true));
        $this->assertNotSame($alert, $alert->closeButtonAttributes([]));
        $this->assertNotSame($alert, $alert->dismissable(false));
        $this->assertNotSame($alert, $alert->fade(false));
        $this->assertNotSame($alert, $alert->id(false));
        $this->assertNotSame($alert, $alert->header('', false));
        $this->assertNotSame($alert, $alert->headerAttributes([]));
        $this->assertNotSame($alert, $alert->headerTag('div'));
        $this->assertNotSame($alert, $alert->id(false));
        $this->assertNotSame($alert, $alert->templateContent(''));
        $this->assertNotSame($alert, $alert->variant(AlertVariant::PRIMARY));
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#link-color
     */
    public function testRenderLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-warning" role="alert">
            A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
            </div>
            HTML,
            Alert::widget()
                ->body(
                    'A simple warning alert with ' .
                    '<a href="#" class="alert-link">an example link</a>. Give it a click if you like.',
                    false,
                )
                ->id(false)
                ->variant(AlertVariant::WARNING)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#icons
     */
    public function testRenderIcon(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary d-flex align-items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
            <div>An example alert with an icon</div>
            </div>
            HTML,
            Alert::widget()
                ->addClass('d-flex align-items-center')
                ->body(
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">' .
                    '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>' .
                    '</svg>' . PHP_EOL .
                    '<div>An example alert with an icon</div>',
                    false,
                )
                ->id(false)
                ->render(),
        );
    }

    public function testTemplateContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-secondary alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->dismissable(true)
                ->id(false)
                ->templateContent("\n{toggle}\n{body}\n")
                ->render(),
        );
    }

    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\AlertProvider::variant()
     */
    public function testVariant(AlertVariant $alertVariant, string $expected): void
    {
        Assert::equalsWithoutLE(
            $expected,
            Alert::widget()
                ->body('A simple ' . $alertVariant->value . ' check it out!')
                ->id(false)
                ->variant($alertVariant)
                ->render(),
        );
    }
}
