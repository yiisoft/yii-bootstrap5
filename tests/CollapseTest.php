<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Collapse;

final class CollapseTest extends TestCase
{
    public function testSimpleCollapse(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
<div id="TEST_ID" class="collapse">
<div class="card card-body">
Collapse content
</div>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testLinkCollapse(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'tag' => 'a',
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<a href="#TEST_ID" data-bs-toggle="collapse" aria-controls="TEST_ID" role="button" aria-expanded="false">Toggle</a>
<div id="TEST_ID" class="collapse">
<div class="card card-body">
Collapse content
</div>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testHorizontalCollapse(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withHorizontal(true)
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
<div id="TEST_ID" class="collapse collapse-horizontal">
<div class="card card-body">
Collapse content
</div>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testSeparateSwitcher(): void
    {
        $collapse = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withToggle(false)
            ->withHorizontal(true)
            ->withContent('Collapse content');

        $html = '<p>' . $collapse->renderToggle() . '</p>' . $collapse->render();

        $expected = <<<'HTML'
<p>
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
</p>
<div id="TEST_ID" class="collapse collapse-horizontal">
<div class="card card-body">
Collapse content
</div>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testWithoutBody(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withBodyOptions([
                'tag' => null,
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
<div id="TEST_ID" class="collapse">
Collapse content
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOuterContent(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->begin();
        $html .= 'Very very very looooong content';
        $html .= Collapse::end();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
<div id="TEST_ID" class="collapse">
<div class="card card-body">
Very very very looooong content
</div>
</div>
HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBodyTag(): void
    {
        $html = Collapse::widget()
            ->id('TEST_ID')
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withBodyOptions([
                'tag' => 'article',
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="TEST_ID" data-bs-target="#TEST_ID" aria-expanded="false">Toggle</button>
<div id="TEST_ID" class="collapse">
<article class="card card-body">
Collapse content
</article>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
