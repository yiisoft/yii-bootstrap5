<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\BreadcrumbLink;
use Yiisoft\Yii\Bootstrap5\Breadcrumbs;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Breadcrumbs` widget
 *
 * @group breadcrumb
 */
final class BreadcrumbsTest extends \PHPUnit\Framework\TestCase
{
    public function testAriaLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="Basic example of breadcrumbs">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->ariaLabel('Basic example of breadcrumbs')
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="test-class" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->attributes(['class' => 'test-class'])
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testLabelWithEmpty(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "label" element is required for each link.');

        Breadcrumbs::widget()->links(new BreadcrumbLink())->render();
    }

    public function testListId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol id="test-id" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId('test-id')
                ->render(),
        );
    }

    public function testListIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId('')
                ->render(),
        );
    }

    public function testListIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testListIdWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol id="test-id" class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listAttributes(['id' => 'test-id'])
                ->render(),
        );
    }

    public function testListTagName(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <footer class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </footer>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '/'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId(false)
                ->listTagName('footer')
                ->render(),
        );
    }

    public function testLinksWithEmpty(): void
    {
        $this->assertEmpty(Breadcrumbs::widget()->render());
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/breadcrumb/#example
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new BreadcrumbLink('Home', '#'),
                    new BreadcrumbLink('Library', '#'),
                    new BreadcrumbLink('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }
}
