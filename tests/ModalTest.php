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
<button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
<div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body test" style="text-align:center;">

</div>

</div>
</div>
</div>
HTML;
        $this->assertEqualsHTML($expected, $html);
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
<button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
<div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button></div>
</div>
</div>
</div>
HTML;
        $this->assertEqualsHTML($expected, $html);
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
<div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body">
<p>Woohoo, you're reading this text in a modal!</p>
</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary">Save changes</button></div>
</div>
</div>
</div>
HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithCloseButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->closeButton(['class' => 'btn-lg btn-close'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-lg btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutCloseButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withoutCloseButton()
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithFooterOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->footerOptions(['class' => 'text-dark'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithHeaderOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->headerOptions(['class' => 'text-danger'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="text-danger modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->options(['class' => 'testMe'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="testMe modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithTitle(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->title('My first modal.')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><h5 id="w0-modal-label" class="modal-title">My first modal.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithEmptyTitle(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->title('')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><h5 id="w0-modal-label" class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithTitleOptions(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->title('My first modal.')
            ->titleOptions(['class' => 'text-center'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><h5 id="w0-modal-label" class="text-center modal-title">My first modal.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutTogleButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withoutToggleButton()
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'

        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithSize(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->size(Modal::SIZE_LARGE)
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);

        $html = Modal::widget()
            ->size(Modal::SIZE_SMALL)
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w1-modal">Show</button>
        <div id="w1-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>

        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutAnimation(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->fade(false)
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        <p>Woohoo, you're reading this text in a modal!</p>
        </div>
        </div>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testFullscreen(): void
    {
        $fullscreen = [
            Modal::FULLSCREEN_ALWAYS,
            Modal::FULLSCREEN_BELOW_SM,
            Modal::FULLSCREEN_BELOW_MD,
            Modal::FULLSCREEN_BELOW_LG,
            Modal::FULLSCREEN_BELOW_XL,
            Modal::FULLSCREEN_BELOW_XXL,
        ];

        foreach ($fullscreen as $className) {
            Modal::counter(0);

            $html = Modal::widget()
                ->fullscreen($className)
                ->begin();
            $html .= Modal::end();

            $expected = <<<HTML
            <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
            <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog {$className}">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">
            </div>
            </div>
            </div>
            </div>
            HTML;

            $this->assertEqualsHTML($expected, $html);
        }
    }

    public function testCustomTag(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->contentOptions([
                'tag' => 'form',
                'action' => '/',
            ])
            ->bodyOptions([
                'tag' => 'fieldset',
            ])
            ->headerOptions([
                'tag' => 'header',
            ])
            ->titleOptions([
                'tag' => 'h4',
            ])
            ->footerOptions([
                'tag' => 'footer',
            ])
            ->title('Title')
            ->footer('<button type="submit">Save</button>')
            ->begin();
        $html .= '<input type="text">';
        $html .= Modal::end();

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="w0-modal-label">
        <div class="modal-dialog">
        <form class="modal-content" action="/">
        <header class="modal-header">
        <h4 id="w0-modal-label" class="modal-title">Title</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </header>
        <fieldset class="modal-body">
        <input type="text">
        </fieldset>
        <footer class="modal-footer"><button type="submit">Save</button></footer>
        </form>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testStaticBackdrop(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->staticBackdrop()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        </div>
        </div>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testScrollingLongContent(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->scrollable()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        </div>
        </div>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testVerticallyCentered(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->centered()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body">
        </div>
        </div>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testManyTogglers(): void
    {
        Modal::counter(0);
        $widget = Modal::widget();

        $html = $widget->renderToggleButton();
        $html .= $widget->renderToggleButton(['label' => 'New Label']);
        $html .= $widget->renderToggleButton(['class' => 'btn btn-primary', 'label' => 'New Label 2']);
        $html .= $widget->renderToggleButton(['tag' => 'a']);
        $html .= $widget->renderToggleButton(['tag' => 'a', 'href' => '/']);

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">New Label</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#w0-modal">New Label 2</button>
        <a href="#w0-modal" data-bs-toggle="modal">Show</a>
        <a href="/" data-bs-toggle="modal" data-bs-target="#w0-modal">Show</a>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
