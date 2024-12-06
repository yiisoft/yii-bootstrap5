<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;

/**
 * Tests for `TextBackgroundColor` enum.
 *
 * @group utility
 */
final class TextBackgroundColorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\TextBackgroundColorProvider::variant()
     */
    public function testTextColorBackground(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
