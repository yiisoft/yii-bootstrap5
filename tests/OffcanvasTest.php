<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Offcanvas;

final class OffcanvasTest extends TestCase
{
    public function testRender(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOptions(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->options([
                'class' => 'custom-class',
                'data-custom' => 'custom-data',
            ])
            ->title('Offcanvas title')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="custom-class offcanvas offcanvas-start" data-custom="custom-data" tabindex="-1" aria-labelledby="test-title">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testHeaderOptions(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->headerOptions([
                'tag' => 'div',
                'class' => 'custom-class',
                'data-custom' => 'custom-data',
            ])
            ->title('Offcanvas title')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title">
        <div class="custom-class offcanvas-header" data-custom="custom-data">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testTitleOptions(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->titleOptions([
                'tag' => 'h2',
                'class' => 'h4',
            ])
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title">
        <header class="offcanvas-header">
        <h2 id="test-title" class="h4 offcanvas-title">Offcanvas title</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testBodyOptions(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->bodyOptions([
                'class' => 'custom-body-class',
                'data-custom' => 'custom-body-data',
            ])
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="custom-body-class offcanvas-body" data-custom="custom-body-data">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testEmptyTitle(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);

        $html = Offcanvas::widget()->id('test')->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1">
        <header class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public static function placementDataProvider(): array
    {
        return [
            [
                Offcanvas::PLACEMENT_TOP,
                <<<'HTML'
                <div id="offcanvas-placement" class="offcanvas offcanvas-top" tabindex="-1">
                <header class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </header>
                <div class="offcanvas-body">
                </div>
                </div>
                HTML,
            ],

            [
                Offcanvas::PLACEMENT_BOTTOM,
                <<<'HTML'
                <div id="offcanvas-placement" class="offcanvas offcanvas-bottom" tabindex="-1">
                <header class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </header>
                <div class="offcanvas-body">
                </div>
                </div>
                HTML,
            ],

            [
                Offcanvas::PLACEMENT_START,
                <<<'HTML'
                <div id="offcanvas-placement" class="offcanvas offcanvas-start" tabindex="-1">
                <header class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </header>
                <div class="offcanvas-body">
                </div>
                </div>
                HTML,
            ],

            [
                Offcanvas::PLACEMENT_END,
                <<<'HTML'
                <div id="offcanvas-placement" class="offcanvas offcanvas-end" tabindex="-1">
                <header class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </header>
                <div class="offcanvas-body">
                </div>
                </div>
                HTML,
            ],
        ];
    }

    /**
     * @dataProvider placementDataProvider
     */
    public function testPlacement(string $placement, string $expected): void
    {
        $html = Offcanvas::widget()
                ->id('test')
                ->options([
                    'id' => 'offcanvas-placement',
                ])
                ->placement($placement)
                ->begin() . Offcanvas::end();

        $this->assertEqualsHTML($expected, $html);
    }

    public function testScroll(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->scroll(true)
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-scroll="true">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testBackdrop(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testThemes(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withDarkTheme()
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false" data-bs-theme="dark">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);

        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withTheme('red')
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false" data-bs-theme="red">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithToggle(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withTheme('red')
            ->withoutBackdrop()
            ->withToggle(true)
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="offcanvas" aria-controls="test" data-bs-target="#test"></button>
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false" data-bs-theme="red">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testCloseButton(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withTheme('red')
            ->withoutBackdrop()
            ->withToggle(true)
            ->withCloseButtonOptions([
                'class' => [
                    'widget' => 'test_class',
                ],
            ])
            ->withCloseButtonLabel('Close button label')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="offcanvas" aria-controls="test" data-bs-target="#test"></button>
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false" data-bs-theme="red">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="test_class" data-bs-dismiss="offcanvas">Close button label</button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testCloseButtonEncode(): void
    {
        $html = Offcanvas::widget()
            ->id('test')
            ->title('Offcanvas title')
            ->withTheme('red')
            ->withoutBackdrop()
            ->withToggle(true)
            ->withCloseButtonOptions([
                'class' => [
                    'widget' => '',
                ],
            ])
            ->withCloseButtonLabel(Html::img('close.png', 'Close'))
            ->withEncodeCloseButton(false)
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="offcanvas" aria-controls="test" data-bs-target="#test"></button>
        <div id="test" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="test-title" data-bs-backdrop="false" data-bs-theme="red">
        <header class="offcanvas-header">
        <h5 id="test-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class data-bs-dismiss="offcanvas">
        <img src="close.png" alt="Close">
        </button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
