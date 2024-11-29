<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Bootstrap5\DropdownItem;

/**
 * Tests for `DropdownItem`.
 *
 * @group dropdown
 */
final class DropdownItemTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAttributes(): void
    {
        $dropdownItem = new DropdownItem('label', 'url', attributes: ['class' => 'test']);

        $this->assertSame(['class' => 'test'], $dropdownItem->getAttributes());
    }

    public function testGetLabel(): void
    {
        $dropdownItem = new DropdownItem('<strong>label</strong>', 'url');

        $this->assertSame('&lt;strong&gt;label&lt;/strong&gt;', $dropdownItem->getLabel());
    }

    public function testGetLabelEncodeWithFalse(): void
    {
        $dropdownItem = new DropdownItem('<strong>label</strong>', 'url', encodeLabel: false);

        $this->assertSame('<strong>label</strong>', $dropdownItem->getLabel());
    }

    public function testGetUrl(): void
    {
        $dropdownItem = new DropdownItem('label', 'url');

        $this->assertSame('url', $dropdownItem->getUrl());
    }

    public function testIsActive(): void
    {
        $dropdownItem = new DropdownItem('label', 'url', active: true);

        $this->assertTrue($dropdownItem->isActive());
    }

    public function testIsDisabled(): void
    {
        $dropdownItem = new DropdownItem('label', 'url', disabled: true);

        $this->assertTrue($dropdownItem->isDisabled());
    }

    public function testIsActiveAndDisabled(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        new DropdownItem('label', 'url', active: true, disabled: true);
    }

    public function testIsDividerAndText(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be a divider and text at the same time.');

        new DropdownItem('label', 'url', divider: true, text: true);
    }
}
