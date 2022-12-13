<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_key_exists;
use function array_merge;
use function implode;
use function is_array;
use function is_numeric;
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
    private array $expands = [];
    private ?bool $defaultExpand = null;
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private bool $autoCloseItems = true;
    private array $headerOptions = [];
    private array $itemToggleOptions = [];
    private array $contentOptions = [];
    private array $options = [];
    private bool $flush = false;

    public function getId(?string $suffix = '-accordion'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    private function getCollapseId(array $item, int $index): string
    {
        return ArrayHelper::getValueByPath($item, ['contentOptions', 'id'], $this->getId() . '-collapse' . $index);
    }

    private function getHeaderId(array $item, int $index): string
    {
        return ArrayHelper::getValueByPath($item, ['headerOptions', 'id'], $this->getCollapseId($item, $index) . '-heading');
    }

    public function beforeRun(): bool
    {
        Html::addCssClass($this->options, ['widget' => 'accordion']);

        if ($this->flush) {
            Html::addCssClass($this->options, ['flush' => 'accordion-flush']);
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        return parent::beforeRun();
    }

    protected function run(): string
    {
        return Html::div($this->renderItems(), $this->options)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Whether to close other items if an item is opened. Defaults to `true` which causes an accordion effect.
     *
     * Set this to `false` to allow keeping multiple items open at once.
     */
    public function allowMultipleOpenedItems(): self
    {
        $new = clone $this;
        $new->autoCloseItems = false;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
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
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        $new->expands = array_map(fn ($item) => isset($item['expand']) ? (bool) $item['expand'] : $this->defaultExpand, $new->items);

        return $new;
    }

    /**
     * Set expand property for items without it
     */
    public function defaultExpand(?bool $default): self
    {
        if ($default === $this->defaultExpand) {
            return $this;
        }

        $new = clone $this;
        $new->defaultExpand = $default;
        $new->expands = array_map(fn ($item) => isset($item['expand']) ? (bool) $item['expand'] : $new->defaultExpand, $new->items);

        return $new;
    }

    /**
     * Options for each header if not present in item
     */
    public function headerOptions(array $options): self
    {
        $new = clone $this;
        $new->headerOptions = $options;

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
     */
    public function itemToggleOptions(array $value): self
    {
        $new = clone $this;
        $new->itemToggleOptions = $value;

        return $new;
    }

    /**
     * Content options for items if not present in current
     */
    public function contentOptions(array $options): self
    {
        $new = clone $this;
        $new->contentOptions = $options;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
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
        $expanded = in_array(true, $this->expands, true);
        $allClose = !$expanded && count($this->items) === count(array_filter($this->expands, fn ($expand) => $expand === false));

        foreach ($this->items as $item) {
            if (!is_array($item)) {
                $item = ['content' => $item];
            }

            if ($allClose === false && $expanded === false && $index === 0) {
                $item['expand'] = true;
            }

            if (!array_key_exists('label', $item)) {
                throw new RuntimeException('The "label" option is required.');
            }

            $options = ArrayHelper::getValue($item, 'options', []);
            $item = $this->renderItem($item, $index++);

            Html::addCssClass($options, ['panel' => 'accordion-item']);

            $items[] = Html::div($item, $options)
                ->encode(false)
                ->render();
        }

        return implode('', $items);
    }

    /**
     * Renders a single collapsible item group.
     *
     * @param array $item a single item from {@see items}
     * @param int $index the item index as each item group content must have an id
     *
     * @throws JsonException|RuntimeException
     *
     * @return string the rendering result
     */
    private function renderItem(array $item, int $index): string
    {
        if (!array_key_exists('content', $item)) {
            throw new RuntimeException('The "content" option is required.');
        }

        $header = $this->renderHeader($item, $index);
        $collapse = $this->renderCollapse($item, $index);

        return $header . $collapse;
    }

    /**
     * Render collapse header
     */
    private function renderHeader(array $item, int $index): string
    {
        $options = ArrayHelper::getValue($item, 'headerOptions', $this->headerOptions);
        $tag = ArrayHelper::remove($options, 'tag', 'h2');
        $options['id'] = $this->getHeaderId($item, $index);
        $toggle = $this->renderToggle($item, $index);

        Html::addCssClass($options, ['widget' => 'accordion-header']);

        return Html::tag($tag, $toggle, $options)
            ->encode(false)
            ->render();
    }

    /**
     * Render collapse switcher
     */
    private function renderToggle(array $item, int $index): string
    {
        $label = $item['label'];
        $expand = $item['expand'] ?? false;
        $collapseId = $this->getCollapseId($item, $index);

        $options = array_merge(
            [
                'data-bs-toggle' => 'collapse',
                'aria-expanded' => $expand ? 'true' : 'false',
                'aria-controls' => $collapseId,
            ],
            $item['toggleOptions'] ?? $this->itemToggleOptions
        );
        $tag = ArrayHelper::remove($options, 'tag', 'button');
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeLabels);

        Html::addCssClass($options, ['accordion-button']);

        if (!$expand) {
            Html::addCssClass($options, ['collapsed']);
        }

        if ($tag === 'a') {
            $options['href'] = '#' . $collapseId;
        } else {
            $options['data-bs-target'] = '#' . $collapseId;

            if ($tag === 'button' && !isset($options['type'])) {
                $options['type'] = 'button';
            }
        }

        return Html::tag($tag, $label, $options)
            ->encode($encode)
            ->render();
    }

    /**
     * Render collapse item
     */
    private function renderCollapse(array $item, int $index): string
    {
        $expand = $item['expand'] ?? false;
        $options = $item['contentOptions'] ?? $this->contentOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $body = $this->renderBody($item);
        $options['id'] = $this->getCollapseId($item, $index);

        Html::addCssClass($options, ['accordion-collapse collapse']);

        if ($expand) {
            Html::addCssClass($options, ['show']);
        }

        if (!isset($options['aria-label'], $options['aria-labelledby'])) {
            $options['aria-labelledby'] = $this->getHeaderId($item, $index);
        }

        if ($this->autoCloseItems) {
            $options['data-bs-parent'] = '#' . $this->getId();
        }

        return Html::tag($tag, $body, $options)
            ->encode(false)
            ->render();
    }

    /**
     * Render collapse body
     */
    private function renderBody(array $item): string
    {
        $items = '';

        if ($this->isStringableObject($item['content'])) {
            $content = [$item['content']];
        } else {
            $content = (array) $item['content'];
        }

        foreach ($content as $value) {
            if (!is_string($value) && !is_numeric($value) && !$this->isStringableObject($value)) {
                throw new RuntimeException('The "content" option should be a string, array or object.');
            }

            $items .= $value;
        }

        return Html::div($items, ['class' => 'accordion-body'])
            ->encode($this->encodeTags)
            ->render();
    }

    private function isStringableObject(mixed $value): bool
    {
        return is_object($value) && method_exists($value, '__toString');
    }
}
