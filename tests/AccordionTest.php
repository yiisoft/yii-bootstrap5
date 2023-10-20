<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Html\Tag\B;
use Yiisoft\Yii\Bootstrap5\Accordion;

/**
 * Tests for Accordion widget
 *
 * AccordionTest
 */
final class AccordionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Accordion::counter(0);
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/accordion/#example
     */
    public function testRender(): void
    {
        $html = Accordion::widget()
            ->items([
                [
                    'label' => 'Accordion Item #1',
                    'content' => [
                        'This is the first items accordion body. It is shown by default, until the collapse plugin ' .
                        'the appropriate classes that we use to style each element. These classes control the ' .
                        'overall appearance, as well as the showing and hiding via CSS transitions. You can  ' .
                        'modify any of this with custom CSS or overriding our default variables. Its also worth ' .
                        'noting that just about any HTML can go within the .accordion-body, though the transition ' .
                        'does limit overflow.',
                    ],
                ],
                [
                    'label' => 'Accordion Item #2',
                    'content' => '<strong>This is the second items accordion body.</strong> It is hidden by default, ' .
                        'until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                        'These classes control the overall appearance, as well as the showing and hiding via CSS ' .
                        'transitions. You can modify any of this with custom CSS or overriding our default ' .
                        'variables. Its also worth noting that just about any HTML can go within the ' .
                        '<code>.accordion-body</code>, though the transition does limit overflow.',
                    'contentOptions' => [
                        'class' => 'testContentOptions',
                    ],
                    'options' => [
                        'class' => 'testClass',
                        'id' => 'testId',
                    ],
                ],
                [
                    'label' => '<b>Accordion Item #3</b>',
                    'content' => [
                        '<b>test content1</b>',
                        '<strong>This is the third items accordion body.</strong> It is hidden by default, until the ' .
                        'collapse plugin adds the appropriate classes that we use to style each element. These ' .
                        'classes control the overall appearance, as well as the showing and hiding via CSS ' .
                        'transitions. You can modify any of this with custom CSS or overriding our default ' .
                        'variables. Its also worth noting that just about any HTML can go within the ' .
                        '<code>.accordion-body</code>, though the transition does limit overflow.',
                    ],
                    'contentOptions' => [
                        'class' => 'testContentOptions2',
                    ],
                    'options' => [
                        'class' => 'testClass2',
                        'id' => 'testId2',
                    ],
                    'toggleOptions' => [
                        'encode' => false,
                    ],
                    'encode' => false,
                ],
                [
                    'label' => 'Accordion item #3 - Stringable object',
                    'content' => B::tag()->content('This is a Stringable object'),
                ],
                [
                    'label' => 'Accordion item #4 - array',
                    'content' => [
                        '<p>This is a standard string content</p>',
                        B::tag()->content('This is a Stringable object'),
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML_WRAP'
<div id="w0-accordion" class="accordion">

<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="true">
Accordion Item #1
</button>
</h2>
<div id="w1-collapse" class="accordion-collapse collapse show" data-bs-parent="#w0-accordion">
<div class="accordion-body">
This is the first items accordion body. It is shown by default, until the collapse plugin the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can  modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the .accordion-body, though the transition does limit overflow.
</div>
</div>
</div>

<div id="testId" class="testClass accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">
Accordion Item #2
</button>
</h2>
<div id="w2-collapse" class="testContentOptions accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body">
<strong>This is the second items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>

<div id="testId2" class="testClass2 accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w3-collapse" data-bs-target="#w3-collapse" aria-expanded="false">
<b>Accordion Item #3</b>
</button>
</h2>
<div id="w3-collapse" class="testContentOptions2 accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body"><b>test content1</b>
<strong>This is the third items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>

<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w4-collapse" data-bs-target="#w4-collapse" aria-expanded="false">
Accordion item #3 - Stringable object
</button>
</h2>
<div id="w4-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body">
<b>This is a Stringable object</b>
</div>
</div>
</div>

<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w5-collapse" data-bs-target="#w5-collapse" aria-expanded="false">
Accordion item #4 - array
</button>
</h2>
<div id="w5-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body">
<p>This is a standard string content</p>
<b>This is a Stringable object</b>
</div>
</div>
</div>

</div>
HTML_WRAP;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @link https://getbootstrap.com/docs/5.0/components/accordion/#flush
     */
    public function testFlush(): void
    {
        $html = Accordion::widget()
            ->items([
                [
                    'label' => 'Accordion Item #1',
                    'content' => [
                        'This is the first items accordion body. It is shown by default, until the collapse plugin ' .
                        'the appropriate classes that we use to style each element. These classes control the ' .
                        'overall appearance, as well as the showing and hiding via CSS transitions. You can  ' .
                        'modify any of this with custom CSS or overriding our default variables. Its also worth ' .
                        'noting that just about any HTML can go within the .accordion-body, though the transition ' .
                        'does limit overflow.',
                    ],
                ],
                [
                    'label' => 'Accordion Item #2',
                    'content' => '<strong>This is the second items accordion body.</strong> It is hidden by default, ' .
                        'until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                        'These classes control the overall appearance, as well as the showing and hiding via CSS ' .
                        'transitions. You can modify any of this with custom CSS or overriding our default ' .
                        'variables. Its also worth noting that just about any HTML can go within the ' .
                        '<code>.accordion-body</code>, though the transition does limit overflow.',
                    'contentOptions' => [
                        'class' => 'testContentOptions',
                    ],
                    'options' => [
                        'class' => 'testClass',
                        'id' => 'testId',
                    ],
                ],
                [
                    'label' => '<b>Accordion Item #3</b>',
                    'content' => [
                        '<b>test content1</b>',
                        '<strong>This is the third items accordion body.</strong> It is hidden by default, until the ' .
                        'collapse plugin adds the appropriate classes that we use to style each element. These ' .
                        'classes control the overall appearance, as well as the showing and hiding via CSS ' .
                        'transitions. You can modify any of this with custom CSS or overriding our default ' .
                        'variables. Its also worth noting that just about any HTML can go within the ' .
                        '<code>.accordion-body</code>, though the transition does limit overflow.',
                    ],
                    'contentOptions' => [
                        'class' => 'testContentOptions2',
                    ],
                    'options' => [
                        'class' => 'testClass2',
                        'id' => 'testId2',
                    ],
                    'toggleOptions' => [
                        'encode' => false,
                    ],
                    'encode' => false,
                ],
            ])
            ->flush()
            ->render();
        $expected = <<<'HTML_WRAP'
<div id="w0-accordion" class="accordion accordion-flush">

<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="true">Accordion Item #1</button>
</h2>
<div id="w1-collapse" class="accordion-collapse collapse show" data-bs-parent="#w0-accordion">
<div class="accordion-body">
This is the first items accordion body. It is shown by default, until the collapse plugin the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can  modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the .accordion-body, though the transition does limit overflow.
</div>
</div>
</div>

<div id="testId" class="testClass accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Accordion Item #2</button>
</h2>
<div id="w2-collapse" class="testContentOptions accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body">
<strong>This is the second items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>

<div id="testId2" class="testClass2 accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w3-collapse" data-bs-target="#w3-collapse" aria-expanded="false">
<b>Accordion Item #3</b>
</button>
</h2>
<div id="w3-collapse" class="testContentOptions2 accordion-collapse collapse" data-bs-parent="#w0-accordion">
<div class="accordion-body">
<b>test content1</b>
<strong>This is the third items accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. Its also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>

</div>
HTML_WRAP;
        $this->assertEqualsHTML($expected, $html);
    }

    public function invalidItemsProvider(): array
    {
        return [
            [ ['content'] ], // only content without label key
            [ [[]] ], // only content array without label
            [ [['content' => 'test']] ], // only content array without label
        ];
    }

    /**
     * @dataProvider invalidItemsProvider
     *
     * @throws InvalidConfigException
     */
    public function testMissingLabel(array $items): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Accordion::widget()
            ->items($items)
            ->render();
    }

    public function testMissingContent(): void
    {
        $items = [
            [
                'label' => 'item 1',
            ],
        ];

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "content" option is required.');
        Accordion::widget()
            ->items($items)
            ->render();
    }

    public function testTypeContentException(): void
    {
        $items = [
            [
                'label' => 'item 1',
                'content' => true,
            ],
        ];

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The "content" option should be a string, array or object.');
        Accordion::widget()
            ->items($items)
            ->render();
    }

    public function testAutoCloseItems(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
            ],
        ];
        $html = Accordion::widget()
            ->items($items)
            ->render();
        $this->assertStringContainsString('data-bs-parent="', $html);

        $html = Accordion::widget()
            ->allowMultipleOpenedItems()
            ->items($items)
            ->render();
        $this->assertStringNotContainsString('data-bs-parent="', $html);
    }

    public function testExpandOptions(): void
    {
        Accordion::counter(0);

        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
                'expand' => true,
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="true">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse show" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    /**
     * @depends testRender
     */
    public function testItemToggleTag(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->toggleOptions([
                'tag' => 'a',
                'class' => 'custom-toggle',
            ])
            ->render();
        $this->assertStringContainsString(
            '<a class="custom-toggle accordion-button" href="#w1-collapse"',
            $html
        );
        $this->assertStringNotContainsString('<button', $html);

        $html = Accordion::widget()
            ->items($items)
            ->toggleOptions([
                'tag' => 'a',
                'class' => ['widget' => 'custom-toggle'],
            ])
            ->render();
        $this->assertStringContainsString(
            '<a class="custom-toggle accordion-button" href="#w4-collapse"',
            $html
        );
        $this->assertStringNotContainsString('collapse-toggle', $html);
    }

    public function testOptions(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->options(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="testMe accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="true">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse show" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => '<span><i class="fas fa-eye">Item 2</i></span>',
                'content' => 'Content 2',
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="true">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse show" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">&lt;span&gt;&lt;i class="fas fa-eye"&gt;Item 2&lt;/i&gt;&lt;/span&gt;</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);

        $html = Accordion::widget()
            ->items($items)
            ->withoutEncodeLabels()
            ->render();
        $expected = <<<'HTML'
        <div id="w3-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button" data-bs-toggle="collapse" aria-controls="w4-collapse" data-bs-target="#w4-collapse" aria-expanded="true">Item 1</button>
        </h2>
        <div id="w4-collapse" class="accordion-collapse collapse show" data-bs-parent="#w3-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w5-collapse" data-bs-target="#w5-collapse" aria-expanded="false"><span><i class="fas fa-eye">Item 2</i></span></button>
        </h2>
        <div id="w5-collapse" class="accordion-collapse collapse" data-bs-parent="#w3-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testAllClose(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
                'expand' => false,
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
                'expand' => false,
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);


        Accordion::counter(0);

        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->defaultExpand(false)
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testBodyOptions(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
                'bodyOptions' => [
                    'class' => [
                        'bg-success',
                    ],
                ],
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->defaultExpand(false)
            ->bodyOptions([
                'tag' => 'section',
                'class' => [
                    'test_class',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </h2>
        <div id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <section class="test_class accordion-body">
        Content 1
        </section>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="bg-success accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testHeaderOptions(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
                'headerOptions' => [
                    'class' => [
                        'bg-success',
                    ],
                ],
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->defaultExpand(false)
            ->headerOptions([
                'tag' => 'header',
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <header class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </header>
        <div id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </div>
        </div>

        <div class="accordion-item">
        <h2 class="bg-success accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }

    public function testContentOptions(): void
    {
        $items = [
            [
                'label' => 'Item 1',
                'content' => 'Content 1',
            ],
            [
                'label' => 'Item 2',
                'content' => 'Content 2',
                'contentOptions' => [
                    'class' => [
                        'bg-success',
                    ],
                ],
            ],
        ];

        $html = Accordion::widget()
            ->items($items)
            ->defaultExpand(false)
            ->contentOptions([
                'tag' => 'article',
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion">

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w1-collapse" data-bs-target="#w1-collapse" aria-expanded="false">Item 1</button>
        </h2>
        <article id="w1-collapse" class="accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 1
        </div>
        </article>
        </div>

        <div class="accordion-item">
        <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" aria-controls="w2-collapse" data-bs-target="#w2-collapse" aria-expanded="false">Item 2</button>
        </h2>
        <div id="w2-collapse" class="bg-success accordion-collapse collapse" data-bs-parent="#w0-accordion">
        <div class="accordion-body">
        Content 2
        </div>
        </div>
        </div>

        </div>
        HTML;
        $this->assertEqualsHTML($expected, $html);
    }
}
