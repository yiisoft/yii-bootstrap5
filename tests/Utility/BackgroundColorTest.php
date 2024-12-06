<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

/**
 * Tests for `BackgroundColor` enum.
 *
 * @group utility
 */
final class BackgroundColorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\BackgroundColorProvider::variant()
     */
    public function testBackgroundColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
