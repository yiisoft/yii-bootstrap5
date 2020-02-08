<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Widget\Exception\InvalidConfigException;

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
class Tabs extends Widget
{
    private array $items = [];

    private array $itemOptions = [];

    private array $headerOptions = [];

    private array $linkOptions = [];

    private bool $encodeLabels = true;

    private string $navType = 'nav-tabs';

    private bool $renderTabContent = true;

    private array $tabContentOptions = [];

    public string $dropdownClass = Dropdown::class;

    protected array $panes = [];

    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-tabs";
        }

        Html::addCssClass($this->options, ['widget' => 'nav', $this->navType]);
        Html::addCssClass($this->tabContentOptions, 'tab-content');

        $this->registerPlugin('tab', $this->options);
        $this->prepareItems($this->items);

        return Nav::widget()
                ->dropdownClass($this->dropdownClass)
                ->options(ArrayHelper::merge(['role' => 'tablist'], $this->options))
                ->items($this->items)
                ->encodeLabels($this->encodeLabels)
                ->run()
                . $this->renderPanes($this->panes);
    }

    /**
     * Renders tab items as specified on {@see items}.
     *
     * @param array $items
     * @param string $prefix
     *
     * @throws InvalidConfigException
     */
    protected function prepareItems(array &$items, string $prefix = ''): void
    {
        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($items as $n => $item) {
            $options = \array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . $prefix . '-tab' . $n);

            /* {@see https://github.com/yiisoft/yii2-bootstrap4/issues/108#issuecomment-465219339} */
            unset($items[$n]['options']['id']);

            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }

            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
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
            ArrayHelper::setValue($items[$n], 'linkOptions.data.toggle', 'tab');
            ArrayHelper::setValue($items[$n], 'linkOptions.role', 'tab');
            ArrayHelper::setValue($items[$n], 'linkOptions.aria-controls', $options['id']);

            if (!$disabled) {
                ArrayHelper::setValue($items[$n], 'linkOptions.aria-selected', $selected ? 'true' : 'false');
            }

            Html::addCssClass($options, ['widget' => 'tab-pane']);

            if ($selected) {
                Html::addCssClass($options, 'active');
            }

            if ($this->renderTabContent) {
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $this->panes[] = Html::tag($tag, $item['content'] ?? '', $options);
            }
        }
    }

    /**
     * @return bool if there's active tab defined.
     */
    protected function hasActiveTab(): bool
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
    protected function activateFirstVisibleTab(): void
    {
        foreach ($this->items as $i => $item) {
            $active = ArrayHelper::getValue($item, 'active', null);
            $visible = ArrayHelper::getValue($item, 'visible', true);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);

            if ($visible && $active !== false && ($disabled !== true)) {
                $this->items[$i]['active'] = true;
                return;
            }
        }
    }

    /**
     * Renders tab panes.
     *
     * @param array $panes
     *
     * @return string the rendering result.
     */
    public function renderPanes(array $panes): string
    {
        return $this->renderTabContent ? ("\n" . Html::tag('div', implode("\n", $panes), $this->tabContentOptions)) : '';
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     */
    public function dropdownClass(string $value): self
    {
        $this->dropdownClass = $value;

        return $this;
    }

    /**
     * Whether the labels for header items should be HTML-encoded.
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * List of HTML attributes for the header container tags. This will be overwritten by the "headerOptions" set in
     * individual {@see items}.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerOptions(array $value): self
    {
        $this->headerOptions = $value;

        return $this;
    }

    /**
     * List of tabs in the tabs widget. Each array element represents a single tab with the following structure:
     *
     * - label: string, required, the tab header label.
     * - encode: bool, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - headerOptions: array, optional, the HTML attributes of the tab header.
     * - linkOptions: array, optional, the HTML attributes of the tab header link tags.
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
     */
    public function items(array $value): self
    {
        $this->items = $value;

        return $this;
    }

    /**
     * List of HTML attributes for the item container tags. This will be overwritten by the "options" set in individual
     * {@see items}. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function itemOptions(array $value): self
    {
        $this->itemOptions = $value;

        return $this;
    }

    /**
     * List of HTML attributes for the tab header link tags. This will be overwritten by the "linkOptions" set in
     * individual {@see items}.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function linkOptions(array $value): self
    {
        $this->linkOptions = $value;

        return $this;
    }

    /**
     * Specifies the Bootstrap tab styling.
     */
    public function navType(string $value): self
    {
        $this->navType = $value;

        return $this;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * Tab panes (contents).
     */
    public function panes(array $value): self
    {
        $this->panes = $value;

        return $this;
    }

    /**
     * Whether to render the `tab-content` container and its content. You may set this property to be false so that you
     * can manually render `tab-content` yourself in case your tab contents are complex.
     */
    public function renderTabContent(bool $value): self
    {
        $this->renderTabContent = $value;

        return $this;
    }

    /**
     * List of HTML attributes for the `tab-content` container. This will always contain the CSS class `tab-content`.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function tabContentOptions(array $value): self
    {
        $this->tabContentOptions = $value;

        return $this;
    }
}
