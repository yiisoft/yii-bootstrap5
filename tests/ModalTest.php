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
    protected function setUp(): void
    {
        parent::setUp();

        Modal::counter(0);
    }

    public function testBodyOptions(): void
    {
        $html = Modal::widget()
            ->bodyOptions(['class' => 'modal-body test', 'style' => 'text-align:center;'])
            ->withToggleLabel('Show')
            ->begin();
        $html .= Modal::end();
        $expected = <<<'HTML'
<button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
        $widget = Modal::widget()
            ->withToggleLabel('Show');
        $modal = $widget->footer(
            $widget->withCloseButtonOptions([
                'class' => [
                    'widget' => 'btn',
                    'btn-secondary',
                ],
            ])
            ->withCloseButtonLabel('Close')
            ->renderCloseButton() . "\n" .
            Html::button(
                'Save changes',
                [
                    'type' => 'button',
                    'class' => ['btn', 'btn-primary'],
                ]
            )
        );

        $html = $modal->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
<button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleOptions([
                'class' => ['btn', 'btn-primary'],
            ])
            ->withToggleLabel('Launch demo modal')
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
<button type="button" class="btn btn-primary" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Launch demo modal</button>
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
            ->withCloseButtonOptions(['class' => 'btn-lg'])
            ->withToggleLabel('Show')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->headerOptions(['class' => 'text-danger'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->options(['class' => 'testMe'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->title('My first modal.')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->title('')
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
            ->withToggleLabel('Show')
            ->title('My first modal.')
            ->titleOptions(['class' => 'text-center'])
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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

    public function testWithoutToggleButton(): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withToggle(false)
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

    public static function sizeDataProvider(): array
    {
        return [
            [
                Modal::SIZE_LARGE,
                <<<'HTML'
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
                HTML,
            ],

            [
                Modal::SIZE_SMALL,
                <<<'HTML'
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
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
                HTML,
            ],

            [
                Modal::SIZE_EXTRA_LARGE,
                <<<'HTML'
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                <p>Woohoo, you're reading this text in a modal!</p>
                </div>

                </div>
                </div>
                </div>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider sizeDataProvider
     * @return void
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     */
    public function testWithSize(string $size, string $expected): void
    {
        Modal::counter(0);

        $html = Modal::widget()
            ->withToggleLabel('Show')
            ->size($size)
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();

        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutAnimation(): void
    {
        $html = Modal::widget()
            ->withToggleLabel('Show')
            ->fade(false)
            ->begin();
        $html .= '<p>Woohoo, you\'re reading this text in a modal!</p>';
        $html .= Modal::end();
        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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

    public static function screenSizeDataProvider(): array
    {
        return [
            [
                Modal::FULLSCREEN_ALWAYS,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ],

            [
                Modal::FULLSCREEN_BELOW_SM,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ],

            [
                Modal::FULLSCREEN_BELOW_MD,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-md-down">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ],

            [
                Modal::FULLSCREEN_BELOW_LG,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-lg-down">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ],

            [
                Modal::FULLSCREEN_BELOW_XL,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-xl-down">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ],

            [
                Modal::FULLSCREEN_BELOW_XXL,
                <<<HTML
                <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
                <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-xxl-down">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                </div>
                </div>
                </div>
                </div>
                HTML,
            ]
        ];
    }

    /**
     * @dataProvider screenSizeDataProvider
     * @param string $size
     * @param string $exprected
     * @return void
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     */
    public function testFullscreen(string $size, string $expected): void
    {
        $html = Modal::widget()
            ->withToggleLabel('Show')
            ->fullscreen($size)
            ->begin();
        $html .= Modal::end();


        $this->assertEqualsHTML($expected, $html);
    }

    public function testCustomTag(): void
    {
        $html = Modal::widget()
            ->withToggleLabel('Show')
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
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
        $html = Modal::widget()
            ->staticBackdrop()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
        $html = Modal::widget()
            ->scrollable()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
        $html = Modal::widget()
            ->centered()
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
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
        $widget = Modal::widget();

        $html = $widget->renderToggle();
        $html .= $widget->withToggleLabel('New Label')
            ->renderToggle();
        $html .= $widget->withToggleLabel('New Label 2')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->renderToggle();
        $html .= $widget->withToggleOptions([
            'tag' => 'a',
        ])
        ->renderToggle();
        $html .= $widget->withToggleOptions([
            'tag' => 'a',
            'href' => '/',
        ])
        ->renderToggle();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">New Label</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">New Label 2</button>
        <a href="#w0-modal" data-bs-toggle="modal" aria-controls="w0-modal" role="button">Show</a>
        <a href="/" data-bs-toggle="modal" aria-controls="w0-modal" role="button" data-bs-target="#w0-modal">Show</a>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testDialogOptions(): void
    {
        $html = Modal::widget()
            ->centered()
            ->dialogOptions([
                'class' => 'bg-white',
            ])
            ->begin();
        $html .= Modal::end();

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" aria-controls="w0-modal" data-bs-target="#w0-modal">Show</button>
        <div id="w0-modal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="bg-white modal-dialog modal-dialog-centered">
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
