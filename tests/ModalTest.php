<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Modal;

/**
 * Tests for Modal widget.
 *
 * ModalTest.
 */
final class ModalTest extends TestCase
{
    public function testBodyOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->WithBodyOptions(['class' => 'modal-body test', 'style' => 'text-align:center;'])
            ->begin();
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body test" style="text-align:center;">

</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFooter(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withFooter(
                Html::button(
                    'Close',
                    [
                        'type' => 'button',
                        'class' => ['btn', 'btn-secondary'],
                        'data' => [
                            'bs-dismiss' => 'modal',
                        ],
                    ]
                ) . "\n" .
                Html::button(
                    'Save changes',
                    [
                        'type' => 'button',
                        'class' => ['btn', 'btn-primary'],
                    ]
                )
            )
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button></div>
</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testToogleButtom(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withToggleButton([
                'class' => ['btn', 'btn-primary'],
                'label' => 'Launch demo modal',
            ])
            ->withFooter(
                Html::button(
                    'Close',
                    [
                        'type' => 'button',
                        'class' => ['btn', 'btn-secondary'],
                        'data' => [
                            'bs-dismiss' => 'modal',
                        ],
                    ]
                ) . "\n" .
                Html::button(
                    'Save changes',
                    [
                        'type' => 'button',
                        'class' => ['btn', 'btn-primary'],
                    ]
                )
            )
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#w0-modal">Launch demo modal</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button></div>
</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithCloseButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withCloseButton(['class' => 'btn-lg'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-lg close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutCloseButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withoutCloseButton()->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">

<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithFooterOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withFooterOptions(['class' => 'text-dark'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithHeaderOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withHeaderOptions(['class' => 'text-danger'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="text-danger modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withOptions(['class' => 'testMe'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="testMe modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithTitle(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withTitle('My first modal.')->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header"><h5 id="w0-modal-label" class="modal-title">My first modal.</h5>
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithTitleOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withTitle('My first modal.')->withTitleOptions(['class' => 'text-center'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header"><h5 id="w0-modal-label" class="text-center modal-title">My first modal.</h5>
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutTogleButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withoutToggleButton()->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML

<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithSize(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withSize(Modal::SIZE_LARGE)->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        Modal::counter(0);

        $html = Modal::widget()->withSize(Modal::SIZE_SMALL)->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">&amp;times;</span></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeTags(): void
    {
        Modal::counter(0);

        $html = Modal::widget()->withEncodeTags()->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<HTML
<button>Show</button>
<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
&lt;button type="button" class="close" data-bs-dismiss="modal"&gt;&amp;lt;span aria-hidden="true"&amp;gt;&amp;amp;amp;times;&amp;lt;/span&amp;gt;&lt;/button&gt;</div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
