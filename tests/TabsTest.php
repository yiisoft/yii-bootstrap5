<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\NavItem;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\NavTabs;
use Yiisoft\Yii\Bootstrap5\TabPane;

final class TabsTest extends TestCase
{
    public function testTabsWoPanes(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->links(
                    NavLink::widget()->id('tab-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('tab-2')->label('Link 2')->url('/link-2'),
                    NavLink::widget()->id('tab-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a id="tab-1" class="nav-link active" href="/link-1" aria-current="page">Link 1</a></li>
        <li class="nav-item"><a id="tab-2" class="nav-link" href="/link-2">Link 2</a></li>
        <li class="nav-item"><a id="tab-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        <div class="tab-content"></div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testSimpleTabs(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testActive(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testRenderContent(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testFade(): void
    {
        $pane = TabPane::widget()->fade(true);

        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            $pane->id('pane-1')
                                 ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            $pane->id('pane-2')
                                 ->content(Html::div('Pane 2'))
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="tab-pane fade active show" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane fade" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testPaneOptions(): void
    {
        $pane = TabPane::widget()->fade(true)
                ->options([
                    'class' => 'custom-pane-class',
                ]);

        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            $pane->id('pane-1')
                                 ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                                ->options([
                                    'style' => 'margin: -1px',
                                ])
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="custom-pane-class tab-pane fade active show" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" style="margin: -1px" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testContentOptions(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->tabContentOptions([
                    'class' => 'custom-content-class',
                ])
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                    NavLink::widget()
                        ->label('Link 3')
                        ->id('tab-3')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-3')
                                ->content('<span>Pane 3</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-3" class="nav-link" href="#pane-3" data-bs-toggle="tab" role="tab" aria-controls="pane-3" aria-selected="false">Link 3</a>
        </li>
        </ul>
        <div class="custom-content-class tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        <div id="pane-3" class="tab-pane" tabindex="0" aria-labelledby="tab-3" role="tabpanel">&lt;span&gt;Pane 3&lt;/span&gt;</div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPaneEncode(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPaneTag(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->tag('section')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->tag('article')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <section id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</section>
        <article id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></article>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPills(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->pills()
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-pills" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="pill" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="pill" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testMultipleItems(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->tag('nav')
                ->defaultItem(false)
                ->links(
                    NavLink::widget()
                           ->label('Link 1')
                           ->id('tab-1')
                           ->pane(
                               TabPane::widget()
                                   ->id('pane-1')
                                   ->encode(true)
                                   ->content('<span>Encoded content</span>')
                           )
                           ->item(
                               NavItem::widget()->tag('div')
                           ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        )
                );

        $expected = <<<'HTML'
        <nav id="test-tabs" class="nav nav-tabs" role="tablist">
        <div class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </div>
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </nav>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testWoActive(): void
    {
        $tabs = NavTabs::widget()
                ->id('test-tabs')
                ->activeItem(null)
                ->links(
                    NavLink::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    NavLink::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="false">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }
}
