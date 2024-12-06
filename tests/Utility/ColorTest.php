<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;

/**
 * Tests for `ColorText` enum.
 *
 * @group utility
 */
final class ColorTextTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\ColorTextProvider::variant()
     */
    public function testBackgroundColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
