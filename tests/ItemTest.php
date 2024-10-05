<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;

use function array_map;

final class ItemTest extends TestCase
{
    public function testSimpleItem(): void
    {
        $link = Link::widget()
            ->id('test-link')
            ->label('Simple nav link');

        $item = Item::widget()
            ->link($link);

        $expected = <<<'HTML'
        <li><button type="button" id="test-link">Simple nav link</button></li>
        HTML;

        $this->assertSame($expected, (string)$item);
    }

    public static function tagDataProvider(): array
    {
        return [
            ['div'],
            ['span'],
        ];
    }

    /**
     * @dataProvider tagDataProvider
     */
    public function testTagItem(string $tag): void
    {
        $link = Link::widget()
            ->id('test-link')
            ->url('#')
            ->label('Label for ' . $tag);

        $item = Item::widget()
            ->tag($tag)
            ->link($link);

        $expected = <<<HTML
        <{$tag}><a id="test-link" href="#">Label for {$tag}</a></{$tag}>
        HTML;

        $this->assertSame($expected, (string)$item);
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
            ->label('');

        $item = Item::widget()
            ->options($options)
            ->link($link);

        foreach ($expected as $option) {
            $this->assertStringContainsString($option, (string)$item);
            $this->assertStringNotContainsString($option, (string)$link);
        }
    }

    public function testImmutable(): void
    {
        $item = Item::widget();
        $link = Link::widget()->label('');

        $this->assertNotSame($item, $item->tag('b'));
        $this->assertNotSame($item, $item->options([]));
        $this->assertNotSame($item, $item->link($link));
        $this->assertSame($item->link($link)->getLink(), $link);
    }

    public function testVisible(): void
    {
        $link = Link::widget()
            ->id('test-link')
            ->label('Simple nav link')
            ->visible(false);

        $item = Item::widget()
            ->link($link);

        $this->assertEmpty((string)$item);
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
        $item = Item::widget()
                ->link(Link::widget())
                ->widgetClassName($type->itemClassName());

        if ($type->itemClassName()) {
            $this->assertStringContainsString('class="' . $type->itemClassName() . '"', (string)$item);
        } else {
            $this->assertStringNotContainsString('class', (string)$item);
        }
    }

    public function testOuterContent(): void
    {
        $html = Item::widget()
                ->link(
                    Link::widget()->id('')->label('Link'),
                )
                ->begin();
        $html .= 'Content after link';
        $html .= Item::end();

        $expected = '<li><button type="button" id>Link</button>Content after link</li>';

        $this->assertSame($expected, $html);

        $html = Item::widget()
                ->link(
                    Link::widget()->id('')->label('Link'),
                )
                ->begin(['class' => 'custom-class']);
        $html .= 'Content after link';
        $html .= Item::end();

        $expected = '<li class="custom-class"><button type="button" id>Link</button>Content after link</li>';

        $this->assertSame($expected, $html);
    }
}
