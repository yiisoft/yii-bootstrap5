<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Yii\Bootstrap5\Accordion;

/**
 * Tests for Accordion widget
 *
 * AccordionTest
 */
final class AccordionTest extends TestCase
{
    public function testRender(): void
    {
        Accordion::counter(0);

        $html = Accordion::widget()
            ->items([
                [
                    'label' => 'Collapsible Group Item #1',
                    'content' => [
                        'test content1',
                        'test content2',
                    ],
                ],
                [
                    'label' => 'Collapsible Group Item #2',
                    'content' => 'Das ist das Haus vom Nikolaus',
                    'contentOptions' => [
                        'class' => 'testContentOptions',
                    ],
                    'options' => [
                        'class' => 'testClass',
                        'id' => 'testId',
                    ],
                ],
                [
                    'label' => '<h1>Collapsible Group Item #3</h1>',
                    'content' => [
                        '<h2>test content1</h2>',
                        '<h2>test content2</h2>',
                    ],
                    'contentOptions' => [
                        'class' => 'testContentOptions2',
                    ],
                    'options' => [
                        'class' => 'testClass2',
                        'id' => 'testId2',
                    ],
                    'encode' => false,
                ],
                [
                    'label' => '<h1>Collapsible Group Item #4</h1>',
                    'content' => [
                        '<h2>test content1</h2>',
                        '<h2>test content2</h2>',
                    ],
                    'contentOptions' => [
                        'class' => 'testContentOptions3',
                    ],
                    'options' => [
                        'class' => 'testClass3',
                        'id' => 'testId3',
                    ],
                    'encode' => true,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion"><div class="accordion-item"><h2 id="w0-accordion-collapse0-heading" class="accordion-header"><button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse0" aria-expanded="true">Collapsible Group Item #1</button></h2>
        <div id="w0-accordion-collapse0" class="accordion-body collapse show" aria-labelledby="w0-accordion-collapse0-heading" data-bs-parent="#w0-accordion"><ul class="list-group">
        <li class="list-group-item">test content1</li>
        <li class="list-group-item">test content2</li>
        </ul>
        </div></div>
        <div id="testId" class="testClass accordion-item"><h2 id="w0-accordion-collapse1-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse1" aria-expanded="false">Collapsible Group Item #2</button></h2>
        <div id="w0-accordion-collapse1" class="testContentOptions accordion-body collapse" aria-labelledby="w0-accordion-collapse1-heading" data-bs-parent="#w0-accordion">Das ist das Haus vom Nikolaus</div></div>
        <div id="testId2" class="testClass2 accordion-item"><h2 id="w0-accordion-collapse2-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse2" aria-expanded="false"><h1>Collapsible Group Item #3</h1></button></h2>
        <div id="w0-accordion-collapse2" class="testContentOptions2 accordion-body collapse" aria-labelledby="w0-accordion-collapse2-heading" data-bs-parent="#w0-accordion"><ul class="list-group">
        <li class="list-group-item"><h2>test content1</h2></li>
        <li class="list-group-item"><h2>test content2</h2></li>
        </ul>
        </div></div>
        <div id="testId3" class="testClass3 accordion-item"><h2 id="w0-accordion-collapse3-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse3" aria-expanded="false">&lt;h1&gt;Collapsible Group Item #4&lt;/h1&gt;</button></h2>
        <div id="w0-accordion-collapse3" class="testContentOptions3 accordion-body collapse" aria-labelledby="w0-accordion-collapse3-heading" data-bs-parent="#w0-accordion"><ul class="list-group">
        <li class="list-group-item"><h2>test content1</h2></li>
        <li class="list-group-item"><h2>test content2</h2></li>
        </ul>
        </div></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
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
     * @param array $items
     *
     * @throws InvalidConfigException
     */
    public function testMissingLabel(array $items): void
    {
        $this->expectException(RuntimeException::class);
        Accordion::widget()->items($items)->render();
    }

    public function testMissingContent(): void
    {
        $items = [
            [
                'label' => 'item 1',
            ],
        ];

        $this->expectException(RuntimeException::class);
        Accordion::widget()->items($items)->render();
    }

    public function testAutoCloseItems(): void
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
            ],
        ];
        $html = Accordion::widget()->items($items)->render();
        $this->assertStringContainsString('data-bs-parent="', $html);

        $html = Accordion::widget()->allowMultipleOpenedItems()->items($items)->render();
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

        $html = Accordion::widget()->items($items)->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion"><div class="accordion-item"><h2 id="w0-accordion-collapse0-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse0" aria-expanded="false">Item 1</button></h2>
        <div id="w0-accordion-collapse0" class="accordion-body collapse" aria-labelledby="w0-accordion-collapse0-heading" data-bs-parent="#w0-accordion">Content 1</div></div>
        <div class="accordion-item"><h2 id="w0-accordion-collapse1-heading" class="accordion-header"><button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse1" aria-expanded="true">Item 2</button></h2>
        <div id="w0-accordion-collapse1" class="accordion-body collapse show" aria-labelledby="w0-accordion-collapse1-heading" data-bs-parent="#w0-accordion">Content 2</div></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @depends testRender
     */
    public function testItemToggleTag(): void
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
            ],
        ];

        $html = Accordion::widget()

            ->items($items)
            ->itemToggleOptions([
                'tag' => 'a',
                'class' => 'custom-toggle',
            ])
            ->render();
        $this->assertStringContainsString(
            '<a type="button" class="custom-toggle" href="#w0-accordion-collapse0"',
            $html
        );
        $this->assertStringNotContainsString('<button', $html);

        $html = Accordion::widget()
            ->items($items)
            ->itemToggleOptions([
                'tag' => 'a',
                'class' => ['widget' => 'custom-toggle'],
            ])
            ->render();
        $this->assertStringContainsString(
            '<a type="button" class="custom-toggle" href="#w1-accordion-collapse0"',
            $html
        );
        $this->assertStringNotContainsString('collapse-toggle', $html);
    }

    public function testOptions(): void
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
            ],
        ];

        $html = Accordion::widget()->items($items)->options(['class' => 'testMe'])->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="testMe accordion"><div class="accordion-item"><h2 id="w0-accordion-collapse0-heading" class="accordion-header"><button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse0" aria-expanded="true">Item 1</button></h2>
        <div id="w0-accordion-collapse0" class="accordion-body collapse show" aria-labelledby="w0-accordion-collapse0-heading" data-bs-parent="#w0-accordion">Content 1</div></div>
        <div class="accordion-item"><h2 id="w0-accordion-collapse1-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse1" aria-expanded="false">Item 2</button></h2>
        <div id="w0-accordion-collapse1" class="accordion-body collapse" aria-labelledby="w0-accordion-collapse1-heading" data-bs-parent="#w0-accordion">Content 2</div></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        Accordion::counter(0);

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

        $html = Accordion::widget()->items($items)->render();
        $expected = <<<'HTML'
        <div id="w0-accordion" class="accordion"><div class="accordion-item"><h2 id="w0-accordion-collapse0-heading" class="accordion-header"><button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse0" aria-expanded="true">Item 1</button></h2>
        <div id="w0-accordion-collapse0" class="accordion-body collapse show" aria-labelledby="w0-accordion-collapse0-heading" data-bs-parent="#w0-accordion">Content 1</div></div>
        <div class="accordion-item"><h2 id="w0-accordion-collapse1-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w0-accordion-collapse1" aria-expanded="false">&lt;span&gt;&lt;i class="fas fa-eye"&gt;Item 2&lt;/i&gt;&lt;/span&gt;</button></h2>
        <div id="w0-accordion-collapse1" class="accordion-body collapse" aria-labelledby="w0-accordion-collapse1-heading" data-bs-parent="#w0-accordion">Content 2</div></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Accordion::widget()->items($items)->withoutEncodeLabels()->render();
        $expected = <<<'HTML'
        <div id="w1-accordion" class="accordion"><div class="accordion-item"><h2 id="w1-accordion-collapse0-heading" class="accordion-header"><button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#w1-accordion-collapse0" aria-expanded="true">Item 1</button></h2>
        <div id="w1-accordion-collapse0" class="accordion-body collapse show" aria-labelledby="w1-accordion-collapse0-heading" data-bs-parent="#w1-accordion">Content 1</div></div>
        <div class="accordion-item"><h2 id="w1-accordion-collapse1-heading" class="accordion-header"><button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#w1-accordion-collapse1" aria-expanded="false"><span><i class="fas fa-eye">Item 2</i></span></button></h2>
        <div id="w1-accordion-collapse1" class="accordion-body collapse" aria-labelledby="w1-accordion-collapse1-heading" data-bs-parent="#w1-accordion">Content 2</div></div></div>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
