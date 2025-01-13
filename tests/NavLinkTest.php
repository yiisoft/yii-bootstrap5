<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Bootstrap5\NavLink;

/**
 * Tests for `DropdownItem`.
 *
 * @group nav
 */
final class NavLinkTest extends \PHPUnit\Framework\TestCase
{
    public function testImmutability(): void
    {
        $navLink = NavLink::to('Home', '/', true);

        $this->assertNotSame($navLink, $navLink->attributes([]));
        $this->assertNotSame($navLink, $navLink->urlAttributes([]));
    }

    public function testThrowExceptionwithActiveAndDisableTrueValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A nav link cannot be both active and disabled.');

        NavLink::to('Home', '/', true, true);
    }
}
