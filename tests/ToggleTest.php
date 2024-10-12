<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\{Toggle, ToggleType};
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Toggle` widget.
 *
 * @group toggle
 */
final class ToggleTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button class="btn-lg"></button>
            HTML,
            Toggle::widget()->attributes(['class' => 'btn-lg'])->render(),
        );
    }

    public function testDismissable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            HTML,
            Toggle::widget()->type(ToggleType::TYPE_DISMISS)->render(),
        );
    }

    public function testImmutability(): void
    {
        $toggle = Toggle::widget();

        $this->assertNotSame($toggle, $toggle->attributes([]));
        $this->assertNotSame($toggle, $toggle->link());
        $this->assertNotSame($toggle, $toggle->type(ToggleType::TYPE_DISMISS));
    }

    public function testLink(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <a></a>
            HTML,
            Toggle::widget()->link()->render(),
        );
    }
}
