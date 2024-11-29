<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Bootstrap5\Link;

/**
 * Tests for `Link`.
 *
 * @group breadcrumblink
 */
final class LinkTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAttributes(): void
    {
        $link = new Link('label', 'url', attributes: ['class' => 'test']);

        $this->assertSame(['class' => 'test'], $link->getAttributes());
    }

    public function testGetLabel(): void
    {
        $label = new Link('<strong>label</strong>', 'url');

        $this->assertSame('&lt;strong&gt;label&lt;/strong&gt;', $label->getLabel());
    }

    public function testGetLabelEncodeWithFalse(): void
    {
        $label = new Link('<strong>label</strong>', 'url', encodeLabel: false);

        $this->assertSame('<strong>label</strong>', $label->getLabel());
    }

    public function testGetUrl(): void
    {
        $url = new Link('label', 'url');

        $this->assertSame('url', $url->getUrl());
    }

    public function testIsActive(): void
    {
        $active = new Link('label', 'url', active: true);

        $this->assertTrue($active->isActive());
    }

    public function testIsDisabled(): void
    {
        $disabled = new Link('label', 'url', disabled: true);

        $this->assertTrue($disabled->isDisabled());
    }

    public function testIsActiveAndDisabled(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The link cannot be both active and disabled.');

        new Link('label', 'url', active: true, disabled: true);
    }
}
