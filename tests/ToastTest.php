<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Toast;

/**
 * Tests for Toast widget.
 *
 * ToastTest
 */
class ToastTest extends TestCase
{
    public function testBodyOptions()
    {
        Toast::counter(0);
        $html = Toast::widget()
            ->bodyOptions(['class' => 'toast-body test', 'style' => ['text-align' => 'center']])
            ->begin();
        $html .= Toast::end();

        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<strong class="me-auto"></strong>
<button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="toast">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="toast-body test" style="text-align: center;">
</div></div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @depends testBodyOptions
     */
    public function testContainerOptions()
    {
        Toast::counter(0);

        $html = Toast::widget()
            ->dateTime('a minute ago')
            ->title('Toast title')
            ->begin();
        $html .= 'Woohoo, you\'re reading this text in a toast!';
        $html .= Toast::end();

        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<strong class="me-auto">Toast title</strong>
<small>a minute ago</small>
<button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="toast">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="toast-body">Woohoo, you're reading this text in a toast!
</div></div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testDateTimeOptions()
    {
        Toast::counter(0);
        $html = Toast::widget()
            ->title('Toast title')
            ->dateTime('a minute ago')
            ->dateTimeOptions([
                'class' => ['toast-date-time'],
                'style' => ['text-align' => 'right'],
            ])
            ->begin();
        $html .= Toast::end();

        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<strong class="me-auto">Toast title</strong>
<small class="toast-date-time" style="text-align: right;">a minute ago</small>
<button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="toast">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="toast-body">
</div></div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTitleOptions()
    {
        Toast::counter(0);
        $html = Toast::widget()
            ->title('Toast title')
            ->titleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->begin();
        $html .= Toast::end();

        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
<h5 class="me-auto" style="text-align: left;">Toast title</h5>
<button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="toast">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="toast-body">
</div></div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }
}
