<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Button;

/**
 * Tests for Button widget
 *
 * AlertTest.
 */
final class ButtonTest extends TestCase
{
    public function testRender(): void
    {
        Button::counter(0);

        $html = Button::widget()->withLabel('Save')->render();
        $expectedHtml = <<<HTML
<button id="w0-button" class="btn">Save</button>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);
    }

    public function testEncodeLabels(): void
    {
        Button::counter(0);

        $html = Button::widget()
            ->withLabel('<span><i class=fas fas-save></i>Save</span>')
            ->render();
        $expectedHtml = <<<HTML
<button id="w0-button" class="btn">&lt;span&gt;&lt;i class=fas fas-save&gt;&lt;/i&gt;Save&lt;/span&gt;</button>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);

        $html = Button::widget()
            ->withLabel('<span><i class=fas fas-save></i>Save</span>')
            ->withoutEncodeLabels()
            ->render();
        $expectedHtml = <<<HTML
<button id="w1-button" class="btn"><span><i class=fas fas-save></i>Save</span></button>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);
    }

    public function testOptions(): void
    {
        Button::counter(0);

        $html = Button::widget()->withLabel('Save')->withOptions(['class' => 'btn-lg'])->render();
        $expectedHtml = <<<HTML
<button id="w0-button" class="btn-lg btn">Save</button>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);
    }

    public function testTagName(): void
    {
        Button::counter(0);

        $html = Button::widget()->withLabel('Save')->withTagName('articles')->render();
        $expectedHtml = <<<HTML
<articles id="w0-button" class="btn">Save</articles>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);
    }

    public function testEncodeTags(): void
    {
        Button::counter(0);

        $html = Button::widget()->withLabel('Save')->withEncodeTags()->render();
        $expectedHtml = <<<HTML
<button id="w0-button" class="btn">Save</button>
HTML;
        $this->assertEqualsWithoutLE($expectedHtml, $html);
    }
}
