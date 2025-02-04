<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use PHPUnit\Framework\TestCase;
use BackedEnum;

/**
 * Tests for `TextColor` enum.
 *
 * @group utility
 */
final class TextColorTest extends TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\TextColorProvider::variant()
     */
    public function testTextColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
