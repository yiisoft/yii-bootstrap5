<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Link;

/**
 * Tests for `Link`.
 *
 * @group breadcrumblink
 */
final class LinkTest extends \PHPUnit\Framework\TestCase
{
    public function testImmutability(): void
    {
        $breacrumbLink = new Link();

        $this->assertNotSame($breacrumbLink, $breacrumbLink->attributes([]));
    }
}
