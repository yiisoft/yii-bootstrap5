<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Yii\Bootstrap5\Breadcrumbs;

/**
 * Tests for Breadcrumbs widget
 *
 * BreadcrumbsTest
 */
final class BreadcrumbsTest extends TestCase
{
    public function testRender(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->homeLink(['label' => 'Home', 'url' => '#'])
            ->links([
                ['label' => 'Library', 'url' => '#', 'template' => "<span class=\"testMe\">{link}</span>\n"],
                ['label' => 'Data'],
                'Articles',
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="#">Home</a></li>
        <span class="testMe"><a href="#">Library</a></span>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Articles</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLinks(): void
    {
        $html = Breadcrumbs::widget()->links([])->render();
        $this->assertEmpty($html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(RuntimeException::class);
        Breadcrumbs::widget()->links([['url' => '#']])->render();
    }

    public function testActiveItemTemplate(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->activeItemTemplate("<li class=\"breadcrumb-link active\" aria-current=\"page\">{link}</li>\n")
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-link active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->links([
                ['label' => '<span><i class=fas fa-home></i>Home</span>', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">&lt;span&gt;&lt;i class=fas fa-home&gt;&lt;/i&gt;Home&lt;/span&gt;</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Breadcrumbs::widget()
            ->withoutEncodeLabels()
            ->links([
                ['label' => '<span><i class=fas fa-home></i>Home</span>', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w1-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#"><span><i class=fas fa-home></i>Home</span></a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testItemTemplate(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->itemTemplate("<li class=\"breadcrumb-links\">{link}</li>\n")
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-links"><a href="/">Home</a></li>
        <li class="breadcrumb-links"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testNavOptions(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->navOptions(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <nav class="testMe"><ol id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->options(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="testMe breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTag(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->tag('footer')
            ->links([
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data'],
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><footer id="w0-breadcrumb" class="breadcrumb"><li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        </footer></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHomeLinkDisabled(): void
    {
        Breadcrumbs::counter(0);

        $html = Breadcrumbs::widget()
            ->homeLink([])
            ->links([
                ['label' => 'Library', 'url' => '#', 'template' => "<span class=\"testMe\">{link}</span>\n"],
                ['label' => 'Data'],
                'Articles',
            ])
            ->render();
        $expected = <<<'HTML'
        <nav aria-label="breadcrumb"><ol id="w0-breadcrumb" class="breadcrumb"><span class="testMe"><a href="#">Library</a></span>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Articles</li>
        </ol></nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
