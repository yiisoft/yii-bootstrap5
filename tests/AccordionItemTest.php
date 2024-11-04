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
    public function testId(): void
    {
        $item = new AccordionItem('header', 'body');

        $this->assertStringStartsWith('collapse-', $item->getId());
        $this->assertStringMatchesFormat('collapse-%x', $item->getId());
    }

    public function testIdWithEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        $accordionItem = new AccordionItem('header', 'body', '');
        $accordionItem->getId();
    }

    public function testIdWithFalse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`.');

        $accordionItem = new AccordionItem('header', 'body', false);
        $accordionItem->getId();
    }

    public function testIdWithValue(): void
    {
        $item = new AccordionItem('header', 'body', 'custom-id');

        $this->assertSame('custom-id', $item->getId());
    }
}
