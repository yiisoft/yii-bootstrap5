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
            ->closeButtonEnabled(false)
            ->toggleButtonEnabled(false)
            ->begin();

        $html .= Modal::end();

        $expected = <<<HTML

<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog ">
<div class="modal-content">

<div class="modal-body test" style="text-align:center;">

</div>

</div>
</div>
</div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testContainerOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->title('Modal title')
            ->toggleButtonEnabled(false)
            ->footer(
                Html::button('Close', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-secondary'],
                    'data' => [
                        'dismiss' => 'modal',
                    ],
                ]) . "\n" .
                Html::button('Save changes', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-primary'],
                ])
            )
            ->begin();

        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';

        $html .= Modal::end();

        $expected = <<<HTML

<div id="w0-modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<h5 id="w0-modal-label" class="modal-title">Modal title</h5>
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button>
</div>
</div>
</div>
</div>
HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTriggerButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->toggleButton([
                'class' => ['btn', 'btn-primary'],
                'label' => 'Launch demo modal',
            ])
            ->title('Modal title')
            ->footer(
                Html::button('Close', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-secondary'],
                ]) . "\n" .
                Html::button('Save changes', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-primary'],
                ])
            )
            ->begin();

        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';

        $html .= Modal::end();

        $this->assertStringContainsString(
            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#w0-modal">Launch demo modal</button>',
            $html
        );
    }
}
