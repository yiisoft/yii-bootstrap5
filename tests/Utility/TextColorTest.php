<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Utility;

use BackedEnum;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Bootstrap5\Tests\Provider\TextColorProvider;

/**
 * Tests for `TextColor` enum.
 *
 * @group utility
 */
#[Group('utility')]
final class TextColorTest extends TestCase
{
    #[DataProviderExternal(TextColorProvider::class, 'variant')]
    public function testTextColor(BackedEnum $value, string $expected): void
    {
        $this->assertSame($expected, $value->value);
    }
}
