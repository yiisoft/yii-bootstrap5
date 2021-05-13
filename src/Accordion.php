<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_column;
use function array_key_exists;
use function array_merge;
use function array_search;
use function implode;
use function is_array;
use function is_numeric;
use function is_object;
use function is_string;

/**
 * Accordion renders an accordion bootstrap JavaScript component.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget()
 *     ->items([
 *         [
 *             'label' => 'Accordion Item #1',
 *             'content' => [
 *                 'This is the first items accordion body. It is shown by default, until the collapse plugin ' .
 *                 'the appropriate classes that we use to style each element. These classes control the ' .
 *                 'overall appearance, as well as the showing and hiding via CSS transitions. You can  ' .
 *                 'modify any of this with custom CSS or overriding our default variables. Its also worth ' .
 *                 'noting that just about any HTML can go within the .accordion-body, though the transition ' .
 *                 'does limit overflow.',
 *             ],
 *         ],
 *         [
 *             'label' => 'Accordion Item #2',
 *             'content' => '<strong>This is the second items accordion body.</strong> It is hidden by default, ' .
 *                 'until the collapse plugin adds the appropriate classes that we use to style each element. ' .
 *                 'These classes control the overall appearance, as well as the showing and hiding via CSS ' .
 *                 'transitions. You can modify any of this with custom CSS or overriding our default ' .
 *                 'variables. Its also worth noting that just about any HTML can go within the ' .
 *                 '<code>.accordion-body</code>, though the transition does limit overflow.',
 *             'contentOptions' => [
 *                 'class' => 'testContentOptions',
 *             ],
 *             'options' => [
 *                 'class' => 'testClass',
 *                 'id' => 'testId',
 *             ],
 *         ],
 *         [
 *             'label' => '<b>Accordion Item #3</b>',
 *             'content' => [
 *                 '<b>test content1</b>',
 *                 '<strong>This is the third items accordion body.</strong> It is hidden by default, until the ' .
 *                 'collapse plugin adds the appropriate classes that we use to style each element. These ' .
 *                 'classes control the overall appearance, as well as the showing and hiding via CSS ' .
 *                 'transitions. You can modify any of this with custom CSS or overriding our default ' .
 *                 'variables. Its also worth noting that just about any HTML can go within the ' .
 *                 '<code>.accordion-body</code>, though the transition does limit overflow.',
 *             ],
 *             'contentOptions' => [
 *                 'class' => 'testContentOptions2',
 *             ],
 *             'options' => [
 *                 'class' => 'testClass2',
 *                 'id' => 'testId2',
 *             ],
 *             'encode' => false,
 *         ],
 *     ]);
 * ```
 *
 * @link https://getbootstrap.com/docs/5.0/components/accordion/
 */
final class Accordion extends Widget
{
    private array $items = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private bool $autoCloseItems = true;
    private array $itemToggleOptions = [];
    private array $options = [];
    private bool $flush = false;

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-accordion";
        }

        Html::addCssClass($this->options, ['widget' => 'accordion']);

        if ($this->flush) {
            Html::addCssClass($this->options, ['flush' => 'accordion-flush']);
        }

        return Html::div($this->renderItems(), $this->options)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Whether to close other items if an item is opened. Defaults to `true` which causes an accordion effect.
     *
     * Set this to `false` to allow keeping multiple items open at once.
     *
     * @return self
     */
    public function allowMultipleOpenedItems(): self
    {
        $new = clone $this;
        $new->autoCloseItems = false;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * List of groups in the collapse widget. Each array element represents a single group with the following structure:
     *
     * - label: string, required, the group header label.
     * - encode: bool, optional, whether this label should be HTML-encoded. This param will override global
     *   `$this->encodeLabels` param.
     * - content: array|string|object, required, the content (HTML) of the group
     * - options: array, optional, the HTML attributes of the group
     * - contentOptions: optional, the HTML attributes of the group's content
     *
     * You may also specify this property as key-value pairs, where the key refers to the `label` and the value refers
     * to `content`. If value is a string it is interpreted as label. If it is an array, it is interpreted as explained
     * above.
     *
     * For example:
     *
     * ```php
     * echo Accordion::widget()
     *     ->items(
     *         [
     *             [
     *                 'Introduction' => 'This is the first collapsible menu',
     *                 'Second panel' => [
     *                     'content' => 'This is the second collapsible menu',
     *                 ],
     *             ],
     *             [
     *                 'label' => 'Third panel',
     *                 'content' => 'This is the third collapsible menu',
     *             ],
     *         ],
     *     );
     * ```
     *
     * @param array $value
     *
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * The HTML options for the item toggle tag. Key 'tag' might be used here for the tag name specification.
     *
     * For example:
     *
     * ```php
     * [
     *     'tag' => 'div',
     *     'class' => 'custom-toggle',
     * ]
     * ```
     *
     * @param array $value
     *
     * @return self
     */
    public function itemToggleOptions(array $value): self
    {
        $new = clone $this;
        $new->itemToggleOptions = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Remove the default background-color, some borders, and some rounded corners to render accordions
     * edge-to-edge with their parent container.
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.0/components/accordion/#flush
     */
    public function flush(): self
    {
        $new = clone $this;
        $new->flush = true;

        return $new;
    }

    /**
     * Renders collapsible items as specified on {@see items}.
     *
     * @throws JsonException|RuntimeException
     *
     * @return string the rendering result
     */
    private function renderItems(): string
    {
        $items = [];
        $index = 0;
        $expanded = array_search(true, array_column($this->items, 'expand'), true);

        foreach ($this->items as $item) {
            if (!is_array($item)) {
                $item = ['content' => $item];
            }

            if ($expanded === false && $index === 0) {
                $item['expand'] = true;
            }

            if (!array_key_exists('label', $item)) {
                throw new RuntimeException('The "label" option is required.');
            }

            $header = ArrayHelper::remove($item, 'label');
            $options = ArrayHelper::getValue($item, 'options', []);

            Html::addCssClass($options, ['panel' => 'accordion-item']);

            $items[] = Html::div($this->renderItem($header, $item, $index++), $options)
                ->encode($this->encodeTags)
                ->render();
        }

        return implode("\n", $items);
    }

    /**
     * Renders a single collapsible item group.
     *
     * @param string $header a label of the item group {@see items}
     * @param array $item a single item from {@see items}
     * @param int $index the item index as each item group content must have an id
     *
     * @throws JsonException|RuntimeException
     *
     * @return string the rendering result
     */
    private function renderItem(string $header, array $item, int $index): string
    {
        if (array_key_exists('content', $item)) {
            $id = $this->options['id'] . '-collapse' . $index;
            $expand = ArrayHelper::remove($item, 'expand', false);
            $options = ArrayHelper::getValue($item, 'contentOptions', []);
            $options['id'] = $id;

            Html::addCssClass($options, ['widget' => 'accordion-body collapse']);

            if ($expand) {
                Html::addCssClass($options, ['visibility' => 'show']);
            }

            if (!isset($options['aria-label'], $options['aria-labelledby'])) {
                $options['aria-labelledby'] = $options['id'] . '-heading';
            }

            $encodeLabel = $item['encode'] ?? $this->encodeLabels;

            if ($encodeLabel) {
                $header = Html::encode($header);
            }

            $itemToggleOptions = array_merge([
                'tag' => 'button',
                'type' => 'button',
                'data-bs-toggle' => 'collapse',
                'data-bs-target' => '#' . $options['id'],
                'aria-expanded' => $expand ? 'true' : 'false',
                'aria-controls' => $options['id'],
            ], $this->itemToggleOptions);

            $itemToggleTag = ArrayHelper::remove($itemToggleOptions, 'tag', 'button');

            if ($itemToggleTag === 'a') {
                ArrayHelper::remove($itemToggleOptions, 'data-bs-target');
                $header = Html::a($header, '#' . $id, $itemToggleOptions)->encode($this->encodeTags) . "\n";
            } else {
                Html::addCssClass($itemToggleOptions, ['widget' => 'accordion-button']);
                if (!$expand) {
                    Html::addCssClass($itemToggleOptions, ['expand' => 'collapsed']);
                }
                $header = Html::button($header, $itemToggleOptions)->encode($this->encodeTags)->render();
            }

            if (is_string($item['content']) || is_numeric($item['content']) || is_object($item['content'])) {
                $content = $item['content'];
            } elseif (is_array($item['content'])) {
                $items = [];
                foreach ($item['content'] as $content) {
                    $items[] = Html::div($content)
                        ->attributes(['class' => 'accordion-body'])
                        ->encode($this->encodeTags)
                        ->render();
                }

                $content = implode("\n", $items);
            } else {
                throw new RuntimeException('The "content" option should be a string, array or object.');
            }
        } else {
            throw new RuntimeException('The "content" option is required.');
        }

        $group = [];

        if ($this->autoCloseItems) {
            $options['data-bs-parent'] = '#' . $this->options['id'];
        }

        $groupOptions = ['class' => 'accordion-header', 'id' => $options['id'] . '-heading'];

        $group[] = Html::tag('h2', $header, $groupOptions)->encode($this->encodeTags);
        $group[] = Html::div($content, $options)->encode($this->encodeTags);

        return implode("\n", $group);
    }
}
