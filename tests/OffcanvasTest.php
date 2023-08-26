<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Offcanvas;

final class OffcanvasTest extends TestCase
{
    public function testRender(): void
    {
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->options([
                'class' => 'custom-class',
                'data-custom' => 'custom-data',
            ])
            ->title('Offcanvas title')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="custom-class offcanvas offcanvas-start" data-custom="custom-data" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
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
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <div class="custom-class offcanvas-header" data-custom="custom-data">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->titleOptions([
                'tag' => 'h2',
                'class' => 'h4',
            ])
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h2 id="w0-offcanvas-title" class="h4 offcanvas-title">Offcanvas title</h2>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->bodyOptions([
                'class' => 'custom-body-class',
                'data-custom' => 'custom-body-data',
            ])
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('')
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title"></h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);

        Offcanvas::counter(0);

        $html = Offcanvas::widget()->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1">
        <header class="offcanvas-header">
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testPlacement(): void
    {
        $placements = [
            Offcanvas::PLACEMENT_TOP,
            Offcanvas::PLACEMENT_END,
            Offcanvas::PLACEMENT_BOTTOM,
            Offcanvas::PLACEMENT_START,
        ];

        $Offcanvas = Offcanvas::widget()->options([
            'id' => 'offcanvas-placement',
        ]);

        foreach ($placements as $placement) {
            $html = $Offcanvas
                    ->placement($placement)
                    ->begin() . Offcanvas::end();

            $expected = <<<HTML
            <div id="offcanvas-placement" class="offcanvas {$placement}" tabindex="-1">
            <header class="offcanvas-header">
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </header>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML;

            $this->assertEqualsHTML($expected, $html);
        }
    }

    public function testScroll(): void
    {
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->scroll(true)
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title" data-bs-scroll="true">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title" data-bs-backdrop="false">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
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
        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->withDarkTheme()
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title" data-bs-backdrop="false" data-bs-theme="dark">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);


        Offcanvas::counter(0);

        $html = Offcanvas::widget()
            ->title('Offcanvas title')
            ->withTheme('red')
            ->withoutBackdrop()
            ->begin();
        $html .= '<p>Some content here</p>';
        $html .= Offcanvas::end();

        $expected = <<<'HTML'
        <div id="w0-offcanvas" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="w0-offcanvas-title" data-bs-backdrop="false" data-bs-theme="red">
        <header class="offcanvas-header">
        <h5 id="w0-offcanvas-title" class="offcanvas-title">Offcanvas title</h5>
        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
        </header>
        <div class="offcanvas-body">
        <p>Some content here</p>
        </div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
