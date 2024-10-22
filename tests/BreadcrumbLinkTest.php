<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\BreadcrumbLink;

/**
 * Tests for `BreadcrumbLink`.
 *
 * @group breadcrumblink
 */
final class BreadcrumbLinkTest extends \PHPUnit\Framework\TestCase
{
    public function testImmutability(): void
    {
        $breacrumbLink = new BreadcrumbLink();

        $this->assertNotSame($breacrumbLink, $breacrumbLink->addAttributes([]));
    }
}
