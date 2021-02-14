<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_key_exists;
use function array_merge;

/**
 * Tabs renders a Tab bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Tabs::widget()
 *     ->items([
 *         [
 *             'label' => 'One',
 *             'content' => 'Anim pariatur cliche...',
 *             'active' => true,
 *         ],
 *         [
 *             'label' => 'Two',
 *             'content' => 'Anim pariatur cliche...',
 *             'headerOptions' => [...],
 *             'options' => ['id' => 'myveryownID'],
 *         ],
 *         [
 *             'label' => 'Example',
 *             'url' => 'http://www.example.com',
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  [
 *                      'label' => 'DropdownA',
 *                      'content' => 'DropdownA, Anim pariatur cliche...',
 *                  ],
 *                  [
 *                      'label' => 'DropdownB',
 *                      'content' => 'DropdownB, Anim pariatur cliche...',
 *                  ],
 *                  [
 *                      'label' => 'External Link',
 *                      'url' => 'http://www.example.com',
 *                  ],
 *             ],
 *         ],
 *     ]);
 * ```
 */
final class Tabs extends Widget
{
    private array $items = [];
    private array $itemOptions = [];
    private array $headerOptions = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private string $navType = 'nav-tabs';
    private bool $renderTabContent = true;
    private array $tabContentOptions = [];
    private string $dropdownClass = Dropdown::class;
    private array $panes = [];
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-tabs";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'nav', $this->navType]);
        Html::addCssClass($this->tabContentOptions, ['tabContentOptions' => 'tab-content']);

        if ($this->encodeTags === false) {
            $this->itemOptions['encode'] = false;
            $this->options['encode'] = false;
            $this->tabContentOptions['encode'] = false;
        }

        $this->prepareItems($this->items);

        $navWidget = Nav::widget()
            ->dropdownClass($this->dropdownClass)
            ->items($this->items)
            ->options(ArrayHelper::merge(['role' => 'tablist'], $this->options));

        if ($this->encodeLabels === false) {
            $navWidget = $navWidget->withoutEncodeLabels();
        }

        return $navWidget->render() . $this->renderPanes($this->panes);
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     *
     * @param string $value
     *
     * @return $this
     */
    public function dropdownClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownClass = $value;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return $this
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * List of HTML attributes for the header container tags. This will be overwritten by the "headerOptions" set in
     * individual {@see items}.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function headerOptions(array $value): self
    {
        $new = clone $this;
        $new->headerOptions = $value;

        return $new;
    }

    /**
     * List of tabs in the tabs widget. Each array element represents a single tab with the following structure:
     *
     * - label: string, required, the tab header label.
     * - encode: bool, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - headerOptions: array, optional, the HTML attributes of the tab header.
     * - content: string, optional, the content (HTML) of the tab pane.
     * - url: string, optional, an external URL. When this is specified, clicking on this tab will bring
     *   the browser to this URL.
     * - options: array, optional, the HTML attributes of the tab pane container.
     * - active: bool, optional, whether this item tab header and pane should be active. If no item is marked as
     *   'active' explicitly - the first one will be activated.
     * - visible: bool, optional, whether the item tab header and pane should be visible or not. Defaults to true.
     * - items: array, optional, can be used instead of `content` to specify a dropdown items
     *   configuration array. Each item can hold three extra keys, besides the above ones:
     *     * active: bool, optional, whether the item tab header and pane should be visible or not.
     *     * content: string, required if `items` is not set. The content (HTML) of the tab pane.
     *     * contentOptions: optional, array, the HTML attributes of the tab content container.
     *
     * @param array $value
     *
     * @return $this
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * List of HTML attributes for the item container tags. This will be overwritten by the "options" set in individual
     * {@see items}. The following special options are recognized.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function itemOptions(array $value): self
    {
        $new = clone $this;
        $new->itemOptions = $value;

        return $new;
    }

    /**
     * Specifies the Bootstrap tab styling.
     *
     * @param string $value
     *
     * @return $this
     */
    public function navType(string $value): self
    {
        $new = clone $this;
        $new->navType = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Tab panes (contents).
     *
     * @param array $value
     *
     * @return $this
     */
    public function panes(array $value): self
    {
        $new = clone $this;
        $new->panes = $value;

        return $new;
    }

    /**
     * Manually render `tab-content` yourself in case your tab contents are complex.
     *
     * @return $this
     */
    public function withoutRenderTabContent(): self
    {
        $new = clone $this;
        $new->renderTabContent = false;

        return $new;
    }

    /**
     * List of HTML attributes for the `tab-content` container. This will always contain the CSS class `tab-content`.
     *
     * @param array $value
     *
     * @return $this
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function tabContentOptions(array $value): self
    {
        $new = clone $this;
        $new->tabContentOptions = $value;

        return $new;
    }

    /**
     * Renders tab panes.
     *
     * @param array $panes
     *
     * @throws JsonException
     *
     * @return string the rendering result.
     */
    private function renderPanes(array $panes): string
    {
        return $this->renderTabContent ? ("\n" . Html::div(implode("\n", $panes), $this->tabContentOptions)) : '';
    }

    /**
     * Renders tab items as specified on {@see items}.
     *
     * @param array $items
     * @param string $prefix
     *
     * @throws JsonException|RuntimeException
     */
    private function prepareItems(array &$items, string $prefix = ''): void
    {
        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($items as $n => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . $prefix . '-tab' . $n);

            /** {@see https://github.com/yiisoft/yii2-bootstrap4/issues/108#issuecomment-465219339} */
            unset($items[$n]['options']['id']);

            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }

            if (!array_key_exists('label', $item)) {
                throw new RuntimeException('The "label" option is required.');
            }

            $selected = ArrayHelper::getValue($item, 'active', false);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);
            $headerOptions = ArrayHelper::getValue($item, 'headerOptions', $this->headerOptions);

            if (isset($item['items'])) {
                $this->prepareItems($items[$n]['items'], '-dd' . $n);
                continue;
            }

            ArrayHelper::setValue($items[$n], 'options', $headerOptions);

            if (isset($item['url'])) {
                continue;
            }

            ArrayHelper::setValue($items[$n], 'url', '#' . $options['id']);
            ArrayHelper::setValueByPath($items[$n], 'linkOptions.data.bs-toggle', 'tab');
            ArrayHelper::setValueByPath($items[$n], 'linkOptions.role', 'tab');
            ArrayHelper::setValueByPath($items[$n], 'linkOptions.aria-controls', $options['id']);

            if (!$disabled) {
                ArrayHelper::setValueByPath($items[$n], 'linkOptions.aria-selected', $selected ? 'true' : 'false');
            }

            /** @psalm-suppress InvalidArgument */
            Html::addCssClass($options, ['widget' => 'tab-pane']);

            if ($selected) {
                Html::addCssClass($options, ['active' => 'active']);
            }

            /** @psalm-suppress ConflictingReferenceConstraint */
            if ($this->renderTabContent) {
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $this->panes[] = Html::tag($tag, $item['content'] ?? '', $options);
            }
        }
    }

    /**
     * @return bool if there's active tab defined.
     */
    private function hasActiveTab(): bool
    {
        foreach ($this->items as $item) {
            if (isset($item['active']) && $item['active'] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sets the first visible tab as active.
     *
     * This method activates the first tab that is visible and not explicitly set to inactive (`'active' => false`).
     */
    private function activateFirstVisibleTab(): void
    {
        foreach ($this->items as $i => $item) {
            $active = ArrayHelper::getValue($item, 'active', null);
            $visible = ArrayHelper::getValue($item, 'visible', true);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);

            if ($visible && $active !== false && $disabled !== true) {
                $this->items[$i]['active'] = true;
                return;
            }
        }
    }
}
