<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Progress;
use Yiisoft\Yii\Bootstrap5\ProgressStack;

/**
 * Tests for `Progress` widget.
 */
final class ProgressTest extends TestCase
{
    public function testRender(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withLabel('Progress')
            ->withPercent(25)
            ->withBarOptions(['class' => 'bg-warning'])
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-label="Progress" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="bg-warning progress-bar" style="width: 25%;"></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMin(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withLabel('Progress')
            ->withMin(5)
            ->withPercent(10)
            ->withBarOptions(['class' => 'bg-warning'])
            ->render();

        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-label="Progress" aria-valuenow="10" aria-valuemin="5" aria-valuemax="100"><div class="bg-warning progress-bar" style="width: 10%;"></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMax(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withLabel('Progress')
            ->withMax(95)
            ->withPercent(90)
            ->withBarOptions(['class' => 'bg-warning'])
            ->render();

        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-label="Progress" aria-valuenow="90" aria-valuemin="0" aria-valuemax="95"><div class="bg-warning progress-bar" style="width: 90%;"></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public static function stripedDataProvider(): array
    {
        return [
            [null, true],
            [true, true],
            [false, false],
        ];
    }

    /**
     * @dataProvider stripedDataProvider
     * @param bool|null $striped
     * @param bool $expected
     * @return void
     */
    public function testStriped(?bool $striped, bool $expected): void
    {
        $widget = Progress::widget()
            ->id('test')
            ->withPercent(90)
            ->withBarOptions(['class' => 'bg-danger']);

        if ($striped === null) {
            $widget = $widget->withStriped();
        } else {
            $widget = $widget->withStriped($striped);
        }

        $html = $widget->render();

        if ($expected) {

            $expected = <<<'HTML'
            <div id="test" class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"><div class="bg-danger progress-bar progress-bar-striped" style="width: 90%;"></div></div>
            HTML;

        } else {

            $expected = <<<'HTML'
            <div id="test" class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"><div class="bg-danger progress-bar" style="width: 90%;"></div></div>
            HTML;
        }

        $this->assertSame($expected, $html);
    }

    public static function animatedDataProvider(): array
    {
        return [
            [null, true],
            [true, true],
            [false, false],
        ];
    }

    /**
     * @dataProvider animatedDataProvider
     * @param bool|null $animated
     * @param bool $expected
     * @return void
     */
    public function testAnimated(?bool $animated, bool $expected): void
    {
        $widget = Progress::widget()
            ->id('test')
            ->withPercent(90)
            ->withBarOptions(['class' => 'bg-danger']);

        if ($animated === null) {
            $widget = $widget->withAnimated();
        } else {
            $widget = $widget->withAnimated($animated);
        }

        $html = $widget->render();

        if ($expected) {

            $expected = <<<'HTML'
            <div id="test" class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"><div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" style="width: 90%;"></div></div>
            HTML;

        } else {

            $expected = <<<'HTML'
            <div id="test" class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"><div class="bg-danger progress-bar" style="width: 90%;"></div></div>
            HTML;
        }

        $this->assertSame($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withPercent(25)
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 25%;"></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testContent(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withPercent(25)
            ->withContent('Content')
            ->withLabel('Progress')
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-label="Progress" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 25%;">Content</div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testBarsMultiple(): void
    {
        $bars = [
            Progress::widget()
                ->id('bar-1')
                ->withPercent(15),
            Progress::widget()
                ->id('bar-2')
                ->withPercent(30)
                ->withBarOptions([
                    'class' => 'bg-success',
                ]),
            Progress::widget()
                ->id('bar-3')
                ->withPercent(20)
                ->withBarOptions([
                    'class' => 'bg-info',
                ]),
        ];

        $html = ProgressStack::widget()
            ->id('test')
            ->withBars(...$bars)
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress-stacked"><div id="bar-1" class="progress" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 15%;"></div></div><div id="bar-2" class="progress" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"><div class="bg-success progress-bar" style="width: 30%;"></div></div><div id="bar-3" class="progress" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><div class="bg-info progress-bar" style="width: 20%;"></div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEmptyBarsMultiple(): void
    {
        $this->assertEmpty(ProgressStack::widget()->render());
    }

    public function testBarsMultipleOptions(): void
    {
        $bars = [
            Progress::widget()
                ->id('bar-1')
                ->withPercent(15),
            Progress::widget()
                ->id('bar-2')
                ->withPercent(30)
                ->withBarOptions([
                    'class' => 'bg-success',
                ]),
            Progress::widget()
                ->id('bar-3')
                ->withPercent(20)
                ->withBarOptions([
                    'class' => 'bg-info',
                ]),
        ];

        $html = ProgressStack::widget()
            ->id('test')
            ->withBars(...$bars)
            ->withOptions([
                'class' => 'border',
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="border progress-stacked"><div id="bar-1" class="progress" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 15%;"></div></div><div id="bar-2" class="progress" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"><div class="bg-success progress-bar" style="width: 30%;"></div></div><div id="bar-3" class="progress" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><div class="bg-info progress-bar" style="width: 20%;"></div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMissingPercent(): void
    {
        $this->expectException(RuntimeException::class);
        Progress::widget()
            ->render();
    }

    public function testOptions(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->withContent('Progress')
            ->withPercent(35)
            ->withOptions(['class' => 'text-danger'])
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="text-danger progress" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 35%;">Progress</div></div>
        HTML;
        $this->assertSame($expected, $html);
    }
}
