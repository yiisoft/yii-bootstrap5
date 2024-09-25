<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\AbstractNav;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Menu;
use Yiisoft\Yii\Bootstrap5\NavItem;
use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\Size;

final class MenuTest extends TestCase
{
    public function testSimpleNav(): void
    {
        $nav = Menu::widget()
                ->id('test-nav')
                ->items(
                    NavLink::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    NavLink::widget()->id('link-3')->label('Link 3')->url('/link-3'),
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
        $nav = Menu::widget()
                ->id('test-nav')
                ->tag('nav')
                ->defaultItem(false)
                ->items(
                    NavLink::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('test-link-2')->label('Link 2')->url('/link-2'),
                    NavLink::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
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
        $nav = Menu::widget()
                ->id('test-nav')
                ->tag('nav')
                ->defaultItem(false)
                ->items(
                    NavLink::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    NavItem::widget()
                        ->tag('div')
                        ->options(['class' => 'custom-item'])
                        ->links(
                            NavLink::widget()->id('test-link-2')->label('Link 2')->url('/link-2')
                        ),
                    NavLink::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
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
        $nav = Menu::widget()
                ->id('test-nav')
                ->activeItem('/link-2')
                ->items(
                    NavLink::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('test-link-2')->label('Link 2')->url('/link-2?foo=bar'),
                    NavLink::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item"><a id="test-link-1" class="nav-link" href="/link-1">Link 1</a></li>
        <li class="nav-item"><a id="test-link-2" class="nav-link active" href="/link-2?foo=bar" aria-current="page">Link 2</a></li>
        <li class="nav-item"><a id="test-link-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$nav);

        $nav = Menu::widget()
                ->id('test-nav')
                ->activeItem(2)
                ->items(
                    NavLink::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('test-link-2')->label('Link 2')->url('/link-2?foo=bar'),
                    NavLink::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
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

        $toggle = NavLink::widget()
            ->id('test-toggle')
            ->url('#')
            ->label('toggler');

        $items = [
            NavLink::widget()->id('test-link-1')->label('Link 1')->url('/link-1'),
            NavLink::widget()->id('test-link-2')->label('Link 2')->url('/link-2'),
            NavLink::widget()->id('test-link-3')->label('Link 3')->url('/link-3'),
        ];

        $item = NavItem::widget()
            ->dropdown($dropdown)
            ->links($toggle, ...$items);

        $nav = Menu::widget()
                ->id('test-nav')
                ->activeItem('/link-2')
                ->activateParents(true)
                ->items($item);

        $expected = <<<'HTML'
        <ul id="test-nav" class="nav">
        <li class="nav-item dropdown">
        <a id="test-toggle" class="dropdown-toggle nav-link active" href="#" data-bs-toggle="dropdown" aria-expanded="false" role="button">toggler</a>
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
            [AbstractNav::NAV_TABS],
            [AbstractNav::NAV_PILLS],
            [AbstractNav::NAV_UNDERLINE],
        ];
    }

    /**
     * @dataProvider typeDataProvider
     */
    public function testType(string $type): void
    {
        $nav = Menu::widget()
                ->type($type)
                ->items(
                    NavLink::widget()->label('Link 1')->url('/link-1'),
                );

        $this->assertStringContainsString('class="nav ' . $type . '"', (string)$nav);
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
        $nav = Menu::widget()
                ->vertical($value)
                ->items(
                    NavLink::widget()->label('Link 1')->url('/link-1'),
                );

        if ($expected === null) {
            $this->assertStringContainsString('class="nav"', (string)$nav);
        } else {
            $this->assertStringContainsString('class="nav ' . $expected . '"', (string)$nav);
        }
    }

    public function testOptions(): void
    {
        $nav = Menu::widget()
                ->id('test-nav')
                ->options([
                    'class' => 'custom-nav',
                    'style' => 'margin: -1px',
                ])
                ->items(
                    NavLink::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    NavLink::widget()->id('link-3')->label('Link 3')->url('/link-3'),
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
        $nav = Menu::widget();

        $this->assertNotSame($nav, $nav->tag('nav'));
        $this->assertNotSame($nav, $nav->options([]));
        $this->assertNotSame($nav, $nav->defaultItem(false));
        $this->assertNotSame($nav, $nav->items());
        $this->assertNotSame($nav, $nav->type(null));
        $this->assertNotSame($nav, $nav->tabs());
        $this->assertNotSame($nav, $nav->pills());
        $this->assertNotSame($nav, $nav->underline());
        $this->assertNotSame($nav, $nav->vertical(null));
        $this->assertNotSame($nav, $nav->activeItem(1));
        $this->assertNotSame($nav, $nav->activateParents(true));
    }

    public function testVisible(): void
    {
        $nav = Menu::widget()
                ->id('test-nav')
                ->items(
                    NavLink::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('link-2')->label('Link 2')->url('/link-2')->visible(false),
                    NavLink::widget()->id('link-3')->label('Link 3')->url('/link-3'),
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
        $nav = Menu::widget()
                ->id('test-nav');

        $this->assertEmpty((string)$nav);
    }

    public function testDefaultCustomItem(): void
    {
        $nav = Menu::widget()
                ->id('test-nav')
                ->defaultItem(
                    NavItem::widget()
                        ->options([
                            'class' => 'default-custom-item',
                        ])
                )
                ->items(
                    NavLink::widget()->id('link-1')->label('Link 1')->url('/link-1'),
                    NavLink::widget()->id('link-2')->label('Link 2')->url('/link-2'),
                    NavLink::widget()->id('link-3')->label('Link 3')->url('/link-3'),
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
