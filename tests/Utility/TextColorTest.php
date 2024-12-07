<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;

/**
 * Tests for `TextColor` enum.
 *
 * @group utility
 */
final class TextColorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\TextColorProvider::variant()
     */
    public function testTextColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
