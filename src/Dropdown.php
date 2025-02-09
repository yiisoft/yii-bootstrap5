<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Hr;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Html\Tag\Ul;
use Yiisoft\Widget\Widget;

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 *
 * For example,
 *
 * ```php
 * echo Dropdown::widget()
 *     ->items(
 *         DropdownItem::link('Action', '#'),
 *         DropdownItem::link('Another action', '#'),
 *         DropdownItem::link('Something else here', '#'),
 *         DropdownItem::divider(),
 *         DropdownItem::link('Separated link', '#'),
 *     )
 *     ->toggleContent('Toggle dropdown')
 *     ->toggleVariant(DropdownToggleVariant::DANGER)
 *     ->toggleSplit()
 *     ->toggleSplitContent('Danger')
 *     ->toggleSizeLarge()
 *     ->render();
 * ```
 */
final class Dropdown extends Widget
{
    private const DROPDOWN_CLASS = 'dropdown';
    private const DROPDOWN_ITEM_ACTIVE_CLASS = 'active';
    private const DROPDOWN_ITEM_CLASS = 'dropdown-item';
    private const DROPDOWN_ITEM_DISABLED_CLASS = 'disabled';
    private const DROPDOWN_ITEM_DIVIDER_CLASS = 'dropdown-divider';
    private const DROPDOWN_ITEM_HEADER_CLASS = 'dropdown-header';
    private const DROPDOWN_ITEM_TEXT_CLASS = 'dropdown-item-text';
    private const DROPDOWN_LIST_CLASS = 'dropdown-menu';
    private const DROPDOWN_TOGGLE_BUTTON_CLASS = 'btn';
    private const DROPDOWN_TOGGLE_CLASS = 'dropdown-toggle';
    private const DROPDOWN_TOGGLE_CONTAINER_CLASS = 'btn-group';
    private const DROPDOWN_TOGGLE_SPAN_CLASS = 'visually-hidden';
    private const DROPDOWN_TOGGLE_SPLIT_CLASS = 'dropdown-toggle-split';
    private const NAME = 'dropdown';
    private array $alignmentClasses = [];
    private array $attributes = [];
    private array $cssClasses = [];
    private bool $container = true;
    private array $containerClasses = [self::DROPDOWN_CLASS];
    /** @psalm-var DropdownItem[] */
    private array $items = [];
    private array $toggleAttributes = [];
    private array $toggleClasses = [];
    private string|Stringable $toggleButton = '';
    private string $toggleContent = 'Dropdown button';
    private bool|string $toggleId = false;
    private bool $toggleLink = false;
    private string $toggleUrl = '#';
    private string|null $toggleSize = null;
    private bool $toggleSplit = false;
    private string $toggleSplitContent = 'Action';
    private DropdownToggleVariant $toggleVariant = DropdownToggleVariant::SECONDARY;

    /**
     * Adds a set of attributes for the dropdown component.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-dropdown']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the dropdown component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $dropdown->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style for the dropdown component.
     *
     * @param array|string $style The CSS style for the dropdown component.
     * If a string is used, it's added as is. For example, `color: red`.
     * If the value is an array, the values are separated by a space,
     * e.g., `['color' => 'red', 'font-weight' => 'bold']` is rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the alignment of the dropdown component.
     *
     * @param DropdownAlignment|null ...$alignment The alignment of the dropdown component. If `null`, the alignment will
     * not be set.
     *
     * @return self A new instance with the specified alignment of the dropdown component.
     */
    public function alignment(DropdownAlignment|null ...$alignment): self
    {
        $new = clone $this;
        $new->alignmentClasses = $alignment;

        return $new;
    }

    /**
     * Adds a set of attributes for the dropdown toggle button.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-dropdown']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addToggleAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->toggleAttributes = [...$this->toggleAttributes, ...$attributes];

        return $new;
    }

    /**
     * Sets the HTML attributes for the dropdown component.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the auto-close setting for the dropdown component.
     *
     * @param DropdownAutoClose $autoClose The auto-close setting for the dropdown component.
     *
     * @return self A new instance with the specified auto-close setting.
     */
    public function autoClose(DropdownAutoClose $autoClose): self
    {
        return $this->addToggleAttributes(['data-bs-auto-close' => $autoClose->value]);
    }

    /**
     * Replaces all existing CSS classes of the dropdown component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $dropdown->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Whether to render the dropdown in a container `<div>` tag.
     *
     * @param bool $enabled Whether to render the dropdown in a container `<div>` tag. By default, it will be rendered in
     * a container `<div>` tag. If set to `false`, the container will not be rendered.
     *
     * @return self A new instance with the specified container setting.
     */
    public function container(bool $enabled): self
    {
        $new = clone $this;
        $new->container = $enabled;

        return $new;
    }

    /**
     * Sets the CSS classes for the dropdown container.
     *
     * @param BackedEnum|string ...$classes The CSS class for the dropdown container.
     *
     * @return self A new instance with the specified CSS class for the dropdown container.
     */
    public function containerClasses(BackedEnum|string ...$classes): self
    {
        $new = clone $this;
        $new->containerClasses = $classes;

        return $new;
    }

    /**
     * Set the direction of the dropdown component.
     *
     * @param DropdownDirection $direction The direction of the dropdown component.
     *
     * @return self A new instance with the specified direction of the dropdown component.
     */
    public function direction(DropdownDirection $direction): self
    {
        $new = clone $this;
        $new->containerClasses = [$direction];

        return $new;
    }

    /**
     * Returns the list of links to appear in the dropdown.
     *
     * @return DropdownItem[] The links to appear in the dropdown.
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * List of links to appear in the dropdown. If this property is empty, the widget will not render anything.
     *
     * @param array $items The links to appear in the dropdown.
     *
     * @return self A new instance with the specified dropdown to appear in the dropdown.
     *
     * @psalm-param DropdownItem[] $items The links to appear in the dropdown.
     */
    public function items(DropdownItem ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the theme for the dropdown component.
     *
     * @param string $theme The theme for the dropdown component.
     *
     * @return self A new instance with the specified theme.
     */
    public function theme(string $theme): self
    {
        return $this->addAttributes(['data-bs-theme' => $theme === '' ? null : $theme]);
    }

    /**
     * Sets the HTML attributes for the dropdown toggle button.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the dropdown toggle button.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function toggleAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->toggleAttributes = $attributes;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the dropdown toggle button with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $dropdown->toggleClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function toggleClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->toggleClasses = $class;

        return $new;
    }

    /**
     * Sets the toggle button custom tag.
     *
     * @param string|Stringable $tag The toggle button custom tag.
     *
     * @return self A new instance with the specified toggle button custom tag.
     */
    public function toggleTag(string|Stringable $tag): self
    {
        $new = clone $this;
        $new->toggleButton = (string) $tag;

        return $new;
    }

    /**
     * Sets the content of the dropdown toggle button.
     *
     * @param string|Stringable $content The content of the dropdown toggle button.
     *
     * @return self A new instance with the specified content of the dropdown toggle button.
     */
    public function toggleContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->toggleContent = (string) $content;

        return $new;
    }

    /**
     * Sets the ID of the toggle button for the dropdown component.
     *
     * @param bool|string $id The ID of the dropdown component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID of the toggle button for the dropdown component.
     *@throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     */
    public function toggleId(bool|string $id): self
    {
        $new = clone $this;
        $new->toggleId = $id;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle as a link.
     *
     * @param bool $enable Whether to render the dropdown toggle as a link. If set to `true`, the dropdown toggle will be
     * rendered as a link. If set to `false`, the dropdown toggle will be rendered as a button.
     *
     * @return self A new instance with the specified dropdown toggle as a link setting.
     */
    public function toggleAsLink(bool $enable = true): self
    {
        $new = clone $this;
        $new->toggleLink = $enable;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a large button.
     *
     * @param bool $enable Whether to render the dropdown toggle button as a large button. If set to `true`, the dropdown
     * toggle button will be rendered as a large button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal-sized button.
     *
     * @return self A new instance with the specified dropdown toggle button size large setting.
     */
    public function toggleSizeLarge(bool $enable = true): self
    {
        $new = clone $this;
        $new->toggleSize = $enable ? 'btn-lg' : null;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a small button.
     *
     * @param bool $enable Whether to render the dropdown toggle button as a small button. If set to `true`, the dropdown
     * toggle button will be rendered as a small button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal-sized button.
     *
     * @return self A new instance with the specified dropdown toggle button size small setting.
     */
    public function toggleSizeSmall(bool $enable = true): self
    {
        $new = clone $this;
        $new->toggleSize = $enable ? 'btn-sm' : null;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a split button.
     *
     * @param bool $enable Whether to render the dropdown toggle button as a split button. If set to `true`, the dropdown
     * toggle button will be rendered as a split button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal button.
     *
     * @return self A new instance with the specified dropdown toggle button split setting.
     */
    public function toggleSplit(bool $enable = true): self
    {
        $new = clone $this;
        $new->toggleSplit = $enable;

        return $new;
    }

    /**
     * Sets the content of the dropdown toggle split button.
     *
     * @param string|Stringable $content The content of the dropdown toggle split button.
     *
     * @return self A new instance with the specified content of the dropdown toggle split button.
     */
    public function toggleSplitContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->toggleSplitContent = (string) $content;

        return $new;
    }

    /**
     * Sets the URL for the dropdown toggle link.
     *
     * @param string $url The URL for the dropdown toggle link.
     *
     * @return self A new instance with the specified URL for the dropdown toggle link.
     */
    public function toggleUrl(string $url): self
    {
        $new = clone $this;
        $new->toggleUrl = $url;

        return $new;
    }

    /**
     * Sets the variant for the dropdown toggle button.
     *
     * @param DropdownToggleVariant $variant The variant for the dropdown toggle button.
     *
     * @return self A new instance with the specified variant for the dropdown toggle button.
     */
    public function toggleVariant(DropdownToggleVariant $variant): self
    {
        $new = clone $this;
        $new->toggleVariant = $variant;

        return $new;
    }

    /**
     * Renders the dropdown component.
     *
     * @return string The rendering result.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;
        $containerClasses = $this->containerClasses;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        /** @psalm-var non-empty-string|null $id */
        $toggleId = match ($this->toggleId) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->toggleId,
        };

        if ($this->toggleSplit) {
            $containerClasses = [self::DROPDOWN_TOGGLE_CONTAINER_CLASS];
        }

        Html::addCssClass($attributes, [...$containerClasses, $classes, ...$this->cssClasses]);

        $renderToggle = match ($this->toggleSplit) {
            true => $this->renderToggleSplit() . "\n" . $this->renderToggle($toggleId),
            false => $this->renderToggle($toggleId),
        };

        $renderItems = $this->renderItems($toggleId);

        return match ($this->container) {
            true => Div::tag()
                ->addAttributes($attributes)
                ->addContent(
                    "\n",
                    $renderToggle,
                    "\n",
                    $renderItems,
                    "\n",
                )
                ->encode(false)
                ->render(),
            false => $renderToggle . "\n" . $renderItems,
        };
    }

    /**
     * Renders the dropdown item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItem(DropdownItem $item): Li
    {
        return match ($item->getType()) {
            'button' => $this->renderItemButton($item),
            'custom-content' => $this->renderListContentItem($item),
            'divider' => $this->renderItemDivider($item),
            'header' => $this->renderItemHeader($item),
            'link' => $this->renderItemLink($item),
            'text' => $this->renderItemText($item),
        };
    }

    /**
     * Renders the dropdown button item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItemButton(DropdownItem $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent(
                "\n",
                Button::button('')
                    ->addAttributes($item->getItemAttributes())
                    ->addContent($item->getContent())
                    ->addClass(self::DROPDOWN_ITEM_CLASS),
                "\n"
            );
    }

    /**
     * Renders the dropdown divider item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItemDivider(DropdownItem $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent(
                "\n",
                Hr::tag()->addAttributes($item->getItemAttributes())->addClass(self::DROPDOWN_ITEM_DIVIDER_CLASS),
                "\n"
            );
    }

    /**
     * Renders the dropdown header item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItemHeader(DropdownItem $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent(
                "\n",
                Html::tag($item->getHeaderTag())
                    ->addAttributes($item->getItemAttributes())
                    ->addClass(self::DROPDOWN_ITEM_HEADER_CLASS)
                    ->content($item->getContent()),
                "\n"
            );
    }

    /**
     * Renders the dropdown link item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItemLink(DropdownItem $item): Li
    {
        $itemAttributes = $item->getItemAttributes();
        Html::addCssClass($itemAttributes, self::DROPDOWN_ITEM_CLASS);

        if ($item->isActive()) {
            Html::addCssClass($itemAttributes, self::DROPDOWN_ITEM_ACTIVE_CLASS);
            $itemAttributes['aria-current'] = 'true';
        }

        if ($item->isDisabled()) {
            Html::addCssClass($itemAttributes, self::DROPDOWN_ITEM_DISABLED_CLASS);
            $itemAttributes['aria-disabled'] = 'true';
        }

        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent(
                "\n",
                A::tag()->addAttributes($itemAttributes)->content($item->getContent())->url($item->getUrl()),
                "\n",
            );
    }

    /**
     * Renders the dropdown custom content item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderListContentItem(DropdownItem $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent("\n", $item->getContent(), "\n")
            ->encode(false);
    }

    /**
     * Renders the dropdown text item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItemText(DropdownItem $item): Li
    {
        return Li::tag()
            ->addAttributes($item->getAttributes())
            ->addContent(
                "\n",
                Span::tag()
                    ->addAttributes($item->getItemAttributes())
                    ->addClass(self::DROPDOWN_ITEM_TEXT_CLASS)
                    ->content($item->getContent())
                    ->encode(false),
                "\n"
            );
    }

    /**
     * Renders the dropdown items.
     *
     * @param string|null $toggleId The ID of the toggle button.
     *
     * @return string The rendering result.
     *
     * @psalm-param non-empty-string|null $toggleId
     */
    private function renderItems(string|null $toggleId): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        $ulTag = Ul::tag()
            ->addAttributes(['aria-labelledby' => $toggleId])
            ->addClass(self::DROPDOWN_LIST_CLASS, ...$this->alignmentClasses)
            ->items(...$items);

        return $ulTag->render();
    }

    /**
     * Renders the dropdown toggle button.
     *
     * @param string|null $toggleId The ID of the toggle button.
     *
     * @return string The rendering result.
     *
     * @psalm-param non-empty-string|null $toggleId
     */
    private function renderToggle(string|null $toggleId): string
    {
        if ($this->toggleButton !== '') {
            return (string) $this->toggleButton;
        }

        $toggleContent = match ($this->toggleSplit) {
            true => "\n" .
                Span::tag()
                    ->addContent($this->toggleContent)
                    ->addClass(self::DROPDOWN_TOGGLE_SPAN_CLASS)
                    ->render() .
                "\n",
            default => $this->toggleContent,
        };

        $toggleAttributes = $this->toggleAttributes;
        $toggleClasses = $this->toggleClasses;
        $classes = $toggleAttributes['class'] ?? null;

        unset($toggleAttributes['class']);

        match ($toggleClasses) {
            [] => Html::addCssClass(
                $toggleAttributes,
                [
                    self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                    $this->toggleVariant,
                    $this->toggleSize,
                    self::DROPDOWN_TOGGLE_CLASS,
                    $this->toggleSplit ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
                    $classes,
                ],
            ),
            default => Html::addCssClass($toggleAttributes, $toggleClasses),
        };

        if ($this->toggleLink) {
            return $this->renderToggleLink($toggleAttributes, $toggleContent);
        }

        $toggleAttributes['data-bs-toggle'] = 'dropdown';
        $toggleAttributes['aria-expanded'] = 'false';

        return Button::button('')
            ->addAttributes($toggleAttributes)
            ->addContent($toggleContent)
            ->encode(false)
            ->id($toggleId)
            ->render();
    }

    /**
     * Renders the dropdown toggle link.
     *
     * @param array $toggleAttributes The HTML attributes for the toggle link.
     * @param string $toggleContent The content of the toggle link.
     *
     * @return string The rendering result.
     */
    private function renderToggleLink(array $toggleAttributes, string $toggleContent): string
    {
        $toggleAttributes['role'] = 'button';
        $toggleAttributes['data-bs-toggle'] = 'dropdown';
        $toggleAttributes['aria-expanded'] = 'false';

        return A::tag()
            ->addAttributes($toggleAttributes)
            ->addContent($toggleContent)
            ->encode(false)
            ->url($this->toggleUrl)
            ->render();
    }

    /**
     * Renders the dropdown split button.
     *
     * @return string The rendering result.
     */
    private function renderToggleSplit(): string
    {
        if ($this->toggleLink) {
            return A::tag()
                ->addAttributes(
                    [
                        'role' => 'button',
                    ],
                )
                ->addClass(
                    self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                    $this->toggleVariant,
                    $this->toggleSize,
                )
                ->addContent($this->toggleSplitContent)
                ->encode(false)
                ->render();
        }

        return Button::button('')
            ->addClass(
                self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                $this->toggleVariant,
                $this->toggleSize,
            )
            ->addContent($this->toggleSplitContent)
            ->encode(false)
            ->render();
    }
}
