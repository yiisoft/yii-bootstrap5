<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Alert;
use Yiisoft\Yii\Bootstrap5\Enum\{ErrorMessage, Type};
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
            <div class="alert alert-warning" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->attributes(['class' => 'alert alert-warning'])->body('Body')->render(),
        );
    }

    public function testBodyWithEncodeTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert" role="alert">
            &lt;body&gt;
            </div>
            HTML,
            Alert::widget()->body('<body>', true)->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#dismissing
     */
    public function testDismissing(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                ->class('alert-warning')
                ->dismissing()
                ->fade()
                ->generateId(false)
                ->render(),
        );
    }

    public function testDismissingWithPositionAfterContainer(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            HTML,
            Alert::widget()
                ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                ->class('alert-warning')
                ->dismissing()
                ->fade()
                ->generateId(false)
                ->template("{widget}\n{toggle}")
                ->templateContent("\n{header}\n{body}\n")
                ->render(),
        );
    }

    public function testDismissingWithPositionBeforeContainer(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            </div>
            HTML,
            Alert::widget()
                ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
                ->class('alert-warning')
                ->dismissing()
                ->fade()
                ->generateId(false)
                ->template("{toggle}\n{widget}")
                ->templateContent("\n{header}\n{body}\n")
                ->render(),
        );
    }

    public function testDismisingWithToggleAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="alert alert-dismissible" role="alert">
            Body
            <button type="button" class="btn-close btn-lg" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML,
            Alert::widget()
                ->id('test')
                ->body('Body')
                ->dismissing()
                ->toggleAttributes(['class' => 'btn-lg'])
                ->render(),
        );
    }

    public function testDismisingWithToggleLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-dismissible" role="alert">
            Body
            <a type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
            </div>
            HTML,
            Alert::widget()->body('Body')->dismissing()->toggleLink()->render(),
        );
    }

    public function testFade(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert fade show" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->body('Body')->fade()->generateId(false)->render(),
        );
    }

    public function testHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert" role="alert">
            <h5 class="header-class alert-heading">Alert header</h5>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->generateId(false)
                ->header('Alert header')
                ->headerTag('h5')
                ->headerAttributes(['class' => 'header-class'])
                ->render(),
        );
    }

    public function testHeaderTagException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(ErrorMessage::TAG_NOT_EMPTY_STRING->value);

        Alert::widget()->header('Header')->headerTag('')->render();
    }

    public function testHeaderWithEncodeTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert" role="alert">
            <h5 class="header-class alert-heading">&amp;lt;header&amp;gt;</h5>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->generateId(false)
                ->header('<header>', true)
                ->headerTag('h5')
                ->headerAttributes(['class' => 'header-class'])
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test" class="alert" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->id('test')->body('Body')->render(),
        );
    }

    public function testIdWithNull(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert" role="alert">
            Body
            </div>
            HTML,
            Alert::widget()->id(null)->body('Body')->render(),
        );
    }

    public function testInmutable(): void
    {
        $alert = Alert::widget();

        $this->assertNotSame($alert, $alert->attributes([]));
        $this->assertNotSame($alert, $alert->body(''));
        $this->assertNotSame($alert, $alert->class(''));
        $this->assertNotSame($alert, $alert->dismissing());
        $this->assertNotSame($alert, $alert->fade());
        $this->assertNotSame($alert, $alert->generateId(false));
        $this->assertNotSame($alert, $alert->header(''));
        $this->assertNotSame($alert, $alert->headerAttributes([]));
        $this->assertNotSame($alert, $alert->headerTag('div'));
        $this->assertNotSame($alert, $alert->template(''));
        $this->assertNotSame($alert, $alert->templateContent(''));
        $this->assertNotSame($alert, $alert->toggleAttributes([]));
        $this->assertNotSame($alert, $alert->toggleLink());
        $this->assertNotSame($alert, $alert->type(Type::PRIMARY));
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
                    '<a href="#" class="alert-link">an example link</a>. Give it a click if you like.'
                )
                ->generateId(false)
                ->type(Type::WARNING)
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
            <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
            <div>An example alert with an icon</div>
            </div>
            HTML,
            Alert::widget()
                ->class('alert-warning d-flex align-items-center')
                ->body(
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">' .
                    '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>' .
                    '</svg>' . PHP_EOL .
                    '<div>An example alert with an icon</div>'
                )
                ->generateId(false)
                ->render(),
        );
    }

    public function testTemplateContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="alert alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            Body
            </div>
            HTML,
            Alert::widget()
                ->body('Body')
                ->dismissing()
                ->generateId(false)
                ->templateContent("\n{toggle}\n{body}\n")
                ->render(),
        );
    }

    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\AlertProvider::type()
     */
    public function testType(Type $type, string $expected): void
    {
        Assert::equalsWithoutLE(
            $expected,
            Alert::widget()
                ->body('A simple ' . $type->value . ' alert—check it out!')
                ->generateId(false)
                ->type($type)
                ->render(),
        );
    }
}
