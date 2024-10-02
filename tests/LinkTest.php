<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;
use Yiisoft\Yii\Bootstrap5\TabPane;

use function array_map;

final class LinkTest extends TestCase
{
    public function testSimpleLink(): void
    {
        $link = Link::widget()
            ->id('test-link')
            ->url('#')
            ->label('Simple nav link');

        $expected = <<<'HTML'
        <a id="test-link" href="#">Simple nav link</a>
        HTML;

        $this->assertSame($expected, (string)$link);
    }

    public static function tagDataProvider(): array
    {
        return [
            ['button'],
            ['span'],
            ['div'],
        ];
    }

    /**
     * @dataProvider tagDataProvider
     */
    public function testTagLink(string $tag): void
    {
        $link = Link::widget()
            ->id('test-link')
            ->tag($tag)
            ->label('Label ' . $tag);

        if ($tag === 'button') {
            $expected = <<<'HTML'
            <button type="button" id="test-link">Label button</button>
            HTML;
        } else {
            $expected = <<<HTML
            <{$tag} id="test-link">Label {$tag}</{$tag}>
            HTML;
        }

        $this->assertSame($expected, (string)$link);
    }

    /**
     * @dataProvider tagDataProvider
     */
    public function testActiveLink(string $tag): void
    {
        $link = Link::widget()
            ->tag($tag)
            ->label('')
            ->active(true)
            ->render();

        $this->assertStringContainsString('class="active"', $link);

        if ($tag === 'a') {
            $this->assertStringContainsString('aria-current="page"', $link);
        } else {
            $this->assertStringNotContainsString('aria-current="page"', $link);
        }
    }

    public static function disabledDataProvider(): array
    {
        return [
            ['button', 'disabled'],
            ['a', 'class="disabled"'],
            ['span', 'class="disabled"'],
        ];
    }

    /**
     * @dataProvider disabledDataProvider
     */
    public function testDisabledLink(string $tag, string $expected): void
    {
        $link = Link::widget()
            ->tag($tag)
            ->label('')
            ->disabled(true)
            ->render();

        $this->assertStringContainsString($expected, $link);

        if ($tag === 'a') {
            $this->assertStringContainsString('aria-disabled="true"', $link);
        } else {
            $this->assertStringNotContainsString('aria-disabled="true"', $link);
        }
    }

    public static function urlDataProvider(): array
    {
        return [
            ['/foo'],
            ['/bar'],
            ['/foo?bar=1'],
        ];
    }

    /**
     * @dataProvider urlDataProvider
     */
    public function testUrl(string $url): void
    {
        $urlLink = Link::widget()
            ->label('')
            ->url($url);

        $hrefLink = Link::widget()
            ->label('')
            ->options([
                'href' => $url,
            ]);

        $this->assertSame($url, $urlLink->getUrl());
        $this->assertSame($url, $hrefLink->getUrl());
    }

    public static function optionsDataProvider(): array
    {
        return [
            [
                [
                    'class' => 'custom-class',
                    'style' => [
                        'margin' => '-1px',
                    ],
                ],

                [
                    'class="custom-class"',
                    'style="margin: -1px;"',
                ],
            ],
        ];
    }

    /**
     * @dataProvider optionsDataProvider
     */
    public function testOptions(array $options, array $expected): void
    {
        $link = Link::widget()
            ->label('')
            ->options($options);

        foreach ($expected as $option) {
            $this->assertStringContainsString($option, (string)$link);
        }
    }

    public static function activeOptionsDataProvider(): array
    {
        return [
            [
                [
                    'class' => 'custom-active-class',
                    'style' => [
                        'margin' => '-1px',
                    ],
                ],

                [
                    'class="custom-active-class active"',
                    'style="margin: -1px;"',
                ],
            ],
        ];
    }

    /**
     * @dataProvider activeOptionsDataProvider
     */
    public function testActiveOptions(array $options, array $expected): void
    {
        $notActive = Link::widget()
            ->activeOptions($options)
            ->label('');
        $active = $notActive->active(true);

        foreach ($expected as $option) {
            $this->assertStringContainsString($option, (string)$active);
            $this->assertStringNotContainsString($option, (string)$notActive);
        }
    }

    public static function encodeDataProvider(): array
    {
        return [
            [
                Html::span('test'),
                '<a id="test-link"><span>test</span></a>',
                '<a id="test-link">' . Html::encode('<span>test</span>') . '</a>',
                '<a id="test-link"><span>test</span></a>',
            ],

            [
                Html::div('test'),
                '<a id="test-link"><div>test</div></a>',
                '<a id="test-link">' . Html::encode('<div>test</div>') . '</a>',
                '<a id="test-link"><div>test</div></a>',
            ],

            [
                '<b>bold</b>',
                '<a id="test-link">' . Html::encode('<b>bold</b>') . '</a>',
                '<a id="test-link">' . Html::encode('<b>bold</b>') . '</a>',
                '<a id="test-link"><b>bold</b></a>',
            ],
        ];
    }

    /**
     * @dataProvider encodeDataProvider
     */
    public function testEncode(
        string|Stringable $label,
        string $expectedNull,
        string $expectedTrue,
        string $expectedFalse
    ): void {

        $null = Link::widget()->id('test-link')->label($label);
        $true = $null->encode(true);
        $false = $null->encode(false);

        $this->assertSame($expectedNull, (string)$null);
        $this->assertSame($expectedTrue, (string)$true);
        $this->assertSame($expectedFalse, (string)$false);
    }

    public function testImmutable(): void
    {
        $link = Link::widget();

        $this->assertNotSame($link, $link->tag('b'));
        $this->assertNotSame($link, $link->active(true));
        $this->assertNotSame($link, $link->disabled(true));
        $this->assertNotSame($link, $link->encode(true));
        $this->assertNotSame($link, $link->url('/'));
        $this->assertNotSame($link, $link->options([]));
        $this->assertNotSame($link, $link->activeOptions([]));
        $this->assertNotSame($link, $link->visible(false));
        $this->assertNotSame($link, $link->label(''));
        $this->assertNotSame($link, $link->pane(null));
        $this->assertNotSame($link, $link->item(Item::widget()));
        $this->assertNotSame($link, $link->toggle(''));
        $this->assertNotSame($link, $link->widgetClassName(''));

        $link = $link->activeOptions([]);

        $this->assertSame($link, $link->activate());
        $this->assertSame($link, $link->activeOptions(['test' => 1], false));
    }

    public function testNotVisible(): void
    {
        $this->assertEmpty(Link::widget()->visible(false)->render());
    }

    public static function bsTargetDataProvider(): array
    {
        return [
            [
                'a',
                '/test',
                null,
                '<a id="test-link" href="/test"></a>',
            ],
            [
                'a',
                '/test',
                'test-pane',
                '<a id="test-link" href="/test" role="tab" aria-controls="test-pane" aria-selected="false" data-bs-target="#test-pane"></a>',
            ],
            [
                'a',
                null,
                'test-pane',
                '<a id="test-link" href="#test-pane" role="tab" aria-controls="test-pane" aria-selected="false"></a>',
            ],
            [
                'button',
                null,
                'test-pane',
                '<button type="button" id="test-link" role="tab" aria-controls="test-pane" aria-selected="false" data-bs-target="#test-pane"></button>',
            ],
        ];
    }

    /**
     * @dataProvider bsTargetDataProvider
     */
    public function testBsTarget(string $tag, ?string $url, ?string $paneId, string $expected): void
    {
        $link = Link::widget()
                ->id('test-link')
                ->label('')
                ->url($url)
                ->tag($tag);

        if ($paneId) {
            $link = $link->pane(
                TabPane::widget()->id($paneId)
            );
        }

        $this->assertSame($expected, (string)$link);
    }

    public static function menuTypeDataProvider(): array
    {
        return array_map(
            static fn (MenuType $type) => [$type],
            MenuType::cases()
        );
    }

    /**
     * @dataProvider menuTypeDataProvider
     */
    public function testWidgetClassName(MenuType $type): void
    {
        $link = Link::widget()->widgetClassName($type->linkClassName());

        $this->assertStringContainsString('class="' . $type->linkClassName() . '"', (string)$link);
    }
}
