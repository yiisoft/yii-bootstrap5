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
 *
 * @psalm-suppress MissingConstructor
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
    private array $navDefinitions = [];

    public function getId(?string $suffix = '-tabs'): ?string
    {
        return $this->navDefinitions['options']['id'] ?? parent::getId($suffix);
    }

    public function render(): string
    {
        Html::addCssClass($this->tabContentOptions, ['tabContentOptions' => 'tab-content']);

        $navDefinitions = $this->prepareNavDefinitions();
        $this->prepareItems($this->items, $navDefinitions['options']['id']);
        $this->nav = $this->prepareNav($navDefinitions, $this->items);

        return $this->nav->render() . $this->renderPanes($this->panes);
    }

    /**
     * Set all options for nav widget
     */
    public function navDefinitions(array $definitions, bool $replace = true): self
    {
        $new = clone $this;

        if ($replace) {
            $new->navDefinitions = $definitions;
        } else {
            $new->navDefinitions = array_merge($new->navDefinitions, $definitions);
        }

        return $new;
    }

    /**
     * Set allowed option for Nav::widget
     */
    public function navDefinition(string $name, mixed $value): self
    {
        return $this->navDefinitions([$name => $value], false);
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     */
    public function dropdownClass(string $value): self
    {
        return $this->navDefinition('dropdownClass', $value);
    }

    /**
     * Base options for nav
     */
    public function dropdownOptions(array $options): self
    {
        return $this->navDefinition('dropdownOptions', $options);
    }

    /**
     * When tags Labels HTML should not be encoded.
     */
    public function withoutEncodeLabels(): self
    {
        return $this->navDefinition('withoutEncodeLabels', false);
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
     */
    public function itemOptions(array $value): self
    {
        return $this->navDefinition('itemOptions', $value);
    }

    /**
     * Options for each item link if not present in current item
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     * {@see Nav::linkOptions()}
     */
    public function linkOptions(array $value): self
    {
        return $this->navDefinition('linkOptions', $value);
    }

    /**
     * List of HTML attributes for the item container tags. This will be overwritten by the "options" set in individual
     * {@see items}. The following special options are recognized.
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
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        return $this->navDefinition('options', $value);
    }

    /**
     * Tab panes (contents).
     */
    public function panes(array $value): self
    {
        $new = clone $this;
        $new->panes = $value;

        return $new;
    }

    /**
     * Manually render `tab-content` yourself in case your tab contents are complex.
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
     */
    private function prepareNav(array $definitions, array $items): Nav
    {
        $widgetDefinitions = [];

        foreach ($definitions as $name => $value) {
            $widgetDefinitions[$name . '()'] = [$value];
        }

        return Nav::widget([], $widgetDefinitions)->items($items);
    }

    /**
     * Prepare options to send it to Nav::widget
     */
    private function prepareNavDefinitions(): array
    {
        $definitions = $this->navDefinitions;
        $definitions['options']['id'] = $this->getId();

        if (!isset($definitions['options']['role'])) {
            $definitions['options']['role'] = 'tablist';
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($definitions['options'], ['widget' => 'nav', $this->navType]);

        return $definitions;
    }

    /**
     * Renders tab items as specified on {@see items}.
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
                $items[$n]['linkOptions'] = $this->navDefinitions['linkOptions'] ?? [];
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
                $this->panes[] = Html::tag($tag, $item['content'] ?? '', $options)
                    ->encode($this->encodeTags)
                    ->render();
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
