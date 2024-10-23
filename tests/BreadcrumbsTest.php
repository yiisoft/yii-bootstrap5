<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Link;
use Yiisoft\Yii\Bootstrap5\Breadcrumbs;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Breadcrumbs` widget
 *
 * @group breadcrumb
 */
final class BreadcrumbsTest extends \PHPUnit\Framework\TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav class="test-class-definition" data-test="test" aria-label="Basic example of breadcrumbs">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget(config: ['attributes()' => [['class' => 'test-class-definition']]])
                ->addAttributes(['data-test' => 'test'])
                ->ariaLabel('Basic example of breadcrumbs')
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.2/components/breadcrumb/#dividers
     */
    public function testDivider(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav style="--bs-breadcrumb-divider: &apos;&gt;&apos;;" aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->divider('>')
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testDividerWithEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "divider" cannot be empty.');

        Breadcrumbs::widget()->divider('');
    }

    public function testImmutability(): void
    {
        $breacrumb = Breadcrumbs::widget();

        $this->assertNotSame($breacrumb, $breacrumb->addAttributes([]));
        $this->assertNotSame($breacrumb, $breacrumb->ariaLabel(''));
        $this->assertNotSame($breacrumb, $breacrumb->attributes([]));
        $this->assertNotSame($breacrumb, $breacrumb->divider('>'));
        $this->assertNotSame($breacrumb, $breacrumb->itemActiveClass(''));
        $this->assertNotSame($breacrumb, $breacrumb->itemAttributes([]));
        $this->assertNotSame($breacrumb, $breacrumb->linkAttributes([]));
        $this->assertNotSame($breacrumb, $breacrumb->links(new Link()));
        $this->assertNotSame($breacrumb, $breacrumb->listAttributes([]));
        $this->assertNotSame($breacrumb, $breacrumb->listId(''));
        $this->assertNotSame($breacrumb, $breacrumb->listTagName(''));
    }

    public function testItemActiveClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item test-active-class" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->itemActiveClass('test-active-class')
                ->listId(false)
                ->render(),
        );
    }

    public function testItemAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item test-item-class"><a href="/">Home</a></li>
            <li class="breadcrumb-item test-item-class"><a href="#">Library</a></li>
            <li class="breadcrumb-item test-item-class active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->itemAttributes(['class' => 'test-item-class'])
                ->listId(false)
                ->render(),
        );
    }

    public function testLabelWithEmpty(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "label" element is required for each link.');

        Breadcrumbs::widget()->links(new Link())->render();
    }

    public function testLinkAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="test-link-class" href="/">Home</a></li>
            <li class="breadcrumb-item"><a class="test-link-class" href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->linkAttributes(['class' => 'test-link-class'])
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testLinksWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="test-link-class" href="/" data-test="test">Home</a></li>
            <li class="breadcrumb-item"><a class="test-link-class" href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->linkAttributes(['class' => 'test-link-class'])
                ->links(
                    (new Link('Home', '/'))->addAttributes(['data-test' => 'test']),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }

    public function testListAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb test-list-class">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
            </nav>
            HTML,
            Breadcrumbs::widget()
                ->links(
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listAttributes(['class' => 'test-list-class'])
                ->listId(false)
                ->render(),
        );
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
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
                    new Link('Home', '/'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->listTagName('footer')
                ->render(),
        );
    }

    public function testListTagNameWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('List tag cannot be empty.');

        Breadcrumbs::widget()
            ->links(
                new Link('Home', '/'),
                new Link('Library', '#'),
                new Link('Data'),
            )
            ->listTagName('')
            ->render();
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
                    new Link('Home', '#'),
                    new Link('Library', '#'),
                    new Link('Data'),
                )
                ->listId(false)
                ->render(),
        );
    }
}
