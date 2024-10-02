<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;
use Yiisoft\Yii\Bootstrap5\Nav;

final class NavTest extends TestCase
{
    public function testSimpleNav(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->links(
                    Link::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    Link::widget()->id('link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item"><a id="link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="link-2" class="nav-link" href="/link-2">Link 2</a></li>
        <li class="nav-item"><a id="link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testNavWithoutItems(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->tag('nav')
                ->defaultItem(false)
                ->links(
                    Link::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('test-link-2')->label('Link 2')->url('/link-2'),
                    Link::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <nav id="test-nav" class="nav">
        <a id="test-link-1" class="nav-link" href="/link-1">Link 1</a>
        <a id="test-link-2" class="nav-link" href="/link-2">Link 2</a>
        <a id="test-link-3" class="nav-link" href="/link-3">Link 3</a>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testNavWithCustomItems(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->tag('nav')
                ->defaultItem(false)
                ->links(
                    Link::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()
                        ->id('test-link-2')
                        ->label('Link 2')
                        ->url('/link-2')
                        ->item(
                            Item::widget()
                                ->tag('div')
                                ->options(['class' => 'custom-item'])
                        ),
                    Link::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <nav id="test-nav" class="nav">
        <a id="test-link-1" class="nav-link" href="/link-1">Link 1</a>
        <div class="custom-item nav-item"><a id="test-link-2" class="nav-link" href="/link-2">Link 2</a></div>
        <a id="test-link-3" class="nav-link" href="/link-3">Link 3</a>
        </nav>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testActive(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->activeItem('/link-2')
                ->links(
                    Link::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('test-link-2')->label('Link 2')->url('/link-2?foo=bar'),
                    Link::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item"><a id="test-link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="test-link-2" class="nav-link active" href="/link-2?foo=bar" aria-current="page">Link 2</a></li>
        <li class="nav-item"><a id="test-link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);

        $nav = Nav::widget()
                ->id('test-nav')
                ->activeItem(2)
                ->links(
                    Link::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('test-link-2')->label('Link 2')->url('/link-2?foo=bar'),
                    Link::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item"><a id="test-link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="test-link-2" class="nav-link" href="/link-2?foo=bar">Link 2</a></li>
        <li class="nav-item"><a id="test-link-3" class="nav-link active" href="/link-3" aria-current="page">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testActivateParents(): void
    {
        $dropdown = Dropdown::widget()->id('test-dropdown');

        $toggle = Link::widget()
            ->id('test-toggle')
            ->url('#')
            ->label('toggler');

        $items = [
            Link::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
            Link::widget()->id('test-link-2')->label('Link 2')->url('/link-2'),
            Link::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
        ];

        $item = Item::widget()
            ->dropdown($dropdown)
            ->items(...$items);

        $nav = Nav::widget()
                ->id('test-nav')
                ->activeItem('/link-2')
                ->activateParents(true)
                ->links($toggle->item($item));

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item dropdown">
        <a id="test-toggle" class="dropdown-toggle nav-link active" href="#" aria-expanded="false" role="button" data-bs-toggle="dropdown">toggler</a>
        <ul id="test-dropdown" class="dropdown-menu">
        <li><a class="dropdown-item" href="/link-1">Link 1</a></li>
        <li><a class="dropdown-item active" href="/link-2">Link 2</a></li>
        <li><a class="dropdown-item" href="/link-3">Link 3</a></li>
        </ul></li></ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public static function typeDataProvider(): array
    {
        return [
            [MenuType::Tabs],
            [MenuType::Pills],
            [MenuType::Underline],
        ];
    }

    /**
     * @dataProvider typeDataProvider
     */
    public function testType(MenuType $type): void
    {
        $nav = Nav::widget()
                ->links(
                    Link::widget()->label('Link 1')->url('/link-1')
                );

        $withType = $nav->type($type);

        $withMethod = match ($type) {
            MenuType::Tabs => $nav->tabs(),
            MenuType::Pills => $nav->pills(),
            MenuType::Underline => $nav->underline(),
        };

        $this->assertStringContainsString('class="' . $type->value . '"', (string)$withType);
        $this->assertStringContainsString('class="' . $type->value . '"', (string)$withMethod);
    }

    public static function verticalDataProvider(): array
    {
        return [
            [null, null],
            [Size::ExtraSmall, 'flex-column'],
            [Size::Small, 'flex-sm-column'],
            [Size::Medium, 'flex-md-column'],
            [Size::Large, 'flex-lg-column'],
            [Size::ExtraLarge, 'flex-xl-column'],
            [Size::ExtraExtraLarge, 'flex-xxl-column'],
        ];
    }

    /**
     * @dataProvider verticalDataProvider
     */
    public function testVertical(?Size $value, ?string $expected): void
    {
        $nav = Nav::widget()
                ->vertical($value)
                ->links(
                    Link::widget()->label('Link 1')->url('/link-1'),
                );

        if ($expected === null) {
            $this->assertStringContainsString('class="nav"', (string)$nav);
        } else {
            $this->assertStringContainsString('class="nav ' . $expected . '"', (string)$nav);
        }
    }

    public function testOptions(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->options([
                    'class' => 'custom-nav',
                    'style' => 'margin: -1px',
                ])
                ->links(
                    Link::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    Link::widget()->id('link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="custom-nav nav" style="margin: -1px">
        <li class="nav-item"><a id="link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="link-2" class="nav-link" href="/link-2">Link 2</a></li>
        <li class="nav-item"><a id="link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testImmutable(): void
    {
        $nav = Nav::widget();

        $this->assertNotSame($nav, $nav->tag('nav'));
        $this->assertNotSame($nav, $nav->options([]));
        $this->assertNotSame($nav, $nav->defaultItem(false));
        $this->assertNotSame($nav, $nav->links());
        $this->assertNotSame($nav, $nav->type(MenuType::Pills));
        $this->assertNotSame($nav, $nav->tabs());
        $this->assertNotSame($nav, $nav->pills());
        $this->assertNotSame($nav, $nav->underline());
        $this->assertNotSame($nav, $nav->vertical(null));
        $this->assertNotSame($nav, $nav->activeItem(1));
        $this->assertNotSame($nav, $nav->activateParents(true));
    }

    public function testVisible(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->links(
                    Link::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('link-2')->label('Link 2')->url('/link-2')->visible(false),
                    Link::widget()->id('link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item"><a id="link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }

    public function testEmpty(): void
    {
        $this->assertEmpty((string)Nav::widget());
    }

    public function testDefaultCustomItem(): void
    {
        $nav = Nav::widget()
                ->id('test-nav')
                ->defaultItem(
                    Item::widget()
                        ->options([
                            'class' => 'default-custom-item',
                        ])
                )
                ->links(
                    Link::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    Link::widget()->id('link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="default-custom-item nav-item"><a id="link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="default-custom-item nav-item"><a id="link-2" class="nav-link" href="/link-2">Link 2</a></li>
        <li class="default-custom-item nav-item"><a id="link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);
    }
}
