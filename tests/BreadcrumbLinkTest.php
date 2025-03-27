<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Bootstrap5\BreadcrumbLink;

/**
 * Tests for `Link`.
 */
#[Group('breadcrumb')]
final class BreadcrumbLinkTest extends TestCase
{
    public function testGetAttributes(): void
    {
        $link = BreadcrumbLink::to('label', 'url', attributes: ['class' => 'test']);

        $this->assertSame(['class' => 'test'], $link->getAttributes());
    }

    public function testGetLabel(): void
    {
        $label = BreadcrumbLink::to('<strong>label</strong>', 'url');

        $this->assertSame('&lt;strong&gt;label&lt;/strong&gt;', $label->getLabel());
    }

    public function testGetLabelEncodeWithFalse(): void
    {
        $label = BreadcrumbLink::to('<strong>label</strong>', 'url', encodeLabel: false);

        $this->assertSame('<strong>label</strong>', $label->getLabel());
    }

    public function testGetUrl(): void
    {
        $url = BreadcrumbLink::to('label', 'url');

        $this->assertSame('url', $url->getUrl());
    }

    public function testIsActive(): void
    {
        $active = BreadcrumbLink::to('label', 'url', active: true);

        $this->assertTrue($active->isActive());
    }

    public function testImmutability(): void
    {
        $link = BreadcrumbLink::to('');

        $this->assertNotSame($link, $link->active(false));
        $this->assertNotSame($link, $link->attributes([]));
        $this->assertNotSame($link, $link->encodeLabel(false));
        $this->assertNotSame($link, $link->label(''));
        $this->assertNotSame($link, $link->url(''));
    }
}
