<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Toast;

/**
 * Tests for Toast widget.
 *
 * ToastTest
 */
final class ToastTest extends TestCase
{
    public function testBodyOptions(): void
    {
        Toast::counter(0);

        $html = Toast::widget()
            ->bodyOptions(['class' => 'toast-body test', 'style' => ['text-align' => 'center']])
            ->begin();
        $html .= Toast::end();
        $expected = <<<'HTML'
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
    public function testContainerOptions(): void
    {
        Toast::counter(0);

        $html = Toast::widget()->dateTime('a minute ago')->title('Toast title')->begin();
        $html .= 'Woohoo, you\'re reading this text in a toast!';
        $html .= Toast::end();
        $expected = <<<'HTML'
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

    public function testDateTimeOptions(): void
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
        $expected = <<<'HTML'
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

    public function testTitleOptions(): void
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
        $expected = <<<'HTML'
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
            ->closeButton(['class' => 'btn-lg'])
            ->title('Toast title')
            ->headerOptions(['class' => 'text-dark'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<'HTML'
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
            ->title('Toast title')
            ->titleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->headerOptions(['class' => 'text-dark'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<'HTML'
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
            ->title('Toast title')
            ->titleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->options(['class' => 'text-danger'])
            ->begin();
        $html .= Toast::end();
        $expected = <<<'HTML'
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

        $html = Toast::widget()
            ->autoIdPrefix('toast')
            ->title('Toast title')
            ->titleOptions([
                'tag' => 'h5',
                'style' => ['text-align' => 'left'],
            ])
            ->encodeTags()
            ->begin();
        $html .= Toast::end();
        $expected = <<<'HTML'
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
    }
}
