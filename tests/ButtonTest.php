<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Button;

/**
 * Tests for `Button` widget
 */
final class ButtonTest extends TestCase
{
    public function testRender(): void
    {
        $html = Button::widget()
            ->id('test')
            ->label('Save')
            ->render();
        $expected = <<<'HTML'
        <button id="test" class="btn">Save</button>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $html = Button::widget()
            ->id('test')
            ->label('<span><i class=fas fas-save></i>Save</span>')
            ->render();
        $expected = <<<'HTML'
        <button id="test" class="btn">&lt;span&gt;&lt;i class=fas fas-save&gt;&lt;/i&gt;Save&lt;/span&gt;</button>
        HTML;
        $this->assertSame($expected, $html);

        $html = Button::widget()
            ->id('test')
            ->label('<span><i class=fas fas-save></i>Save</span>')
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <button id="test" class="btn"><span><i class=fas fas-save></i>Save</span></button>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testOptions(): void
    {
        $html = Button::widget()
            ->id('test')
            ->label('Save')
            ->options(['class' => 'btn-lg'])
            ->render();
        $expected = <<<'HTML'
        <button id="test" class="btn-lg btn">Save</button>
        HTML;
        $this->assertSame($expected, $html);
    }

    public function testTagName(): void
    {
        $html = Button::widget()
            ->id('test')
            ->label('Save')
            ->tagName('articles')
            ->render();
        $expected = <<<'HTML'
        <articles id="test" class="btn">Save</articles>
        HTML;
        $this->assertSame($expected, $html);
    }
}
