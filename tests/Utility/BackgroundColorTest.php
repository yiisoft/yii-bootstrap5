<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests\Utility;

use BackedEnum;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Bootstrap5\Tests\Provider\BackgroundColorProvider;

/**
 * Tests for `BackgroundColor` enum.
 */
#[Group('utility')]
final class BackgroundColorTest extends TestCase
{
    #[DataProviderExternal(BackgroundColorProvider::class, 'variant')]
    public function testBackgroundColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
