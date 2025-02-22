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
}
