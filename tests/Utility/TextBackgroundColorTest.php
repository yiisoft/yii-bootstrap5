<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests\Utility;

use BackedEnum;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Bootstrap5\Tests\Provider\TextBackgroundColorProvider;

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
