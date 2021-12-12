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
 *             'options' => [...],
 *             'paneOptions' => ['id' => 'myveryownID'],
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
    public const NAV_PILLS = 'nav-pills';

    private array $items = [];
    private bool $encodeTags = false;
    private string $navType = 'nav-tabs';
    private bool $renderTabContent = true;
    private array $tabContentOptions = [];
    private array $paneOptions = [];
    private array $panes = [];
    private Nav $nav;
    private array $navOptions = [];

    public function getId(?string $suffix = '-tabs'): ?string
    {
        return $this->navOptions['options']['id'] ?? parent::getId('-tabs');
    }

    protected function beforeRun(): bool
    {
        Html::addCssClass($this->tabContentOptions, ['tabContentOptions' => 'tab-content']);

        $navOptions = $this->prepareNavOptions();
        $this->prepareItems($this->items, $navOptions['options']['id']);
        $this->nav = $this->prepareNav($navOptions, $this->items);

        return parent::beforeRun();
    }

    protected function run(): string
    {
        return $this->nav->render() . $this->renderPanes($this->panes);
    }

    /**
     * Set all options for nav widget
     *
     * @param array $options
     * @param bool $replace
     *
     * @return self
     */
    public function navOptions(array $options, bool $replace = true): self
    {
        $new = clone $this;

        if ($replace) {
            $new->navOptions = $options;
        } else {
            $new->navOptions = array_merge($new->navOptions, $options);
        }

        return $new;
    }

    /**
     * Set allowed option for Nav::widget
     *
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function navOption(string $name, $value): self
    {
        $new = clone $this;
        $new->navOptions[$name] = $value;

        return $new;
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     *
     * @param string $value
     *
     * @return self
     */
    public function dropdownClass(string $value): self
    {
        return $this->navOption('dropdownClass', $value);
    }

    /**
     * Base options for nav
     *
     * @param array $options
     *
     * @return self
     */
    public function dropdownOptions(array $options): self
    {
        return $this->navOption('dropdownOptions', $options);
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        return $this->navOption('withoutEncodeLabels', false);
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
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * List of HTML attributes for the header container tags. This will be overwritten by the "options" set in
     * individual {@see items}.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     * {@see Nav::itemOptions()}
     *
     * @param array $value
     *
     * @return self
     */
    public function itemOptions(array $value): self
    {
        return $this->navOption('itemOptions', $value);
    }

    /**
     * Options for each item link if not present in current item
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     * {@see Nav::linkOptions()}
     *
     * @param array $options
     *
     * @return self
     */
    public function linkOptions(array $value): self
    {
        return $this->navOption('linkOptions', $value);
    }

    /**
     * List of HTML attributes for the item container tags. This will be overwritten by the "options" set in individual
     * {@see items}. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function paneOptions(array $options): self
    {
        $new = clone $this;
        $new->paneOptions = $options;

        return $new;
    }

    /**
     * Specifies the Bootstrap tab styling.
     *
     * @param string $value
     *
     * @return self
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
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        return $this->navOption('options', $value);
    }

    /**
     * Tab panes (contents).
     *
     * @param array $value
     *
     * @return self
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
     * @return self
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
     * @return self
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
        return $this->renderTabContent
            ? ("\n" . Html::div(implode("\n", $panes), $this->tabContentOptions)->encode($this->encodeTags))
            : '';
    }

    /**
     * Prepare Nav::widget for using
     *
     * @param array $options
     * @param array $items
     *
     * @return Nav
     */
    private function prepareNav(array $options, array $items): Nav
    {
        $definitions = [];

        foreach ($options as $name => $value) {
            $definitions[$name . '()'] = [$value];
        }

        return Nav::widget($definitions)->items($items);
    }

    /**
     * Prepare options to send it to Nav::widget
     *
     * @return array
     */
    private function prepareNavOptions(): array
    {
        $navOptions = $this->navOptions;
        $navOptions['options']['id'] = $this->getId();

        if (!isset($navOptions['options']['role'])) {
            $navOptions['options']['role'] = 'tablist';
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($navOptions['options'], ['widget' => 'nav', $this->navType]);

        return $navOptions;
    }

    /**
     * Renders tab items as specified on {@see items}.
     *
     * @param array $items
     * @param string $navId
     * @param string $prefix
     *
     * @throws JsonException|RuntimeException
     */
    private function prepareItems(array &$items, ?string $navId, string $prefix = ''): void
    {
        if (!$this->hasActiveTab()) {
            $this->activateFirstVisibleTab();
        }

        foreach ($items as $n => $item) {
            $options = array_merge($this->paneOptions, ArrayHelper::remove($item, 'paneOptions', []));
            $options['id'] = ArrayHelper::getValue($options, 'id', $navId . $prefix . '-tab' . $n);

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

            if (isset($item['items'])) {
                $this->prepareItems($items[$n]['items'], $navId, '-dd' . $n);
                continue;
            }

            if (isset($item['url'])) {
                continue;
            }

            if (!isset($item['linkOptions'])) {
                $items[$n]['linkOptions'] = $this->navOptions['linkOptions'] ?? [];
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
                $this->panes[] = Html::tag($tag, $item['content'] ?? '', $options)->encode($this->encodeTags)->render();
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
