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
    public function testNormalAlert(): void
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
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @depends testNormalAlert
     */
    public function testDismissibleAlert(): void
    {
        Alert::counter(0);

        $html = Alert::widget()->body('Message1')->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">Message1
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCloseButtonDisable(): void
    {
        Alert::counter(0);

        $html = Alert::widget()->body('Message1')->withoutCloseButton()->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert" role="alert">Message1

        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCloseButtonOptions(): void
    {
        Alert::counter(0);

        $html = Alert::widget()->body('Message1')->closeButton(['class' => 'btn-lg'])->render();
        $expected = <<<'HTML'
        <div id="w0-alert" class="alert alert-dismissible" role="alert">Message1
        <button type="button" class="btn-lg btn-close" aria-label="Close" data-bs-dismiss="alert"></button>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
