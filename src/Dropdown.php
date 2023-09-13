<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

use function array_key_exists;
use function array_merge;
use function array_merge_recursive;
use function array_unique;
use function is_array;
use function is_string;

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 *
 * For example,
 *
 * ```php
 * <div class="dropdown">
 *     <?php
 *         echo Dropdown::widget()
 *             ->items([
 *                 ['label' => 'DropdownA', 'url' => '/'],
 *                 ['label' => 'DropdownB', 'url' => '#'],
 *             ]);
 *     ?>
 * </div>
 * ```
 */
final class Dropdown extends Widget
{
    public const ALIGNMENT_END = 'dropdown-menu-end';
    public const ALIGNMENT_SM_END = 'dropdown-menu-sm-end';
    public const ALIGNMENT_MD_END = 'dropdown-menu-md-end';
    public const ALIGNMENT_LG_END = 'dropdown-menu-lg-end';
    public const ALIGNMENT_XL_END = 'dropdown-menu-xl-end';
    public const ALIGNMENT_XXL_END = 'dropdown-menu-xxl-end';
    public const ALIGNMENT_SM_START = 'dropdown-menu-sm-start';
    public const ALIGNMENT_MD_START = 'dropdown-menu-md-start';
    public const ALIGNMENT_LG_START = 'dropdown-menu-lg-start';
    public const ALIGNMENT_XL_START = 'dropdown-menu-xl-start';
    public const ALIGNMENT_XXL_START = 'dropdown-menu-xxl-start';

    private array|string|Stringable|null $items = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $submenuOptions = [];
    private array $options = [];
    private array $itemOptions = [];
    private array $linkOptions = [];
    private array $alignment = [];

    private ?string $tagName = null;

    public function getId(?string $suffix = '-dropdown'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    private function prepareOptions(): array
    {
        $options = $this->options;
        $options['id'] = $this->getId();
        $classNames = array_merge(['widget' => 'dropdown-menu'], $this->alignment);

        if ($this->theme) {
            $options['data-bs-theme'] = $this->theme;

            if ($this->theme === self::THEME_DARK) {
                $classNames[] = 'dropdown-menu-dark';
            }
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, $classNames);

        return $options;
    }

    private function prepareDropdownLayout(): CustomTag|Ul
    {
        $options = $this->prepareOptions();

        if (is_array($this->items)) {
            return Html::ul()
                ->attributes($options);
        }

        $tagName = ArrayHelper::remove($options, 'tag', 'div');

        return Html::tag($tagName, '', $options)
            ->encode($this->encodeTags);
    }

    public function begin(): ?string
    {
        parent::begin();

        $options = $this->prepareOptions();
        $this->tagName = is_array($this->items) ? 'ul' : ArrayHelper::remove($options, 'tag', 'div');

        return Html::openTag($this->tagName, $options);
    }

    /**
     * @throws InvalidConfigException
     * @throws JsonException
     * @return string
     */
    public function render(): string
    {
        if ($this->tagName) {
            return Html::closeTag($this->tagName);
        }

        $layout = $this->prepareDropdownLayout();

        if (is_array($this->items)) {
            /** @var Ul $layout */
            return $this->renderItems($layout, $this->items);
        }
        /** @var CustomTag $layout */
        return $layout
            ->content((string) $this->items)
            ->render();
    }

    /**
     * List of menu items in the dropdown. Each array element can be either an HTML string, or an array representing a
     * single menu with the following structure:
     *
     * - label: string, required, the label of the item link.
     * - encode: bool, optional, whether to HTML-encode item label.
     * - url: string|array, optional, the URL of the item link. This will be processed by {@see currentPath}.
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - submenuOptions: array, optional, the HTML attributes for sub-menu container tag. If specified it will be
     *   merged with {@see submenuOptions}.
     *
     * To insert divider use `-`.
     */
    public function items(array|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->items = $value;
        $new->tagName = null;

        return $new;
    }

    /**
     * Set dropdown alignment
     * @see https://getbootstrap.com/docs/5.3/components/dropdowns/#menu-alignment
     */
    public function withAlignment(string ...$alignment): self
    {
        $new = clone $this;
        $new->alignment = array_unique($alignment);

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

    public function withEncodeTags(bool $encode): self
    {
        $new = clone $this;
        $new->encodeTags = $encode;

        return $new;
    }

    /**
     * The HTML attributes for sub-menu container tags.
     */
    public function submenuOptions(array $value): self
    {
        $new = clone $this;
        $new->submenuOptions = $value;

        return $new;
    }

    /**
     * @param array $value the HTML attributes for the widget container tag. The following special options are
     * recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;
        $new->tagName = null;

        return $new;
    }

    /**
     * Options for each item if not present in self
     */
    public function itemOptions(array $options): self
    {
        $new = clone $this;
        $new->itemOptions = $options;

        return $new;
    }

    /**
     * Options for each item link if not present in current item
     */
    public function linkOptions(array $options): self
    {
        $new = clone $this;
        $new->linkOptions = $options;

        return $new;
    }

    /**
     * Renders menu items.
     *
     * @param array $items the menu items to be rendered
     *
     * @throws InvalidConfigException|JsonException|RuntimeException if the label option is not specified in one of the
     * items.
     * @return string the rendering result.
     */
    private function renderItems(Ul $layout, array $items): string
    {
        $lines = [];

        foreach ($items as $item) {
            if (is_string($item)) {
                $item = ['label' => $item, 'encode' => false, 'enclose' => false];
            }

            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            if (!array_key_exists('label', $item)) {
                throw new RuntimeException("The 'label' option is required.");
            }

            $lines[] = $this->renderItem($item);
        }

        return $layout
            ->items(...$lines)
            ->render();
    }

    /**
     * Render current dropdown item
     */
    private function renderItem(array $item): Li
    {
        $url = $item['url'] ?? null;
        $encodeLabel = $item['encode'] ?? $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $itemOptions = ArrayHelper::getValue($item, 'options', $this->itemOptions);
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', $this->linkOptions);
        $active = ArrayHelper::getValue($item, 'active', false);
        $disabled = ArrayHelper::getValue($item, 'disabled', false);
        $enclose = ArrayHelper::getValue($item, 'enclose', true);

        if ($url !== null) {
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-item']);

            if ($disabled) {
                ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
                ArrayHelper::setValue($linkOptions, 'aria-disabled', 'true');
                Html::addCssClass($linkOptions, ['disable' => 'disabled']);
            } elseif ($active) {
                Html::addCssClass($linkOptions, ['active' => 'active']);
            }
        }

        /** @psalm-suppress ConflictingReferenceConstraint */
        if (empty($item['items'])) {
            if ($url !== null) {
                $content = Html::a($label, $url, $linkOptions)->encode($this->encodeTags);
            } elseif ($label === '-') {
                Html::addCssClass($linkOptions, ['widget' => 'dropdown-divider']);
                $content = Html::tag('hr', '', $linkOptions);
            } elseif ($enclose === false) {
                $content = $label;
            } else {
                Html::addCssClass($linkOptions, ['widget' => 'dropdown-header']);
                $tag = ArrayHelper::remove($linkOptions, 'tag', 'h6');
                $content = Html::tag($tag, $label, $linkOptions);
            }

            return Li::tag()
                ->content($content)
                ->attributes($itemOptions)
                ->encode(false);
        }

        $submenuOptions = $this->submenuOptions;

        if (isset($item['submenuOptions'])) {
            $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
        }

        Html::addCssClass($submenuOptions, ['submenu' => 'dropdown-menu']);
        Html::addCssClass($linkOptions, [
            'widget' => 'dropdown-item',
            'toggle' => 'dropdown-toggle',
        ]);

        $itemOptions = array_merge_recursive(['class' => ['dropdown'], 'aria-expanded' => 'false'], $itemOptions);

        $dropdown = self::widget()
            ->items($item['items'])
            ->options($submenuOptions)
            ->submenuOptions($submenuOptions);

        if ($this->encodeLabels === false) {
            $dropdown = $dropdown->withoutEncodeLabels();
        }

        ArrayHelper::setValue($linkOptions, 'data-bs-toggle', 'dropdown');
        ArrayHelper::setValue($linkOptions, 'data-bs-auto-close', 'outside');
        ArrayHelper::setValue($linkOptions, 'aria-haspopup', 'true');
        ArrayHelper::setValue($linkOptions, 'aria-expanded', 'false');
        ArrayHelper::setValue($linkOptions, 'role', 'button');

        $toggle = Html::a($label, $url, $linkOptions)->encode($this->encodeTags);

        return Li::tag()
            ->content($toggle . $dropdown->render())
            ->attributes($itemOptions)
            ->encode(false);
    }
}
