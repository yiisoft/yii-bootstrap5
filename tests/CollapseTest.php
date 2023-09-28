<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Collapse;

final class CollapseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Collapse::counter(0);
    }

    public function testSimpleCollapse(): void
    {
        $html = Collapse::widget()
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
<div id="w0-collapse" class="collapse">
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
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'tag' => 'a',
            ])
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<a href="#w0-collapse" data-bs-toggle="collapse" aria-controls="w0-collapse" role="button" aria-expanded="false">Toggle</a>
<div id="w0-collapse" class="collapse">
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
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->withHorizontal(true)
            ->withContent('Collapse content')
            ->render();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
<div id="w0-collapse" class="collapse collapse-horizontal">
<div class="card card-body">
Collapse content
</div>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testSeparateSwitcher(): void
    {
        Collapse::counter(0);

        $collapse = Collapse::widget()
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
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
</p>
<div id="w0-collapse" class="collapse collapse-horizontal">
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
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
<div id="w0-collapse" class="collapse">
Collapse content
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testOuterContent(): void
    {
        $html = Collapse::widget()
            ->withToggleLabel('Toggle')
            ->withToggleOptions([
                'class' => 'btn btn-primary',
            ])
            ->begin();
        $html .= 'Very very very looooong content';
        $html .= Collapse::end();

        $expected = <<<'HTML'
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
<div id="w0-collapse" class="collapse">
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
<button type="button" class="btn btn-primary" data-bs-toggle="collapse" aria-controls="w0-collapse" data-bs-target="#w0-collapse" aria-expanded="false">Toggle</button>
<div id="w0-collapse" class="collapse">
<article class="card card-body">
Collapse content
</article>
</div>
HTML;

        $this->assertEqualsHTML($expected, $html);
    }
}
