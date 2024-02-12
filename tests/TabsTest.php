<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Tabs;

/**
 * Tests for `Tabs` widget.
 */
final class TabsTest extends TestCase
{
    public function testRoleTabList(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'Page2',
                    'content' => 'Page2',
                ],
            ])
            ->render();
        $this->assertStringContainsString('<ul id="test" class="nav nav-tabs" role="tablist">', $html);
    }

    /**
     * Each tab should have a corresponding unique ID
     *
     * {@see https://github.com/yiisoft/yii2/issues/6150}
     */
    public function testIds(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'Page3', 'content' => 'Page3'],
                    ],
                ],
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page4', 'content' => 'Page4'],
                        ['label' => 'Page5', 'content' => 'Page5'],
                    ],
                ],
                [
                    'label' => $extAnchor1 = 'External link',
                    'url' => $extUrl1 = '//other/route',
                ],
                [
                    'label' => 'Dropdown3',
                    'items' => [
                        [
                            'label' => $extAnchor2 = 'External Dropdown Link',
                            'url' => $extUrl2 = '//other/dropdown/route',
                        ],
                    ],
                ],
            ])
            ->render();

        $page1 = 'test-tab0';
        $page2 = 'test-dd1-tab0';
        $page3 = 'test-dd1-tab1';
        $page4 = 'test-dd2-tab0';
        $page5 = 'test-dd2-tab1';

        $shouldContain = [
            'id="test"', // nav widget container
            "#$page1", // Page1

            'Dropdown1', // Dropdown1
            "$page2", // Page2
            "$page3", // Page3


            'Dropdown2', // Dropdown2
            "#$page4", // Page4
            "#$page5", // Page5

            'Dropdown3', // Dropdown3

            // containers
            "id=\"$page1\"",
            "id=\"$page2\"",
            "id=\"$page3\"",
            "id=\"$page4\"",
            "id=\"$page5\"",
            Html::a($extAnchor1, $extUrl1, ['class' => 'nav-link'])->render(),
            Html::a($extAnchor2, $extUrl2, [/*'tabindex' => -1, */
                'class' => 'dropdown-item',
            ])->render(),
        ];

        foreach ($shouldContain as $string) {
            $this->assertStringContainsString($string, $html);
        }
    }

    public function testVisible(): void
    {
        $html = Tabs::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'InvisiblePage',
                    'content' => 'Invisible Page Content',
                    'visible' => false,
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'InvisibleItem', 'content' => 'Invisible Item Content', 'visible' => false],
                        ['label' => 'Page3', 'content' => 'Page3'],
                        ['label' => 'External Link', 'url' => '//other/dropdown/route'],
                        ['label' => 'Invisible External Link', 'url' => '//other/dropdown/route', 'visible' => false],
                    ],
                ],
            ])
            ->render();
        $this->assertStringNotContainsString('InvisiblePage', $html);
        $this->assertStringNotContainsString('Invisible Page Content', $html);
        $this->assertStringNotContainsString('InvisibleItem', $html);
        $this->assertStringNotContainsString('Invisible Item Content', $html);
        $this->assertStringNotContainsString('Invisible External Link', $html);
    }

    public function testDisabled(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                    'disabled' => true,
                ],
                [
                    'label' => 'Page2',
                    'content' => 'Page2',
                ],
                [
                    'label' => 'DisabledPage',
                    'content' => 'Disabled Page Content',
                    'disabled' => true,
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2'],
                        ['label' => 'DisabledItem', 'content' => 'Disabled Item Content', 'disabled' => true],
                        ['label' => 'Page3', 'content' => 'Page3'],
                        ['label' => 'External Link', 'url' => '/other/dropdown/route'],
                        ['label' => 'Disabled External Link', 'url' => '/other/dropdown/route', 'disabled' => true],
                    ],
                ],
            ])
            ->render();
        $this->assertStringContainsString(
            '<li class="nav-item"><a class="nav-link disabled" href="#test-tab0" data-bs-toggle="tab" role="tab" aria-controls="test-tab0" tabindex="-1" aria-disabled="true">Page1</a></li>',
            $html
        );
        $this->assertStringContainsString(
            '<li class="nav-item"><a class="nav-link active" href="#test-tab1" data-bs-toggle="tab" role="tab" aria-controls="test-tab1" aria-selected="true">Page2</a></li>',
            $html
        );
        $this->assertStringContainsString(
            '<li class="nav-item"><a class="nav-link disabled" href="#test-tab2" data-bs-toggle="tab" role="tab" aria-controls="test-tab2" tabindex="-1" aria-disabled="true">DisabledPage</a></li>',
            $html
        );
        $this->assertStringContainsString(
            '<a class="dropdown-item disabled" href="#test-dd3-tab1" data-bs-toggle="tab" role="tab" aria-controls="test-dd3-tab1" tabindex="-1" aria-disabled="true">DisabledItem</a>',
            $html
        );
        $this->assertStringContainsString(
            '<a class="dropdown-item disabled" href="/other/dropdown/route" tabindex="-1" aria-disabled="true">Disabled External Link</a>',
            $html
        );
    }

    public function testItem(): void
    {
        $checkTag = 'article';

        $html = Tabs::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
                [
                    'label' => 'Page2',
                    'content' => 'Page2',
                ],
            ])
            ->itemOptions(['tag' => $checkTag])
            ->withoutRenderTabContent()
            ->render();
        $this->assertStringNotContainsString('<' . $checkTag, $html);
    }

    public function testTabContentOptions(): void
    {
        $checkAttribute = 'test_attribute';
        $checkValue = 'check_attribute';

        $html = Tabs::widget()
            ->items([
                [
                    'label' => 'Page1',
                    'content' => 'Page1',
                ],
            ])
            ->tabContentOptions([
                $checkAttribute => $checkValue,
            ])
            ->render();
        $this->assertStringContainsString($checkAttribute . '=', $html);
        $this->assertStringContainsString($checkValue, $html);
    }

    public function testActivateFirstVisibleTab(): void
    {
        $html = Tabs::widget()
            ->items([
                [
                    'label' => 'Tab 1',
                    'content' => 'some content',
                    'visible' => false,
                ],
                [
                    'label' => 'Tab 2',
                    'content' => 'some content',
                    'disabled' => true,
                ],
                [
                    'label' => 'Tab 3',
                    'content' => 'some content',
                ],
                [
                    'label' => 'Tab 4',
                    'content' => 'some content',
                ],
            ])
            ->options(['id' => 'mytab'])
            ->render();
        $this-> assertStringNotContainsString(
            '<li class="nav-item"><a class="nav-link active" href="#mytab-tab0" data-bs-toggle="tab" role="tab" aria-controls="mytab-tab0" aria-selected="true">Tab 1</a></li>',
            $html
        );
        $this-> assertStringNotContainsString(
            '<li class="nav-item"><a class="nav-link active" href="#mytab-tab1" data-bs-toggle="tab" role="tab" aria-controls="mytab-tab1" aria-selected="true">Tab 2</a></li>',
            $html
        );
        $this->assertStringContainsString(
            '<li class="nav-item"><a class="nav-link active" href="#mytab-tab2" data-bs-toggle="tab" role="tab" aria-controls="mytab-tab2" aria-selected="true">Tab 3</a></li>',
            $html
        );
    }

    public function testActivateTab(): void
    {
        $html = Tabs::widget()
            ->items([
                [
                    'label' => 'Tab 1',
                    'content' => 'some content',
                    'visible' => false,
                ],
                [
                    'label' => 'Tab 2',
                    'content' => 'some content',
                ],
                [
                    'label' => 'Tab 3',
                    'content' => 'some content',
                    'active' => true,
                ],
                [
                    'label' => 'Tab 4',
                    'content' => 'some content',
                ],
            ])
            ->options(['id' => 'mytab'])
            ->render();
        $this->assertStringContainsString(
            '<li class="nav-item"><a class="nav-link active" href="#mytab-tab2" data-bs-toggle="tab" role="tab" aria-controls="mytab-tab2" aria-selected="true">Tab 3</a></li>',
            $html
        );
    }

    public function testTabLabelEncoding(): void
    {
        $html = Tabs::widget()
            ->withoutEncodeLabels()
            ->id('mytab')
            ->items([
                [
                    'label' => 'Tab 1<span>encoded</span>',
                    'content' => 'some content',
                    'encode' => true,
                ],
                [
                    'label' => 'Tab 2<span>not encoded</span>',
                    'content' => 'some content',
                ],
                [
                    'label' => 'Tab 3<span>not encoded too</span>',
                    'content' => 'some content',
                ],
            ])
            ->render();
        $this->assertStringContainsString('&lt;span&gt;encoded&lt;/span&gt;', $html);
        $this->assertStringContainsString('<span>not encoded</span>', $html);
        $this->assertStringContainsString('<span>not encoded too</span>', $html);
    }

    /**
     * {@see https://github.com/yiisoft/yii2-bootstrap4/issues/108#issuecomment-465219339}
     */
    public function testIdRendering(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([
                [
                    'paneOptions' => ['id' => 'pane1'],
                    'label' => 'Tab 1',
                    'content' => '<div>Content 1</div>',
                ],
                [
                    'label' => 'Tab 2',
                    'content' => '<div>Content 2</div>',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-tabs" role="tablist"><li class="nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li>
        <li class="nav-item"><a class="nav-link" href="#test-tab1" data-bs-toggle="tab" role="tab" aria-controls="test-tab1" aria-selected="false">Tab 2</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div>
        <div id="test-tab1" class="tab-pane"><div>Content 2</div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testDropdownClass(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items(
                [
                    [
                        'paneOptions' => ['id' => 'pane1'],
                        'label' => 'Tab 1',
                        'content' => '<div>Content 1</div>',
                    ],
                ],
            )
            ->dropdownClass(Dropdown::class)
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-tabs" role="tablist"><li class="nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testHeaderOptions(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items(
                [
                    [
                        'paneOptions' => ['id' => 'pane1'],
                        'label' => 'Tab 1',
                        'content' => '<div>Content 1</div>',
                    ],
                ],
            )
            ->itemOptions(['class' => 'text-center'])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-tabs" role="tablist"><li class="text-center nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testPanes(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->panes(['content' => '<div>Content 1</div>'])
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-tabs" role="tablist"></ul>
        <div class="tab-content"><div>Content 1</div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(RuntimeException::class);
        Tabs::widget()
            ->items([['content' => '<div>Content 1</div>']])
            ->render();
    }

    public function testNavType(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([['paneOptions' => ['id' => 'pane1'], 'label' => 'Tab 1', 'content' => '<div>Content 1</div>']])
            ->navType('nav-lg')
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-lg" role="tablist"><li class="nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testPaneOptions(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([['paneOptions' => ['id' => 'pane1'], 'label' => 'Tab 1', 'content' => '<div>Content 1</div>']])
            ->navType('nav-lg')
            ->paneOptions([
                'tag' => 'article',
                'class' => 'custom-class',
            ])
            ->render();

        $expected = <<<'HTML'
        <ul id="test" class="nav nav-lg" role="tablist"><li class="nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><article id="pane1" class="custom-class tab-pane active"><div>Content 1</div></article></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testNavOption(): void
    {
        $html = Tabs::widget()
            ->id('test')
            ->items([['paneOptions' => ['id' => 'pane1'], 'label' => 'Tab 1', 'content' => '<div>Content 1</div>']])
            ->navType('nav-lg')
            ->linkOptions([
                'class' => 'custom-link-class',
            ])
            ->render();

        $expected = <<<'HTML'
        <ul id="test" class="nav nav-lg" role="tablist"><li class="nav-item"><a class="custom-link-class nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;
        $this->assertSame($expected, $html);

        $html = Tabs::widget()
            ->id('test')
            ->items([['paneOptions' => ['id' => 'pane1'], 'label' => 'Tab 1', 'content' => '<div>Content 1</div>']])
            ->navType('nav-lg')
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <ul id="test" class="nav nav-lg" role="tablist"><li class="nav-item"><a class="nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testNavOptions(): void
    {
        $widget = Tabs::widget()
            ->id('test')
            ->items([['paneOptions' => ['id' => 'pane1'], 'label' => 'Tab 1', 'content' => '<div>Content 1</div>']])
            ->navType('nav-lg')
            ->navDefinitions([
                'linkOptions' => [
                    'class' => 'custom-link-class',
                ],
                'itemOptions' => [
                    'class' => 'custom-item-class',
                ],
            ]);

        $expected = <<<'HTML'
        <ul id="test" class="nav nav-lg" role="tablist"><li class="custom-item-class nav-item"><a class="custom-link-class nav-link active" href="#pane1" data-bs-toggle="tab" role="tab" aria-controls="pane1" aria-selected="true">Tab 1</a></li></ul>
        <div class="tab-content"><div id="pane1" class="tab-pane active"><div>Content 1</div></div></div>
        HTML;

        $this->assertSame($expected, $widget->render());
    }
}
