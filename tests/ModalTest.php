<?php

declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\Bootstrap4\Modal;

/**
 * Tests for Modal widget.
 *
 * ModalTest.
 */
class ModalTest extends TestCase
{
    public function testBodyOptions(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Modal::counter(0);

        Modal::begin()
            ->bodyOptions(['class' => 'modal-body test', 'style' => 'text-align:center;'])
            ->closeButtonEnabled(false)
            ->toggleButtonEnabled(false)
            ->start();

        echo Modal::end();

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

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    public function testContainerOptions(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Modal::counter(0);

        Modal::begin()
            ->title('Modal title')
            ->toggleButtonEnabled(false)
            ->footer(
                Html::button('Close', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-secondary'],
                    'data' => [
                        'dismiss' => 'modal'
                    ]
                ]) . "\n" .
                Html::button('Save changes', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-primary']
                ])
            )
            ->start();

        echo '<p>Woohoo, you\'re reading this text in a modal!</p>';

        echo Modal::end();

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

        $this->assertEqualsWithoutLE($expected, ob_get_clean());
    }

    public function testTriggerButton(): void
    {
        ob_start();
        ob_implicit_flush(0);

        Modal::counter(0);

        Modal::begin()
            ->toggleButton([
                'class' => ['btn', 'btn-primary'],
                'label' => 'Launch demo modal'
            ])
            ->title('Modal title')
            ->footer(
                Html::button('Close', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-secondary']
                ]) . "\n" .
                Html::button('Save changes', [
                    'type' => 'button',
                    'class' => ['btn', 'btn-primary']
                ])
            )
            ->start();

        echo '<p>Woohoo, you\'re reading this text in a modal!</p>';

        echo Modal::end();

        $this->assertStringContainsString(
            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#w0-modal">Launch demo modal</button>',
            ob_get_clean()
        );
    }
}
