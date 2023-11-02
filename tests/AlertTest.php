<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * Tests for Alert widget
 *
 * AlertTest.
 */
final class AlertTest extends TestCase
{
    public function typeDataProvider(): array
    {
        return [
            [
                'primary',
                '<div id="w0-alert" class="alert alert-primary" role="alert">primary</div>',
            ],
            [
                'secondary',
                '<div id="w0-alert" class="alert alert-secondary" role="alert">secondary</div>',
            ],
            [
                'success',
                '<div id="w0-alert" class="alert alert-success" role="alert">success</div>',
            ],
            [
                'danger',
                '<div id="w0-alert" class="alert alert-danger" role="alert">danger</div>',
            ],
            [
                'warning',
                '<div id="w0-alert" class="alert alert-warning" role="alert">warning</div>',
            ],
            [
                'info',
                '<div id="w0-alert" class="alert alert-info" role="alert">info</div>',
            ],
            [
                'light',
                '<div id="w0-alert" class="alert alert-light" role="alert">light</div>',
            ],
            [
                'dark',
                '<div id="w0-alert" class="alert alert-dark" role="alert">dark</div>',
            ],
            [
                'custom',
                '<div id="w0-alert" class="alert custom" role="alert">custom</div>',
            ],
        ];
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#examples
     */
    public function testRender(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->options([
                'class' => ['alert-warning'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert-warning alert alert-dismissible" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#link-color
     */
    public function testRenderLink(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.')
            ->options([
                'class' => ['alert-warning'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert-warning alert alert-dismissible" role="alert">A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#icons
     */
    public function testRenderIcon(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body(
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">' .
                '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>' .
                '</svg>' .
                '<div>An example alert with an icon</div>'
            )
            ->options([
                'class' => ['alert-warning d-flex align-items-center'],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert-warning d-flex align-items-center alert alert-dismissible" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>An example alert with an icon</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/alerts/#dismissing
     */
    public function testDismissing(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">Message1
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testDismissingDisable(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->withoutCloseButton()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert" role="alert">Message1

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testCloseButtonOptions(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->withCloseButtonOptions(['class' => 'btn-lg'])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">Message1
        <button type="button" class="btn-lg btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);

        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->withCloseButtonOptions([
                'tag' => 'a',
                'href' => '/',
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">Message1
        <a class="btn-close" href="/" data-bs-dismiss="alert" aria-label="Close" role="button"></a>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testFade(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->fade()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible fade show" role="alert">Message1
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @dataProvider typeDataProvider
     */
    public function testTypes(string $type, string $expected): void
    {
        Alert::counter(0);

        if ($type === 'custom') {
            $alert = Alert::widget()->addClassNames($type);
        } else {
            $alert = Alert::widget()->{$type}();
        }

        $html = $alert
            ->body($type)
            ->withoutCloseButton()
            ->render();

        $this->assertEqualsHTML($expected, $html);
    }

    public function testHeader(): void
    {
        Alert::counter(0);

        $html = Alert::widget()
            ->body('Message1')
            ->header('Alert header')
            ->headerTag('h5')
            ->headerOptions([
                'class' => 'header-class',
            ])
            ->fade()
            ->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible fade show" role="alert">
        <h5 class="header-class alert-heading">Alert header</h5>
        Message1
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOutsideCloseButton(): void
    {
        Alert::counter(0);

        $widget = Alert::widget()
            ->withCloseButton()
            ->body('Message1');

        $html = $widget->render();
        $html .= $widget->renderCloseButton();

        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">
        Message1
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#w0-alert" aria-label="Close"></button>
        HTML;

        $this->assertEqualsHTML($expected, $html);

        Alert::counter(0);

        $widget = Alert::widget()
            ->withoutCloseButton()
            ->body('Message2');

        $html = $widget->render();
        $html .= $widget->renderCloseButton();

        $expected = <<<'HTML'
        <div id="w0-alert" class="alert" role="alert">
        Message2
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#w0-alert" aria-label="Close"></button>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
