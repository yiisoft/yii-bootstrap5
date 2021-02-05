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
            ->withBodyOptions(['class' => 'toast-body test', 'style' => ['text-align' => 'center']])
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
            ->withDateTime('a minute ago')
            ->withTitle('Toast title')
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
            ->withTitle('Toast title')
            ->withDateTime('a minute ago')
            ->withDateTimeOptions([
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
            ->withTitle('Toast title')
            ->withTitleOptions([
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

    public function testCloseButton(): void
    {
        Toast::counter(0);

        $html = Toast::widget()
            ->withCloseButton(['class' => 'btn-lg'])
            ->withTitle('Toast title')
            ->withHeaderOptions(['class' => 'text-dark'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="text-dark toast-header">
<strong class="me-auto">Toast title</strong>
<button type="button" class="btn-lg" aria-label="Close" data-bs-dismiss="toast">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="toast-body">
</div></div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHeaderOptions(): void
    {
        Toast::counter(0);

        $html = Toast::widget()
            ->withTitle('Toast title')
            ->withTitleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->withHeaderOptions(['class' => 'text-dark'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<HTML
<div id="w0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="text-dark toast-header">
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

    public function testOptions(): void
    {
        Toast::counter(0);

        $html = Toast::widget()
            ->withTitle('Toast title')
            ->withTitleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->withOptions(['class' => 'text-danger'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<HTML
<div id="w0-toast" class="text-danger toast" role="alert" aria-live="assertive" aria-atomic="true">
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

    public function testEncodeTags(): void
    {
        Toast::counter(0);
        Toast::autoIdPrefix('toast');

        $html = Toast::widget()
            ->withTitle('Toast title')
            ->withTitleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->withEncodeTags()
            ->begin();
        $html .= Toast::end();
        $expected = <<<HTML
<div id="toast0-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<div class="toast-header">
&lt;h5 class="me-auto" style="text-align: left;"&gt;Toast title&lt;/h5&gt;
&lt;button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="toast"&gt;
&amp;lt;span aria-hidden="true"&amp;gt;&amp;amp;times;&amp;lt;/span&amp;gt;
&lt;/button&gt;
</div>
<div class="toast-body">
</div></div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        Toast::autoIdPrefix('w');
    }
}
