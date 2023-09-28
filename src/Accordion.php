<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use function array_key_exists;
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
    private array $toggleOptions = [];
    private array $contentOptions = [];
    private array $bodyOptions = [];
    private array $options = [];
    private bool $flush = false;

    public function getId(?string $suffix = '-accordion'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function render(): string
    {
        $options = $this->options;
        $options['id'] = $this->getId();
        Html::addCssClass($options, ['widget' => 'accordion']);

        if ($this->flush) {
            Html::addCssClass($options, ['flush' => 'accordion-flush']);
        }

        if ($this->theme) {
            $options['data-bs-theme'] = $this->theme;
        }

        return Html::div($this->renderItems(), $options)
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
     */
    public function toggleOptions(array $options): self
    {
        $new = clone $this;
        $new->toggleOptions = $options;

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
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    public function bodyOptions(array $options): self
    {
        $new = clone $this;
        $new->bodyOptions = $options;

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
        $allClose = !$expanded && count($this->items) === count(array_filter($this->expands, static fn ($expand) => $expand === false));

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
            $item = $this->renderItem($item);

            Html::addCssClass($options, ['panel' => 'accordion-item']);

            $items[] = Html::div($item, $options)
                ->encode(false)
                ->render();

            $index++;
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
    private function renderItem(array $item): string
    {
        if (!array_key_exists('content', $item)) {
            throw new RuntimeException('The "content" option is required.');
        }

        $collapse = $this->renderCollapse($item);
        $header = $this->renderHeader($collapse, ArrayHelper::getValue($item, 'headerOptions'));

        return $header . $collapse->render();
    }

    /**
     * Render collapse header
     */
    private function renderHeader(Collapse $collapse, ?array $headerOptions): string
    {
        $options = $headerOptions ?? $this->headerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'h2');

        Html::addCssClass($options, ['widget' => 'accordion-header']);

        return Html::tag($tag, $collapse->renderToggle(), $options)
            ->encode(false)
            ->render();
    }

    /**
     * Render collapse item
     */
    private function renderCollapse(array $item): Collapse
    {
        $expand = $item['expand'] ?? false;
        $options = $item['contentOptions'] ?? $this->contentOptions;
        $toggleOptions = $item['toggleOptions'] ?? $this->toggleOptions;
        $bodyOptions = $item['bodyOptions'] ?? $this->bodyOptions;

        $toggleOptions['encode'] ??= $this->encodeLabels;
        $bodyOptions['encode'] ??= $this->encodeTags;

        Html::addCssClass($options, ['accordion-collapse']);
        Html::addCssClass($toggleOptions, ['accordion-button']);
        Html::addCssClass($bodyOptions, ['widget' => 'accordion-body']);

        if (!$expand) {
            Html::addCssClass($toggleOptions, ['collapsed']);
        }

        if ($this->autoCloseItems) {
            $options['data-bs-parent'] = '#' . $this->getId();
        }

        return Collapse::widget()
            ->withToggleLabel($item['label'])
            ->withToggleOptions($toggleOptions)
            ->withOptions($options)
            ->withContent($this->renderBody($item))
            ->withBodyOptions($bodyOptions)
            ->withCollapsed($expand)
            ->withToggle(false);
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

        return $items;
    }

    private function isStringableObject(mixed $value): bool
    {
        return $value instanceof Stringable;
    }
}
