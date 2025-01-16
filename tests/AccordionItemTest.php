<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Bootstrap5\AccordionItem;

/**
 * Tests for `Accordion` widget
 *
 * @group accordion
 */
final class AccordionItemTest extends \PHPUnit\Framework\TestCase
{
    public function testEncodeBody(): void
    {
        $accordionItem = AccordionItem::to('header', '<strong>body</strong>');

        $this->assertSame('&lt;strong&gt;body&lt;/strong&gt;', $accordionItem->getBody());
    }

    public function testEncodeBodyWithFalse(): void
    {
        $accordionItem = AccordionItem::to('header', '<strong>body</strong>', encodeBody: false);

        $this->assertSame('<strong>body</strong>', $accordionItem->getBody());
    }

    public function testEncodeHeader(): void
    {
        $accordionItem = AccordionItem::to('<strong>header</strong>', 'body');

        $this->assertSame('&lt;strong&gt;header&lt;/strong&gt;', $accordionItem->getHeader());
    }

    public function testEncodeHeaderWithFalse(): void
    {
        $accordionItem = AccordionItem::to('<strong>header</strong>', 'body', encodeHeader: false);

        $this->assertSame('<strong>header</strong>', $accordionItem->getHeader());
    }

    public function testId(): void
    {
        $item = AccordionItem::to('header', 'body');

        $this->assertStringStartsWith('collapse-', $item->getId());
        $this->assertStringMatchesFormat('collapse-%x', $item->getId());
    }

    public function testIdWithEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        $accordionItem = AccordionItem::to('header', 'body', '');
        $accordionItem->getId();
    }

    public function testIdWithFalse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        $accordionItem = AccordionItem::to('header', 'body', false);
        $accordionItem->getId();
    }

    public function testIdWithValue(): void
    {
        $item = AccordionItem::to('header', 'body', 'custom-id');

        $this->assertSame('custom-id', $item->getId());
    }
}
