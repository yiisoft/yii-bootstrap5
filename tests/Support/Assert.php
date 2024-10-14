<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Support;

use function str_replace;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class Assert
{
    /**
     * Asserting two strings equality ignoring line endings.
     *
     * @param string $expected The expected string.
     * @param string $actual The actual string.
     * @param string $message The message to display if the assertion fails.
     */
    public static function equalsWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        \PHPUnit\Framework\Assert::assertEquals($expected, $actual, $message);
    }
}
