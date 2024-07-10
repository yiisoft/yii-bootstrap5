<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Progress;
use Yiisoft\Yii\Bootstrap5\ProgressStack;

/**
 * Tests for `ProgressStack` widget.
 */
final class ProgressStackTest extends TestCase
{
    public function testBarsMultiple(): void
    {
        $bars = [
            Progress::widget()
                ->id('bar-1')
                ->percent(15),
            Progress::widget()
                ->id('bar-2')
                ->percent(30)
                ->barOptions([
                    'class' => 'bg-success',
                ]),
            Progress::widget()
                ->id('bar-3')
                ->percent(20)
                ->barOptions([
                    'class' => 'bg-info',
                ]),
        ];

        $html = ProgressStack::widget()
            ->id('test')
            ->bars(...$bars)
            ->render();
        $expected = <<<'HTML'
        <div id="test" class="progress-stacked"><div id="bar-1" class="progress" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;"><div class="progress-bar"></div></div><div id="bar-2" class="progress" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"><div class="bg-success progress-bar"></div></div><div id="bar-3" class="progress" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"><div class="bg-info progress-bar"></div></div></div>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEmptyBarsMultiple(): void
    {
        $this->assertEmpty(ProgressStack::widget()->render());
    }

    public static function stackOptionsProvider(): array
    {
        return [
            [
                ['class' => 'w-75'],
                'class="w-75 progress-stacked"',
            ],
            [
                ['style' => ['width' => '50%']],
                'class="progress-stacked" style="width: 50%;"',
            ],
        ];
    }

    /**
     * @dataProvider stackOptionsProvider
     * @param array $options
     * @param string $expected
     * @return void
     */
    public function testBarsMultipleOptions(array $options, string $expected): void
    {
        $bars = [
            Progress::widget()
                ->id('bar-1')
                ->percent(15),
            Progress::widget()
                ->id('bar-2')
                ->percent(30)
                ->barOptions([
                    'class' => 'bg-success',
                ]),
            Progress::widget()
                ->id('bar-3')
                ->percent(20)
                ->barOptions([
                    'class' => 'bg-info',
                ]),
        ];

        $widget = ProgressStack::widget()
            ->bars(...$bars)
            ->options($options);

        $this->assertStringContainsString($expected, $widget->render());
    }
}
