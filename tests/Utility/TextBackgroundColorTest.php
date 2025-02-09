<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use PHPUnit\Framework\TestCase;
use BackedEnum;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Group;
use Yiisoft\Yii\Bootstrap5\Tests\Provider\TextBackgroundColorProvider;

/**
 * Tests for `TextBackgroundColor` enum.
 */
#[Group('utility')]
final class TextBackgroundColorTest extends TestCase
{
    #[DataProviderExternal(TextBackgroundColorProvider::class, 'variant')]
    public function testTextColorBackground(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
