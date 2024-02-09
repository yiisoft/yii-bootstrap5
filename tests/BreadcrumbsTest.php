<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Breadcrumbs;

/**
 * Tests for `Breadcrumbs` widget
 */
final class BreadcrumbsTest extends TestCase
{
    public function testRender(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->homeLink(['label' => 'Home', 'url' => '#'])
            ->links([
                ['label' => 'Library', 'url' => '#', 'template' => "<span class=\"testMe\">{link}</span>\n"],
                ['label' => 'Data'],
                'Articles',
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="#">Home</a></li>
        <span class="testMe"><a href="#">Library</a></span>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Articles</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testMissingLinks(): void
    {
        $html = Breadcrumbs::widget()
            ->links([])
            ->render();
        $this->assertEmpty($html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(RuntimeException::class);
        Breadcrumbs::widget()
            ->links([['url' => '#']])
            ->render();
    }

    public function testActiveItemTemplate(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->activeItemTemplate("<li class=\"breadcrumb-link active\" aria-current=\"page\">{link}</li>\n")
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-link active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->links([
                ['label' => '<span><i class=fas fa-home></i>Home</span>', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">&lt;span&gt;&lt;i class=fas fa-home&gt;&lt;/i&gt;Home&lt;/span&gt;</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);

        $html = Breadcrumbs::widget()
            ->id('test')
            ->withoutEncodeLabels()
            ->links([
                ['label' => '<span><i class=fas fa-home></i>Home</span>', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#"><span><i class=fas fa-home></i>Home</span></a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testItemTemplate(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->itemTemplate("<li class=\"breadcrumb-links\">{link}</li>\n")
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-links"><a href="/">Home</a></li>
        <li class="breadcrumb-links"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testNavOptions(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->navOptions(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <nav class="testMe"><ol id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testOptions(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->options(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="testMe breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testTag(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->tag('footer')
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><footer id="test-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </footer></nav>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testHomeLinkDisabled(): void
    {
        $html = Breadcrumbs::widget()
            ->id('test')
            ->homeLink([])
            ->links([
                ['label' => 'Library', 'url' => '#', 'template' => "<span class=\"testMe\">{link}</span>\n"],
                ['label' => 'Data'],
                'Articles',
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="test-breadcrumb" class="breadcrumb"><span class="testMe"><a href="#">Library</a></span>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Articles</li>
        </ol></nav>
        HTML;
        $this->assertSame($expected, $html);
    }
}
