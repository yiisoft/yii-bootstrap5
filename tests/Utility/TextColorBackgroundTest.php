<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;

/**
 * Tests for `TextColorBackground` enum.
 *
 * @group utility
 */
final class TextColorBackgroundTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider \Yiisoft\Yii\Bootstrap5\Tests\Provider\TextColorBackgroundProvider::variant()
     */
    public function testTextColorBackground(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
