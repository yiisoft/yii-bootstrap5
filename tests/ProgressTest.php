<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use LogicException;
use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Progress;

/**
 * Tests for `Progress` widget.
 */
final class ProgressTest extends TestCase
{
    public function testRender(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->label('Progress')
            ->percent(25)
            ->barOptions(['class' => 'bg-warning'])
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
            ->label('Progress')
            ->min(5)
            ->percent(10)
            ->barOptions(['class' => 'bg-warning'])
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
            ->label('Progress')
            ->max(95)
            ->percent(90)
            ->barOptions(['class' => 'bg-warning'])
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
     */
    public function testStriped(?bool $striped, bool $expected): void
    {
        $widget = Progress::widget()
            ->id('test')
            ->percent(90)
            ->barOptions(['class' => 'bg-danger']);

        if ($striped === null) {
            $widget = $widget->striped();
        } else {
            $widget = $widget->striped($striped);
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
     */
    public function testAnimated(?bool $animated, bool $expected): void
    {
        $widget = Progress::widget()
            ->id('test')
            ->percent(90)
            ->barOptions(['class' => 'bg-danger']);

        if ($animated === null) {
            $widget = $widget->animated();
        } else {
            $widget = $widget->animated($animated);
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
            ->percent(25)
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
            ->percent(25)
            ->content('Content')
            ->label('Progress')
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress" role="progressbar" aria-label="Progress" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 25%;">Content</div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMissingPercent(): void
    {
        $this->expectException(RuntimeException::class);
        Progress::widget()
            ->render();
    }

    public function testWrongPercent(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('"$percent" must be greater or equals 0. -1 given');

        Progress::widget()
            ->percent(-1)
            ->render();
    }

    public function testOptions(): void
    {
        $html = Progress::widget()
            ->id('test')
            ->content('Progress')
            ->percent(35)
            ->options(['class' => 'text-danger'])
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="text-danger progress" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: 35%;">Progress</div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public static function calculatedPercentProvider(): array
    {
        return [
            [275, 1000, null, 'aria-valuenow="27.5"'],
            [276, 1000, 0, 'aria-valuenow="28"'],
            [274, 1000, 0, 'aria-valuenow="27"'],
        ];
    }

    /**
     * @dataProvider calculatedPercentProvider
     * @param float|int $value
     * @param float|int $max
     * @param int|null $precision
     */
    public function testCalculatedPercent(int|float $value, int|float $max, ?int $precision, string $expected): void
    {
        $html = Progress::widget()
            ->id('test')
            ->calculatedPercent($value, $max, $precision)
            ->render();

        $this->assertStringContainsString($expected, $html);
    }
}
