<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;

use function array_map;
use function preg_replace;

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
        <li><a id="test-link">Simple nav link</a></li>
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
        $this->assertNotSame($item, $item->dropdown(null));
    }

    public static function dropdownDataProvider(): array
    {
        return array_map(
            static fn (DropDirection $direction) => [$direction],
            DropDirection::cases()
        );
    }

    /**
     * @dataProvider dropdownDataProvider
     */
    public function testDropdown(DropDirection $direction): void
    {
        $dropdown = Dropdown::widget()->id('test-dropdown');

        $toggle = Link::widget()
            ->url('#')
            ->label('toggler');

        $items = [
            Link::widget()->label('Link 1')->url('/link-1'),
            Link::widget()->label('Link 2')->url('/link-2'),
            Item::widget()
                ->link(
                    Link::widget()->label('Child toggler')
                )->items(
                    Link::widget()->label('Child link 1'),
                    Link::widget()->label('Child link 2')
                ),
            Link::widget()->label('Link 3')->url('/link-3'),
        ];

        $item = Item::widget()
            ->dropdown($dropdown)
            ->dropDirection($direction)
            ->link($toggle)
            ->items(...$items);

        $html = preg_replace('/\sid="[^"]+"/', '', $item->render());

        $expected = <<<HTML
        <li class="{$direction->value}"><a class="dropdown-toggle" href="#" aria-expanded="false" role="button" data-bs-toggle="dropdown">toggler</a><ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/link-1">Link 1</a></li>
        <li><a class="dropdown-item" href="/link-2">Link 2</a></li>
        <li class="dropdown" aria-expanded="false"><a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false" role="button">Child toggler</a><ul class="dropdown-menu">
        <li><h6 class="dropdown-header">Child link 1</h6></li>
        <li><h6 class="dropdown-header">Child link 2</h6></li>
        </ul></li>
        <li><a class="dropdown-item" href="/link-3">Link 3</a></li>
        </ul></li>
        HTML;

        $this->assertSame($expected, $html);
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
}
