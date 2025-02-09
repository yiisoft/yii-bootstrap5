<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
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
    }

    public function testButtonWithAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::button('content', attributes: ['class' => 'test-class'])->getAttributes(),
        );
    }

    public function testButtonWithItemAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::button('content', itemAttributes: ['class' => 'test-class'])->getItemAttributes(),
        );
    }

    public function testDivider(): void
    {
        $this->assertSame('divider', DropdownItem::divider()->getType());
    }

    public function testDividerWithAttributes(): void
    {
        $this->assertSame(['class' => 'test-class'], DropdownItem::divider(['class' => 'test-class'])->getAttributes());
    }

    public function testDividerWithItemAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::divider(itemAttributes: ['class' => 'test-class'])->getItemAttributes(),
        );
    }

    public function testHeader(): void
    {
        $dropdownItem = DropdownItem::header('content');

        $this->assertSame('header', $dropdownItem->getType());
        $this->assertSame('content', $dropdownItem->getContent());
    }

    public function testHeaderWithAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::header('content', attributes: ['class' => 'test-class'])->getAttributes(),
        );
    }

    public function testHeaderWithHeaderTag(): void
    {
        $this->assertSame('h6', DropdownItem::header('content', headerTag: 'h6')->getHeaderTag());
    }

    public function testHeaderWithItemAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::header('content', itemAttributes: ['class' => 'test-class'])->getItemAttributes(),
        );
    }

    public function testLink(): void
    {
        $link = DropdownItem::link('label', 'url');

        $this->assertSame('link', $link->getType());
        $this->assertSame('label', $link->getContent());
        $this->assertSame('url', $link->getUrl());
    }

    public function testLinkWithActive(): void
    {
        $this->assertTrue(DropdownItem::link('label', 'url', active: true)->isActive());
    }

    public function testLinkWithAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::link('label', 'url', attributes: ['class' => 'test-class'])->getAttributes(),
        );
    }

    public function testLinkWithDisabled(): void
    {
        $this->assertTrue(DropdownItem::link('label', 'url', disabled: true)->isDisabled());
    }

    public function testLinkWithItemAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::link('label', 'url', itemAttributes: ['class' => 'test-class'])->getItemAttributes(),
        );
    }

    public function testListContent(): void
    {
        $listContent = DropdownItem::listContent('content');

        $this->assertSame('custom-content', $listContent->getType());
        $this->assertSame('content', $listContent->getContent());
    }

    public function testListContentWithAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::listContent('content', attributes: ['class' => 'test-class'])->getAttributes(),
        );
    }

    public function testText(): void
    {
        $text = DropdownItem::text('content');

        $this->assertSame('text', $text->getType());
        $this->assertSame('content', $text->getContent());
    }

    public function testTextWithAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::text('content', attributes: ['class' => 'test-class'])->getAttributes(),
        );
    }

    public function testTextWithItemAttributes(): void
    {
        $this->assertSame(
            ['class' => 'test-class'],
            DropdownItem::text('content', itemAttributes: ['class' => 'test-class'])->getItemAttributes(),
        );
    }

    public function testThrowExceptionForHeaderWithTagEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The header tag cannot be empty.');

        DropdownItem::header('content', headerTag: '');
    }

    public function testThrowExceptionForLinkWithActiveAndDisabled(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        DropdownItem::link('label', 'url', active: true, disabled: true);
    }
}
