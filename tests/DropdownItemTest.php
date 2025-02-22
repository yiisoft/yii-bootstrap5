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
    public function testButton(): void
    {
        $button = DropdownItem::button('content');

        $this->assertSame('button', $button->getType());
        $this->assertSame('content', $button->getContent());
        $this->assertFalse($button->isActive());
        $this->assertFalse($button->isDisabled());
        $this->assertSame([], $button->getAttributes());
        $this->assertSame([], $button->getItemAttributes());
        $this->assertSame('h6', $button->getHeaderTag());
    }

    public function testDivider(): void
    {
        $divider = DropdownItem::divider();

        $this->assertSame('divider', $divider->getType());
        $this->assertSame('', $divider->getContent());
        $this->assertFalse($divider->isActive());
        $this->assertFalse($divider->isDisabled());
        $this->assertSame([], $divider->getAttributes());
        $this->assertSame([], $divider->getItemAttributes());
        $this->assertSame('h6', $divider->getHeaderTag());
    }

    public function testHeader(): void
    {
        $header = DropdownItem::header('content');

        $this->assertSame('header', $header->getType());
        $this->assertSame('content', $header->getContent());
        $this->assertFalse($header->isActive());
        $this->assertFalse($header->isDisabled());
        $this->assertSame([], $header->getAttributes());
        $this->assertSame([], $header->getItemAttributes());
        $this->assertSame('h6', $header->getHeaderTag());
    }

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

    public function testLink(): void
    {
        $link = DropdownItem::link('content');

        $this->assertSame('link', $link->getType());
        $this->assertSame('content', $link->getContent());
        $this->assertFalse($link->isActive());
        $this->assertFalse($link->isDisabled());
        $this->assertSame([], $link->getAttributes());
        $this->assertSame([], $link->getItemAttributes());
        $this->assertSame('h6', $link->getHeaderTag());
    }

    public function testListContent(): void
    {
        $listContent = DropdownItem::listContent('content');

        $this->assertSame('custom-content', $listContent->getType());
        $this->assertSame('content', $listContent->getContent());
        $this->assertFalse($listContent->isActive());
        $this->assertFalse($listContent->isDisabled());
        $this->assertSame([], $listContent->getAttributes());
        $this->assertSame([], $listContent->getItemAttributes());
        $this->assertSame('h6', $listContent->getHeaderTag());
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
