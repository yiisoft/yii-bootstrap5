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
            ->bodyOptions(['class' => 'modal-body test', 'style' => 'text-align:center;'])
            ->begin();
        $html .= Modal::end();
        $expected = <<<'HTML'
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
            ->footer(
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
        $expected = <<<'HTML'
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
            ->toggleButton([
                'class' => ['btn', 'btn-primary'],
                'label' => 'Launch demo modal',
            ])
            ->footer(
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
        $expected = <<<'HTML'
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

        $html = Modal::widget()->closeButton(['class' => 'btn-lg'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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
        $expected = <<<'HTML'
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

        $html = Modal::widget()->footerOptions(['class' => 'text-dark'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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

        $html = Modal::widget()->headerOptions(['class' => 'text-danger'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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

        $html = Modal::widget()->options(['class' => 'testMe'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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

        $html = Modal::widget()->title('My first modal.')->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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

        $html = Modal::widget()->title('My first modal.')->titleOptions(['class' => 'text-center'])->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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
        $expected = <<<'HTML'

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

        $html = Modal::widget()->size(Modal::SIZE_LARGE)->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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

        $html = Modal::widget()->size(Modal::SIZE_SMALL)->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button>Show</button>
        <div id="w1-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
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

        $html = Modal::widget()->encodeTags()->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
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
