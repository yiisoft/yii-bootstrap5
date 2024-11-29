<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `DropdownItem`.
 *
 * @group dropdown
 */
final class DropdownItemTest extends \PHPUnit\Framework\TestCase
{
    public function testDivider(): void
    {
        $divider = DropdownItem::divider();

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <hr class="dropdown-divider">
            </li>
            HTML,
            $divider->getContent()->render(),
        );
    }

    public function testDividerWithAttributes(): void
    {
        $divider = DropdownItem::divider(['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li class="test-class">
            <hr class="dropdown-divider">
            </li>
            HTML,
            $divider->getContent()->render(),
        );
    }

    public function testDividerWithDividerAttributes(): void
    {
        $divider = DropdownItem::divider(dividerAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <hr class="dropdown-divider test-class">
            </li>
            HTML,
            $divider->getContent()->render(),
        );
    }

    public function testGetContentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Dropdown item must be initialized before use, use one of the static methods to initialize it.'
        );

        $dropdownItem = new DropdownItem();
        $dropdownItem->getContent();
    }

    public function testHeader(): void
    {
        $header = DropdownItem::header('content');

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <h6 class="dropdown-header">content</h6>
            </li>
            HTML,
            $header->getContent()->render(),
        );
    }

    public function testHeaderWithAttributes(): void
    {
        $header = DropdownItem::header('content', ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li class="test-class">
            <h6 class="dropdown-header">content</h6>
            </li>
            HTML,
            $header->getContent()->render(),
        );
    }

    public function testHeaderWithHeaderTag(): void
    {
        $header = DropdownItem::header('content', headerTag: 'h5');

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <h5 class="dropdown-header">content</h5>
            </li>
            HTML,
            $header->getContent()->render(),
        );
    }

    public function testHeaderWithHeaderTagEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The header tag cannot be empty.');

        DropdownItem::header('content', headerTag: '');
    }

    public function testHeaderWithHeaderAttributes(): void
    {
        $header = DropdownItem::header('content', headerAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <h6 class="dropdown-header test-class">content</h6>
            </li>
            HTML,
            $header->getContent()->render(),
        );
    }

    public function testLink(): void
    {
        $link = DropdownItem::link('label', 'url');

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item" href="url">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithActive(): void
    {
        $link = DropdownItem::link('label', 'url', active: true);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item active" href="url" aria-current="true">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithDisabled(): void
    {
        $link = DropdownItem::link('label', 'url', disabled: true);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item disabled" href="url" aria-disabled="true">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithAttributes(): void
    {
        $link = DropdownItem::link('label', 'url', attributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li class="test-class">
            <a class="dropdown-item" href="url">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithLinkAttributes(): void
    {
        $link = DropdownItem::link('label', 'url', linkAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item test-class" href="url">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithLinkAttributesAndActive(): void
    {
        $link = DropdownItem::link('label', 'url', active: true, linkAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item active test-class" href="url" aria-current="true">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithLinkAttributesAndDisabled(): void
    {
        $link = DropdownItem::link('label', 'url', disabled: true, linkAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <a class="dropdown-item disabled test-class" href="url" aria-disabled="true">label</a>
            </li>
            HTML,
            $link->getContent()->render(),
        );
    }

    public function testLinkWithActiveAndDisabled(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The dropdown item cannot be active and disabled at the same time.');

        DropdownItem::link('label', 'url', active: true, disabled: true);
    }

    public function testText(): void
    {
        $text = DropdownItem::text('content');

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <span class="dropdown-item-text">content</span>
            </li>
            HTML,
            $text->getContent()->render(),
        );
    }

    public function testTextWithAttributes(): void
    {
        $text = DropdownItem::text('content', ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li class="test-class">
            <span class="dropdown-item-text">content</span>
            </li>
            HTML,
            $text->getContent()->render(),
        );
    }

    public function testTextWithTextAttributes(): void
    {
        $text = DropdownItem::text('content', textAttributes: ['class' => 'test-class']);

        Assert::equalsWithoutLE(
            <<<HTML
            <li>
            <span class="dropdown-item-text test-class">content</span>
            </li>
            HTML,
            $text->getContent()->render(),
        );
    }
}
