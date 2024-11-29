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

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 *
 * For example,
 *
 * ```php
 * ```
 */
final class Dropdown extends \Yiisoft\Widget\Widget
{
    private const DROPDOWN_CLASS = 'dropdown';
    private const DROPDOWN_DIVIDER_CLASS = 'dropdown-divider';
    private const DROPDOWN_ITEM_CLASS = 'dropdown-item';
    private const DROPDOWN_ITEM_ACTIVE_CLASS = 'active';
    private const DROPDOWN_ITEM_DISABLED_CLASS = 'disabled';
    private const DROPDOWN_ITEM_TEXT_CLASS = 'dropdown-item-text';
    private const DROPDOWN_LIST_CLASS = 'dropdown-menu';
    private const DROPDOWN_TOGGLE_BUTTON_CLASS = 'btn';
    private const DROPDOWN_TOGGLE_CLASS = 'dropdown-toggle';
    private const DROPDOWN_TOGGLE_CONTAINER_CLASS = 'btn-group';
    private const DROPDOWN_TOGGLE_SPAN_CLASS = 'visually-hidden';
    private const DROPDOWN_TOGGLE_SPLIT_CLASS = 'dropdown-toggle-split';
    private const NAME = 'dropdown';
    private array $attributes = [];
    private array $cssClass = [];
    private bool $container = true;
    private BackedEnum|string $containerClass = self::DROPDOWN_CLASS;
    private bool|string $id = false;
    private string $itemTag = 'a';
    /** @psalm-var DropdownItem[] */
    private array $items = [];
    private array $itemsClass = [];
    private array $listClass = [];
    private string|Stringable $toggleButton = '';
    private string $toggleContent = 'Dropdown button';
    private bool $toggleLink = false;
    private string $toggleUrl = '#';
    private string|null $toggleSize = null;
    private bool $toggleSplit = false;
    private string $toggleSplitContent = 'Action';
    private DropdownToggleVariant $toggleVariant = DropdownToggleVariant::SECONDARY;

    /**
     * Adds a set of attributes for the dropdown component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-dropdown']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $values);

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the dropdown component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to add. Pass `null` to skip adding a class.
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
    public function addClass(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = array_merge($new->cssClass, $value);

        return $new;
    }

    /**
     * Adds a CSS style for the dropdown component.
     *
     * @param array|string $value The CSS style for the dropdown component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the dropdown component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the dropdown component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $dropdown->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = $value;

        return $new;
    }

    /**
     * Whether to render the dropdown in a container `<div>` tag.
     *
     * @param bool $value Whether to render the dropdown in a container `<div>` tag. For default, it will be rendered in
     * a container `<div>` tag. If set to `false`, the container will not be rendered.
     *
     * @return self A new instance with the specified container setting.
     */
    public function container(bool $value): self
    {
        $new = clone $this;
        $new->container = $value;

        return $new;
    }

    /**
     * Sets the CSS class for the dropdown container.
     *
     * @param BackedEnum|string $value The CSS class for the dropdown container.
     *
     * @return self A new instance with the specified CSS class for the dropdown container.
     */
    public function containerClass(BackedEnum|string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;

        return $new;
    }

    /**
     * Set the direction of the dropdown component. The following options are allowed:
     *
     * - `DropdownDirection::CENTERED`: Make the dropdown menu centered below the toggle with `.dropdown-center` on the
     * parent element.
     * - `DropdownDirection::DROPUP`: Trigger dropdown menus above elements by adding `.dropup` to the parent element.
     * - `DropdownDirection::DROPUP_CENTERED`: Make the dropup menu centered above the toggle with `.dropup-center` on
     * the parent element.
     * - `DropdownDirection::DROPEND`: Trigger dropdown menus at the right of the elements by adding `.dropend` to the
     * parent element.
     * - `DropdownDirection::DROPSTART`: Trigger dropdown menus at the left of the elements by adding `.dropstart` to
     * the parent element.
     *
     * @param DropdownDirection $value The direction of the dropdown component.
     *
     * @return self A new instance with the specified direction of the dropdown component.
     */
    public function direction(DropdownDirection $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;

        return $new;
    }

    /**
     * Sets the ID of the dropdown component.
     *
     * @param bool|string $value The ID of the dropdown component. If `true`, an ID will be generated automatically.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Sets the tag name for the dropdown items.
     *
     * @param string $value The tag name for the dropdown items. Defaults to 'a'.
     *
     * @return self A new instance with the specified tag name for the dropdown items.
     */
    public function itemTag(string $value): self
    {
        if ($value === '' || in_array($value, ['a', 'button'], true) === false) {
            throw new InvalidArgumentException('The item tag must be either "a" or "button".');
        }

        $new = clone $this;
        $new->itemTag = $value;

        return $new;
    }

    /**
     * List of links to appear in the dropdown. If this property is empty, the widget will not render anything.
     *
     * @param array $value The links to appear in the dropdown.
     *
     * @return self A new instance with the specified dropdown to appear in the dropdown.
     *
     * @psalm-param DropdownItem[] $value The links to appear in the dropdown.
     */
    public function items(DropdownItem ...$value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Sets the theme for the dropdown component.
     *
     * @param string $value The theme for the dropdown component.
     *
     * @return self A new instance with the specified theme.
     */
    public function theme(string $value): self
    {
        return $this
            ->addAttributes(['data-bs-theme' => $value === '' ? null : $value])
            ->id($this->id === false ? true : $this->id);
    }

    /**
     * Sets the toggle button custom tag.
     *
     * @param string|Stringable $value The toggle button custom tag.
     *
     * @return self A new instance with the specified toggle button custom tag.
     */
    public function toggleButton(string|Stringable $value): self
    {
        $new = clone $this;
        $new->toggleButton = (string) $value;

        return $new;
    }

    /**
     * Sets the content of the dropdown toggle button.
     *
     * @param string|Stringable $value The content of the dropdown toggle button.
     *
     * @return self A new instance with the specified content of the dropdown toggle button.
     */
    public function toggleContent(string|Stringable $value): self
    {
        $new = clone $this;
        $new->toggleContent = (string) $value;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle as a link.
     *
     * @param string|Stringable $value Whether to render the dropdown toggle as a link. If set to `true`, the dropdown
     * toggle will be rendered as a link. If set to `false`, the dropdown toggle will be rendered as a button.
     *
     * @return self A new instance with the specified dropdown toggle as a link setting.
     */
    public function toggleLink(bool $value = true): self
    {
        $new = clone $this;
        $new->toggleLink = $value;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a large button.
     *
     * @param string|Stringable $value Whether to render the dropdown toggle button as a large button. If set to `true`,
     * the dropdown toggle button will be rendered as a large button. If set to `false`, the dropdown toggle button will
     * be rendered as a normal-sized button.
     *
     * @return self A new instance with the specified dropdown toggle button size large setting.
     */
    public function toggleSizeLarge(bool $value = true): self
    {
        $new = clone $this;
        $new->toggleSize = $value === true ? 'btn-lg' : null;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a small button.
     *
     * @param string|Stringable $value Whether to render the dropdown toggle button as a small button. If set to `true`,
     * the dropdown toggle button will be rendered as a small button. If set to `false`, the dropdown toggle button will
     * be rendered as a normal-sized button.
     *
     * @return self A new instance with the specified dropdown toggle button size small setting.
     */
    public function toggleSizeSmall(bool $value = true): self
    {
        $new = clone $this;
        $new->toggleSize = $value === true ? 'btn-sm' : null;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a split button.
     *
     * @param bool $value Whether to render the dropdown toggle button as a split button. If set to `true`, the dropdown
     * toggle button will be rendered as a split button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal button.
     *
     * @return self A new instance with the specified dropdown toggle button split setting.
     */
    public function toggleSplit(bool $value = true): self
    {
        $new = clone $this;
        $new->toggleSplit = $value;

        return $new;
    }

    /**
     * Sets the content of the dropdown toggle split button.
     *
     * @param string|Stringable $value The content of the dropdown toggle split button.
     *
     * @return self A new instance with the specified content of the dropdown toggle split button.
     */
    public function toggleSplitContent(string $value): self
    {
        $new = clone $this;
        $new->toggleSplitContent = $value;

        return $new;
    }

    /**
     * Sets the URL for the dropdown toggle link.
     *
     * @param string $value The URL for the dropdown toggle link.
     *
     * @return self A new instance with the specified URL for the dropdown toggle link.
     */
    public function toggleUrl(string $value): self
    {
        $new = clone $this;
        $new->toggleUrl = $value;

        return $new;
    }

    /**
     * Sets the variant for the dropdown toggle button.
     *
     * @param DropdownToggleVariant $value The variant for the dropdown toggle button.
     *
     * @return self A new instance with the specified variant for the dropdown toggle button.
     */
    public function toggleVariant(DropdownToggleVariant $value): self
    {
        $new = clone $this;
        $new->toggleVariant = $value;

        return $new;
    }

    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;
        $containerClass = $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_CONTAINER_CLASS : $this->containerClass;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        Html::addCssClass($attributes, [$containerClass, $classes, ...$this->cssClass]);

        $renderToggle = match ($this->toggleSplit) {
            true => $this->renderToggleSplit() . "\n" . $this->renderToggle($id),
            false => $this->renderToggle($id),
        };

        $renderItems = $this->renderItems($id);

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

    private function renderItem(DropdownItem $item): Li
    {
        if ($item->isDivider()) {
            return Li::tag()->addContent("\n", Hr::tag()->addClass(self::DROPDOWN_DIVIDER_CLASS), "\n");
        }

        if ($item->isText()) {
            return Li::tag()
                ->addContent(
                    "\n",
                    Span::tag()->addClass(self::DROPDOWN_ITEM_TEXT_CLASS)->addContent($item->getLabel()),
                    "\n"
                );
        }

        $linkAttributes = $item->getAttributes();

        Html::addCssClass($linkAttributes, [self::DROPDOWN_ITEM_CLASS]);

        if ($item->isActive()) {
            Html::addCssClass($linkAttributes, self::DROPDOWN_ITEM_ACTIVE_CLASS);
            $linkAttributes['aria-current'] = 'true';
        }

        if ($item->isDisabled()) {
            Html::addCssClass($linkAttributes, self::DROPDOWN_ITEM_DISABLED_CLASS);
            $linkAttributes['aria-disabled'] = 'true';
        }

        $liTag = Li::tag()
            ->addContent(
                "\n",
                Html::tag($this->itemTag)
                    ->addAttributes($linkAttributes)
                    ->addContent($item->getLabel())
                    ->addAttributes(
                        [
                            'href' => $this->itemTag === 'a' ? $item->getUrl() : null,
                            'type' => $this->itemTag === 'button' ? 'button' : null,
                        ],
                    ),
                "\n",
            );

        if ($this->itemsClass !== []) {
            $liTag->class(...$this->itemsClass);
        }

        return $liTag;
    }

    private function renderItems(string|null $id): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        $ulTag = Ul::tag()
            ->addAttributes(
                [
                    'aria-labelledby' => $id,
                ],
            )
            ->addClass(self::DROPDOWN_LIST_CLASS)
            ->items(...$items);

        if ($this->listClass !== []) {
            $ulTag->class(...$this->listClass);
        }

        return $ulTag->render();
    }

    private function renderToggle(string|null $id): string
    {
        if ($this->toggleButton !== '') {
            return $this->toggleButton;
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

        if ($this->toggleLink) {
            return $this->renderToggleLink($toggleContent);
        }

        return Button::button('')
            ->addClass(
                self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                $this->toggleVariant,
                $this->toggleSize,
                self::DROPDOWN_TOGGLE_CLASS,
                $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
            )
            ->addAttributes(
                [
                    'data-bs-toggle' => 'dropdown',
                    'aria-expanded' => 'false',
                ],
            )
            ->addContent($toggleContent)
            ->encode(false)
            ->id($id)
            ->render();
    }

    private function renderToggleLink(string $toggleContent): string
    {
        return A::tag()
            ->addClass(
                $this->toggleVariant !== DropdownToggleVariant::NAV_LINK ? self::DROPDOWN_TOGGLE_BUTTON_CLASS : null,
                $this->toggleVariant,
                $this->toggleSize,
                self::DROPDOWN_TOGGLE_CLASS,
                $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
            )
            ->addAttributes(
                [
                    'role' => 'button',
                    'data-bs-toggle' => 'dropdown',
                    'aria-expanded' => 'false',
                ],
            )
            ->addContent($toggleContent)
            ->encode(false)
            ->url($this->toggleUrl)
            ->render();
    }

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
