<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Yii\Bootstrap5\CollapseItem;

#[Group('collapse')]
final class CollapseItemTest extends TestCase
{
    public function testImmutability(): void
    {
        $collapseItem = CollapseItem::to();

        $this->assertNotSame($collapseItem, $collapseItem->ariaControls(''));
        $this->assertNotSame($collapseItem, $collapseItem->content(''));
        $this->assertNotSame($collapseItem, $collapseItem->encode(false));
        $this->assertNotSame($collapseItem, $collapseItem->id(''));
        $this->assertNotSame($collapseItem, $collapseItem->togglerAsLink(false));
        $this->assertNotSame($collapseItem, $collapseItem->togglerAttributes([]));
        $this->assertNotSame($collapseItem, $collapseItem->togglerContent(''));
        $this->assertNotSame($collapseItem, $collapseItem->togglerMultiple(false));
        $this->assertNotSame($collapseItem, $collapseItem->togglerTag(''));
    }
}
