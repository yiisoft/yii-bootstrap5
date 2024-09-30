<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;
use Yiisoft\Yii\Bootstrap5\NavItem;
use Yiisoft\Yii\Bootstrap5\NavLink;

use function preg_replace;

final class NavItemTest extends TestCase
{
    public function testSimpleNavItem(): void
    {
        $link = NavLink::widget()
            ->id('test-link')
            ->label('Simple nav link');

        $item = NavItem::widget()
            ->link($link);

        $expected = <<<'HTML'
        <li class="nav-item"><a id="test-link" class="nav-link">Simple nav link</a></li>
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
    public function testTagNavItem(string $tag): void
    {
        $link = NavLink::widget()
            ->id('test-link')
            ->url('#')
            ->label('Label for ' . $tag);

        $item = NavItem::widget()
            ->tag($tag)
            ->link($link);

        $expected = <<<HTML
        <{$tag} class="nav-item"><a id="test-link" class="nav-link" href="#">Label for {$tag}</a></{$tag}>
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
                    'class="custom-class nav-item"',
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
        $link = NavLink::widget()
            ->label('');

        $item = NavItem::widget()
            ->options($options)
            ->link($link);

        foreach ($expected as $option) {
            $this->assertStringContainsString($option, (string)$item);
            $this->assertStringNotContainsString($option, (string)$link);
        }
    }

    public function testImmutable(): void
    {
        $item = NavItem::widget();
        $link = NavLink::widget()->label('');

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

        $toggle = NavLink::widget()
            ->url('#')
            ->label('toggler');

        $items = [
            NavLink::widget()->label('Link 1')->url('/link-1'),
            NavLink::widget()->label('Link 2')->url('/link-2'),
            NavItem::widget()
                ->link(
                    NavLink::widget()->label('Child toggler')
                )->items(
                    NavLink::widget()->label('Child link 1'),
                    NavLink::widget()->label('Child link 2')
                ),
            NavLink::widget()->label('Link 3')->url('/link-3'),
        ];

        $item = NavItem::widget()
            ->dropdown($dropdown)
            ->dropDirection($direction)
            ->link($toggle)
            ->items(...$items);

        $html = preg_replace('/\sid="[^"]+"/', '', $item->render());

        $expected = <<<HTML
        <li class="nav-item {$direction->value}"><a class="dropdown-toggle nav-link" href="#" aria-expanded="false" role="button" data-bs-toggle="dropdown">toggler</a><ul class="dropdown-menu">
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
        $link = NavLink::widget()
            ->id('test-link')
            ->label('Simple nav link')
            ->visible(false);

        $item = NavItem::widget()
            ->link($link);

        $this->assertEmpty((string)$item);
    }
}
