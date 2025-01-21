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

    public function testIdWithValue(): void
    {
        $item = AccordionItem::to('header', 'body', 'custom-id');

        $this->assertSame('custom-id', $item->getId());
    }

    public function testImmutability(): void
    {
        $item = AccordionItem::to();

        $this->assertNotSame($item, $item->active(false));
        $this->assertNotSame($item, $item->body(''));
        $this->assertNotSame($item, $item->encodeBody(false));
        $this->assertNotSame($item, $item->encodeHeader(false));
        $this->assertNotSame($item, $item->id('custom-id'));
        $this->assertNotSame($item, $item->header(''));
    }

    public function testThrowExceptionForIdWithEmptyConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        AccordionItem::to('header', 'body', '')->getId();
    }

    public function testThrowExceptionForIdWithFalseConstructor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        AccordionItem::to('header', 'body', false)->getId();
    }

    public function testThrowExceptionForIdWithEmptyMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        AccordionItem::to('header', 'body')->id('');
    }

    public function testThrowExceptionForIdWithFalseMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        AccordionItem::to('header', 'body')->id(false);
    }
}
