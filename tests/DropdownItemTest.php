<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Bootstrap5\DropdownItem;

/**
 * Tests for `DropdownItem`.
 *
 * @group dropdown
 */
#[Group('dropdown')]
final class DropdownItemTest extends TestCase
{
    public function testImmutability(): void
    {
        $dropdownItem = DropdownItem::text('Test');

        $this->assertNotSame($dropdownItem, $dropdownItem->active(false));
        $this->assertNotSame($dropdownItem, $dropdownItem->attributes([]));
        $this->assertNotSame($dropdownItem, $dropdownItem->content(''));
        $this->assertNotSame($dropdownItem, $dropdownItem->disabled(false));
        $this->assertNotSame($dropdownItem, $dropdownItem->headerTag('h1'));
        $this->assertNotSame($dropdownItem, $dropdownItem->itemAttributes([]));
        $this->assertNotSame($dropdownItem, $dropdownItem->type(DropdownItem::TYPE_BUTTON));
        $this->assertNotSame($dropdownItem, $dropdownItem->url(''));
    }

    public function testText(): void
    {
        $text = DropdownItem::text('content');

        $this->assertSame('text', $text->getType());
        $this->assertSame('content', $text->getContent());
        $this->assertFalse($text->isActive());
        $this->assertFalse($text->isDisabled());
        $this->assertSame([], $text->getAttributes());
        $this->assertSame([], $text->getItemAttributes());
        $this->assertSame('h6', $text->getHeaderTag());
    }
}
