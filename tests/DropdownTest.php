<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use LogicException;
use stdClass;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\DropAlignment;
use Yiisoft\Yii\Bootstrap5\Enum\DropDirection;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Enum\Theme;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;

use function array_map;
use function preg_replace;

/**
 * Tests for `Dropdown` widget.
 */
final class DropdownTest extends TestCase
{
    public function testRender(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(
                Link::widget()->label('Page1')->url('#')->disabled(true),
                Link::widget()->label('Page2')->url('#')->active(true),
                Dropdown::widget()
                    ->id('ID2')
                    ->toggle(
                        Link::widget()->url('#test')->label('Dropdown1')
                    )
                    ->items(
                        Link::widget()->tag('h6')->label('Page2'),
                        Link::widget()->tag('h6')->label('Page3')
                    ),
                Dropdown::widget()
                    ->toggle(
                        Link::widget()->label('Dropdown2')->visible(false)
                    )
                    ->items(
                        Link::widget()->label('Page4'),
                        Link::widget()->label('Page5')
                    )
            )
            ->render();

        $html = preg_replace('/\sid="bp5w\d+"/', '', $html);

        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li><a class="dropdown-item disabled" href="#" aria-disabled="true">Page1</a></li>
        <li><a class="dropdown-item active" href="#">Page2</a></li>
        <li class="dropdown">
        <a class="dropdown-item dropdown-toggle" href="#test" aria-expanded="false" data-bs-auto-close="outside" aria-haspopup="true" role="button" data-bs-toggle="dropdown">Dropdown1</a>
        <ul id="ID2" class="dropdown-menu">
        <li><h6 class="dropdown-header">Page2</h6></li>
        <li><h6 class="dropdown-header">Page3</h6></li>
        </ul></li>
        </ul>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testRenderString(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->items('Some string content')
            ->render();

        $expected = '<div id="TEST_ID" class="dropdown-menu">Some string content</div>';

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderStringableContent(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->items(Html::p('Some stringable p-tag content'))
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu"><p>Some stringable p-tag content</p></div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public static function alignmentDataProvider(): array
    {
        return [
            [DropAlignment::Start, null],
            [DropAlignment::Start, Size::ExtraSmall],
            [DropAlignment::Start, Size::Small],
            [DropAlignment::Start, Size::Medium],
            [DropAlignment::Start, Size::Large],
            [DropAlignment::Start, Size::ExtraLarge],
            [DropAlignment::Start, Size::ExtraExtraLarge],

            [DropAlignment::End, null],
            [DropAlignment::End, Size::ExtraSmall],
            [DropAlignment::End, Size::Small],
            [DropAlignment::End, Size::Medium],
            [DropAlignment::End, Size::Large],
            [DropAlignment::End, Size::ExtraLarge],
            [DropAlignment::End, Size::ExtraExtraLarge],
        ];
    }

    /**
     * @dataProvider alignmentDataProvider
     */
    public function testAlignment(DropAlignment $alignment, ?Size $size): void
    {
        $dropdown = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->items('Alignment dropdown');

        if ($size) {
            $dropdown = $dropdown->alignments($alignment, $size);
            $className = $size->formatClassName(MenuType::Dropdown->value, $alignment->value);
            $expected = '<div id="TEST_ID" class="dropdown-menu ' . $className . '">Alignment dropdown</div>';
        } else {
            $dropdown = $dropdown->alignments($alignment);
            $expected = '<div id="TEST_ID" class="dropdown-menu">Alignment dropdown</div>';
        }

        $this->assertEqualsWithoutLE($expected, $dropdown->render());
    }

    public static function themeDataProvider(): array
    {
        return [
            [Theme::Dark, '<div id="TEST_ID" class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark"></div>'],
            [Theme::Light, '<div id="TEST_ID" class="dropdown-menu" data-bs-theme="light"></div>'],
            ['blue', '<div id="TEST_ID" class="dropdown-menu" data-bs-theme="blue"></div>'],
        ];
    }

    /**
     * @dataProvider themeDataProvider
     */
    public function testTheme(string|Theme $theme, string $expected): void
    {
        $dropdown = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->items('')
            ->withTheme($theme);

        $this->assertEqualsWithoutLE($expected, (string)$dropdown);

        if ($theme instanceof Theme) {

            if ($theme === Theme::Dark) {
                $html = $dropdown->withDarkTheme()->render();
            } else {
                $html = $dropdown->withLightTheme()->render();
            }

            $this->assertEqualsWithoutLE($expected, $html);
        }
    }

    public function testSubMenuOptions(): void
    {
        $subMenu = Dropdown::widget()
                ->options([
                    'class' => 'submenu-override',
                ]);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(
                $subMenu
                    ->id('ID1')
                    ->options([
                        'class' => 'submenu-list',
                    ])
                    ->toggle(
                        Link::widget()->label('Dropdown1')->tag('a')
                    )
                    ->items(
                        Link::widget()->tag('h6')->label('Page1'),
                        Link::widget()->tag('h6')->label('Page2')
                    ),
                Link::widget()->tag('hr'),
                $subMenu
                    ->id('ID2')
                    ->toggle(
                        Link::widget()->label('Dropdown2')->tag('a')
                    )
                    ->items(
                        Link::widget()->tag('h6')->label('Page3'),
                        Link::widget()->tag('h6')->label('Page4')
                    )
            )
            ->render();

        $html = preg_replace('/\sid="bp5w\d+"/', '', $html);

        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="dropdown">
        <a class="dropdown-item dropdown-toggle" aria-expanded="false" data-bs-auto-close="outside" aria-haspopup="true" role="button" data-bs-toggle="dropdown">Dropdown1</a>
        <ul id="ID1" class="submenu-list dropdown-menu">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul></li>
        <li><hr class="dropdown-divider"></li>
        <li class="dropdown">
        <a class="dropdown-item dropdown-toggle" aria-expanded="false" data-bs-auto-close="outside" aria-haspopup="true" role="button" data-bs-toggle="dropdown">Dropdown2</a>
        <ul id="ID2" class="submenu-override dropdown-menu">
        <li><h6 class="dropdown-header">Page3</h6></li>
        <li><h6 class="dropdown-header">Page4</h6></li>
        </ul></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testForms(): void
    {
        $form = <<<'HTML'
        <form class="px-4 py-3">
        <div class="form-group">
        <label for="exampleDropdownFormEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
        Remember me
        </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        HTML;
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->defaultItem(false)
            ->items(
                $form,
                Link::widget()->tag('hr'),
                Link::widget()->label('New around here? Sign up')->url('#'),
                Link::widget()->tag('hr'),
                Link::widget()->label('Forgot password?')->url('#'),
                Link::widget()->tag('hr')->visible(false)
            )
            ->render();

        $html = preg_replace('/\sid="bp5w\d+"/', '', $html);

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu">
        <form class="px-4 py-3">
        <div class="form-group">
        <label for="exampleDropdownFormEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
        </div>
        <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
        </div>
        <div class="form-check">
        <input type="checkbox" class="form-check-input" id="dropdownCheck">
        <label class="form-check-label" for="dropdownCheck">
        Remember me
        </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="#">New around here? Sign up</a>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="#">Forgot password?</a>
        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testEncodeTags(): void
    {
        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->tag('div')
            ->items(Html::p('Some stringable p-tag content'))
            ->encode(true)
            ->render();

        $expected = <<<'HTML'
        <div id="TEST_ID" class="dropdown-menu">&lt;p&gt;Some stringable p-tag content&lt;/p&gt;</div>
        HTML;

        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMainOptions(): void
    {
        $item = Item::widget()->options(['class' => 'main-item-class']);
        $link = Link::widget()
            ->item($item)
            ->options(['class' => 'main-link-class']);

        $html = Dropdown::widget()
            ->id('TEST_ID')
            ->items(
                $link->label('Label 1')->url('#'),
                $link->label('Label 2')
                     ->url('#')
                     ->item(
                         Item::widget()
                            ->options([
                                'id' => 'custom-item-id',
                                'class' => 'custom-item-class',
                            ])
                     )
                     ->options([
                         'class' => 'custom-link-class'
                     ])
            )
            ->render();

        $html = preg_replace('/\sid="bp5w\d+"/', '', $html);

        $expected = <<<'HTML'
        <ul id="TEST_ID" class="dropdown-menu">
        <li class="main-item-class"><a class="main-link-class dropdown-item" href="#">Label 1</a></li>
        <li id="custom-item-id" class="custom-item-class"><a class="custom-link-class dropdown-item" href="#">Label 2</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public static function directionDataProvider(): array
    {
        return array_map(
            static fn (DropDirection $direction) => [$direction],
            DropDirection::cases()
        );
    }

    /**
     * @dataProvider directionDataProvider
     */
    public function testDirection(DropDirection $direction): void
    {
        $html = Dropdown::widget()
            ->tag('div')
            ->id('test-menu')
            ->direction($direction)
            ->toggle(
                Link::widget()->label('Toggler')
                    ->id('')
                    ->item(Item::widget()->tag('div'))
            )
            ->items('content')
            ->render();

        $expected = <<<HTML
        <div class="{$direction->value}">
        <button type="button" id class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Toggler</button>
        <div id="test-menu" class="dropdown-menu">content</div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public static function splitDataProvider(): array
    {
        return [
            [null, '<div class="btn-group dropdown"><a id href="/link">Toggler</a><button type="button" id class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">Split toggle button</button>'],
            [true, '<div class="btn-group dropdown"><a id href="/link">Toggler</a><a id class="dropdown-toggle dropdown-toggle-split" href="/link" aria-expanded="false" role="button" data-bs-toggle="dropdown"><span class="visually-hidden">Toggle Dropdown</span></a>'],
            [false, '<div class="dropdown"><a id class="dropdown-toggle" href="/link" aria-expanded="false" role="button" data-bs-toggle="dropdown">Toggler</a>'],
        ];
    }

    /**
     * @dataProvider splitDataProvider
     */
    public function testSplit(?bool $split, string $expected): void
    {
        if ($split === null) {
            $split = Link::widget()
                ->id('')
                ->label('Split toggle button')
                ->options([
                    'class' => 'custom-toggle-class',
                ]);
        }

        $html = Dropdown::widget()
            ->tag('div')
            ->id('')
            ->split($split)
            ->toggle(
                Link::widget()->label('Toggler')
                    ->id('')
                    ->tag('a')
                    ->url('/link')
                    ->item(Item::widget()->tag('div'))
            )
            ->items('content')
            ->render();

        $this->assertStringStartsWith($expected, $html);
    }

    public function testEmptyMenu(): void
    {
        $this->assertEmpty((string)Dropdown::widget());
    }

    public function testHiddenToggle(): void
    {
        $html = Dropdown::widget()
            ->tag('div')
            ->id('')
            ->toggle(
                Link::widget()->label('Toggler')->visible(false)
            )
            ->items('content1', 'content2', 'content3')
            ->render();

        $this->assertEmpty($html);
    }

    public function testNoToggle(): void
    {
        $html = Dropdown::widget()
            ->id('')
            ->items(
                Link::widget()->id('')->label('Item 1')->url('/link-1'),
                Link::widget()->id('')->label('Item 2')->url('/link-2'),
                Link::widget()->id('')->label('Item 3')->url('/link-3'),
            )
            ->render();

        $expected = <<<'HTML'
        <ul id class="dropdown-menu">
        <li><a id class="dropdown-item" href="/link-1">Item 1</a></li>
        <li><a id class="dropdown-item" href="/link-2">Item 2</a></li>
        <li><a id class="dropdown-item" href="/link-3">Item 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public static function exceptionDataProvider(): array
    {
        return [
            [1, InvalidArgumentException::class],
            [null, InvalidArgumentException::class],
            [Html::span('test'), null],
            [new stdClass(), InvalidArgumentException::class],
            ['string', null],
            [[1, 2, 3], InvalidArgumentException::class],
            [true, InvalidArgumentException::class],
            [Dropdown::class, LogicException::class],
        ];
    }

    /**
     * @dataProvider exceptionDataProvider
     */
    public function testExceptions(mixed $item, ?string $exception): void
    {
        if ($exception === null) {
            $this->expectNotToPerformAssertions();
        } else {

            if ($item === Dropdown::class) {
                $item = Dropdown::widget();
            }

            $this->expectException($exception);
        }

        Dropdown::widget()->items($item);
    }

    public function testNoItem(): void
    {
        $html = Dropdown::widget()
            ->id('')
            ->tag('div')
            ->defaultItem(false)
            ->toggle(
                Link::widget()->id('')->label('toggle')
            )
            ->items('content')
            ->render();

        $expected = <<<'HTML'
        <button type="button" id class="dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown">toggle</button><div id class="dropdown-menu">content</div>
        HTML;

        $this->assertSame($expected, $html);
    }
}
