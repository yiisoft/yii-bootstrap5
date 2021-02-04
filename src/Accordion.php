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
use function is_int;
use function is_numeric;
use function is_object;
use function is_string;

/**
 * Accordion renders an accordion bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget()
 *     ->witItems([
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             // open its content by default
 *             'contentOptions' => ['class' => 'show'],
 *         ],
 *         // another group item
 *         [
 *             'label' => 'Collapsible Group Item #2',
 *             'content' => 'Anim pariatur cliche...',
 *             'contentOptions' => [...],
 *             'options' => [...],
 *             'expand' => true,
 *         ],
 *         // if you want to swap out .accordion-body with .list-group, you may provide an array
 *         [
 *             'label' => 'Collapsible Group Item #3',
 *             'content' => [
 *                 'Anim pariatur cliche...',
 *                 'Anim pariatur cliche...',
 *             ],
 *             'contentOptions' => [...],
 *             'options' => [...],
 *         ],
 *     ]);
 * ```
 */
final class Accordion extends Widget
{
    private array $items = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private bool $autoCloseItems = true;
    private array $itemToggleOptions = [];
    private array $options = [];

    public function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-accordion";
        }

        $this->registerPlugin('collapse', $this->options);

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, 'accordion');

        if ($this->encodeTags === false) {
            $this->options = array_merge($this->options, ['encode' => false]);
        }

        return Html::div($this->renderItems(), $this->options);
    }

    /**
     * Whether to close other items if an item is opened. Defaults to `true` which causes an accordion effect.
     *
     * Set this to `false` to allow keeping multiple items open at once.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function withAutoCloseItems(bool $value): self
    {
        $new = clone $this;
        $new->autoCloseItems = $value;

        return $new;
    }

    /**
     * Whether the labels for header items should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function withEncodeLabels(bool $value): self
    {
        $new = clone $this;
        $new->encodeLabels = $value;

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
     * echo Accordion::widget([
     *     'withItems' => [
     *       'Introduction' => 'This is the first collapsible menu',
     *       'Second panel' => [
     *           'content' => 'This is the second collapsible menu',
     *       ],
     *       [
     *           'label' => 'Third panel',
     *           'content' => 'This is the third collapsible menu',
     *       ],
     *   ]
     * ])
     * ```
     *
     * @param array $value
     *
     * @return $this
     */
    public function withItems(array $value): self
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
     * @return $this
     */
    public function withItemToggleOptions(array $value): self
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
     * @return $this
     */
    public function withOptions(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Allows you to enable or disable the encoding tags html.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withencodeTags(bool $value): self
    {
        $new = clone $this;
        $new->encodeTags = $value;

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

        foreach ($this->items as $key => $item) {
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

            if ($this->encodeTags === false) {
                $options = array_merge($options, ['encode' => false]);
            }

            Html::addCssClass($options, ['panel' => 'accordion-item']);

            $items[] = Html::div($this->renderItem($header, $item, $index++), $options);
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

            Html::addCssClass($options, ['accordion-body', 'collapse']);

            if ($expand) {
                Html::addCssClass($options, 'show');
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
            ], $this->itemToggleOptions);

            if ($this->encodeTags === false) {
                $itemToggleOptions = array_merge($itemToggleOptions, ['encode' => false]);
            }

            $itemToggleTag = ArrayHelper::remove($itemToggleOptions, 'tag', 'button');

            /** @psalm-suppress ConflictingReferenceConstraint */
            if ($itemToggleTag === 'a') {
                ArrayHelper::remove($itemToggleOptions, 'data-bs-target');
                $header = Html::a($header, '#' . $id, $itemToggleOptions) . "\n";
            } else {
                Html::addCssClass($itemToggleOptions, 'accordion-button');
                if (!$expand) {
                    Html::addCssClass($itemToggleOptions, 'collapsed');
                }
                $header = Html::button($header, $itemToggleOptions);
            }

            if (is_string($item['content']) || is_numeric($item['content']) || is_object($item['content'])) {
                $content = $item['content'];
            } elseif (is_array($item['content'])) {
                $ulOptions = ['class' => 'list-group'];
                $ulItemOptions = ['itemOptions' => ['class' => 'list-group-item']];

                if ($this->encodeTags === false) {
                    $ulOptions = array_merge($ulOptions, ['encode' => false]);
                    $ulItemOptions['itemOptions'] = array_merge($ulItemOptions['itemOptions'], ['encode' => false]);
                }

                $content = Html::ul($item['content'], array_merge($ulOptions, $ulItemOptions)) . "\n";
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

        if ($this->encodeTags === false) {
            $options = array_merge($options, ['encode' => false]);
            $groupOptions = array_merge($groupOptions, ['encode' => false]);
        }

        $group[] = Html::tag('h2', $header, $groupOptions);
        $group[] = Html::div($content, $options);

        return implode("\n", $group);
    }
}
