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

        $html = Button::widget()
            ->label('Save')
            ->render();
        $expected = <<<'HTML'
        <button id="w0-button" class="btn">Save</button>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        Button::counter(0);

        $html = Button::widget()
            ->label('<span><i class=fas fas-save></i>Save</span>')
            ->render();
        $expected = <<<'HTML'
        <button id="w0-button" class="btn">&lt;span&gt;&lt;i class=fas fas-save&gt;&lt;/i&gt;Save&lt;/span&gt;</button>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Button::widget()
            ->label('<span><i class=fas fas-save></i>Save</span>')
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <button id="w1-button" class="btn"><span><i class=fas fas-save></i>Save</span></button>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testOptions(): void
    {
        Button::counter(0);

        $html = Button::widget()
            ->label('Save')
            ->options(['class' => 'btn-lg'])
            ->render();
        $expected = <<<'HTML'
        <button id="w0-button" class="btn-lg btn">Save</button>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTagName(): void
    {
        Button::counter(0);

        $html = Button::widget()
            ->label('Save')
            ->tagName('articles')
            ->render();
        $expected = <<<'HTML'
        <articles id="w0-button" class="btn">Save</articles>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
