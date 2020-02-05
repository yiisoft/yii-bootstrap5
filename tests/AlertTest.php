<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Alert;

/**
 * Tests for Alert widget
 *
 * AlertTest.
 */
final class AlertTest extends TestCase
{
    public function testNormalAlert(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Alert::counter(0);

        echo Alert::widget()
            ->body('<strong>Holy guacamole!</strong> You should check in on some of those fields below.')
            ->options([
                'class' => ['alert-warning']
            ]);

        $expectedHtml = <<<HTML
<div id="w0-alert" class="alert-warning alert alert-dismissible" role="alert">

<strong>Holy guacamole!</strong> You should check in on some of those fields below.
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>

</div>
HTML;

        $this->assertEqualsWithoutLE($expectedHtml, ob_get_clean());
    }

    /**
     * @depends testNormalAlert
     */
    public function testDismissibleAlert(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Alert::counter(0);

        echo Alert::widget()
            ->body("Message1");

        $expectedHtml = <<<HTML
<div id="w0-alert" class="alert alert-dismissible" role="alert">

Message1
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>

</div>
HTML;

        $this->assertEqualsWithoutLE($expectedHtml, ob_get_clean());
    }
}
