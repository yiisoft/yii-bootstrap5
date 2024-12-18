<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\NavLink;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `DropdownItem`.
 *
 * @group nav
 */
final class NavLinkTest extends \PHPUnit\Framework\TestCase
{
    public function testItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
            </li>
            HTML,
            NavLink::item('Link', '#')->getContent()->render(),
        );
    }

    public function testItemWithActive(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li class="nav-item">
            <a class="nav-link active" href="#" aria-current="page">Active</a>
            </li>
            HTML,
            NavLink::item('Active', '#', active: true)->getContent()->render(),
        );
    }

    public function testItemWithActiveAndDisabled(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The nav item cannot be active and disabled at the same time.');

        NavLink::item('Active and Disabled', '#', active: true, disabled: true);
    }

    public function testItemWithAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li class="nav-item test-class">
            <a class="nav-link" href="#">Link</a>
            </li>
            HTML,
            NavLink::item('Link', '#', attributes: ['class' => 'test-class'])->getContent()->render(),
        );
    }

    public function testItemWithDisabled(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li class="nav-item">
            <a class="nav-link disabled" href="#" aria-disabled="true">Disabled</a>
            </li>
            HTML,
            NavLink::item('Disabled', '#', disabled: true)->getContent()->render(),
        );
    }

    public function testItemWitkLinkAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <li class="nav-item">
            <a class="nav-link" href="#" target="_blank">Link</a>
            </li>
            HTML,
            NavLink::item('Link', '#', linkAttributes: ['target' => '_blank'])->getContent()->render(),
        );
    }

    public function testTo(): void
    {
        $this->assertSame(
            '<a class="nav-link" href="/test">Link</a>',
            NavLink::to('Link', '/test')->getContent()->render(),
        );
    }

    public function testToWithActive(): void
    {
        $this->assertSame(
            '<a class="nav-link active" href="/test" aria-current="page">Active</a>',
            NavLink::to('Active', '/test', active: true)->getContent()->render(),
        );
    }

    public function testToWithActiveAndDisabled(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The nav link cannot be active and disabled at the same time.');

        NavLink::to('Active and Disabled', '/test', active: true, disabled: true);
    }

    public function testToWithAttributes(): void
    {
        $this->assertSame(
            '<a class="nav-link test-class" href="/test">Link</a>',
            NavLink::to('Link', '/test', attributes: ['class' => 'test-class'])->getContent()->render(),
        );
    }

    public function testToWithDisabled(): void
    {
        $this->assertSame(
            '<a class="nav-link disabled" href="/test" aria-disabled="true">Disabled</a>',
            NavLink::to('Disabled', '/test', disabled: true)->getContent()->render(),
        );
    }
}
