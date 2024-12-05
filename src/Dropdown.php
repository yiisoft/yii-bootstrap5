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
use Yiisoft\Html\Tag\Span;
use Yiisoft\Html\Tag\Ul;

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
final class Dropdown extends \Yiisoft\Widget\Widget
{
    private const DROPDOWN_CLASS = 'dropdown';
    private const DROPDOWN_LIST_CLASS = 'dropdown-menu';
    private const DROPDOWN_TOGGLE_BUTTON_CLASS = 'btn';
    private const DROPDOWN_TOGGLE_CLASS = 'dropdown-toggle';
    private const DROPDOWN_TOGGLE_CONTAINER_CLASS = 'btn-group';
    private const DROPDOWN_TOGGLE_SPAN_CLASS = 'visually-hidden';
    private const DROPDOWN_TOGGLE_SPLIT_CLASS = 'dropdown-toggle-split';
    private const NAME = 'dropdown';
    private array $alignmentClasses = [];
    private array $attributes = [];
    private array $cssClass = [];
    private bool $container = true;
    private BackedEnum|string $containerClass = self::DROPDOWN_CLASS;
    /** @psalm-var DropdownItem[] */
    private array $items = [];
    private array $toggleAttributes = [];
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
     * Sets the alignment of the dropdown component.
     *
     * @param DropdownAlignment ...$value The alignment of the dropdown component.
     *
     * @return self A new instance with the specified alignment of the dropdown component.
     */
    public function alignment(DropdownAlignment ...$value): self
    {
        $new = clone $this;
        $new->alignmentClasses = $value;

        return $new;
    }

    /**
     * Adds a set of attributes for the dropdown toggle button.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-dropdown']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addToggleAttributes(array $values): self
    {
        $new = clone $this;
        $new->toggleAttributes = array_merge($this->toggleAttributes, $values);

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
     * Whether to automatically close the dropdown when any of its elements is clicked.
     *
     * @param bool $value If set to `true`, the dropdown will be closed when any of its elements is clicked. If set to
     * `false`, should be closed manually.
     *
     * @return self A new instance with the specified auto-close setting.
     */
    public function autoCloseOnClick(bool $value = true): self
    {
        return $this->addToggleAttributes(['data-bs-auto-close' => $value === true ? 'true' : 'false']);
    }

    /**
     * Whether to automatically close the dropdown when the user clicks inside of the dropdown.
     *
     * @param bool $value If set to `true`, the dropdown will be closed when the user clicks inside of the dropdown. If
     * set to `false`, no attribute will be set.
     *
     * @return self A new instance with the specified auto-close setting.
     */
    public function autoCloseOnClickInside(bool $value = true): self
    {
        return $this->addToggleAttributes(['data-bs-auto-close' => $value === true ? 'inside' : null]);
    }

    /**
     * Whether to automatically close the dropdown when the user clicks outside of the dropdown or the dropdown toggle
     * button.
     *
     * @param bool $value If set to `true`, the dropdown will be closed when the user clicks outside of the dropdown. If
     * set to `false`, no attribute will be set.
     *
     * @return self A new instance with the specified auto-close setting.
     */
    public function autoCloseOnClickOutside(bool $value = true): self
    {
        return $this->addToggleAttributes(['data-bs-auto-close' => $value === true ? 'outside' : null]);
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
     * @param bool $value Whether to render the dropdown in a container `<div>` tag. By default, it will be rendered in
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
     * Set the direction of the dropdown component.
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
            ->toggleId($this->toggleId === false ? true : $this->toggleId);
    }

    /**
     * Sets the HTML attributes for the dropdown toggle button.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the dropdown toggle button.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function toggleAttributes(array $values): self
    {
        $new = clone $this;
        $new->toggleAttributes = $values;

        return $new;
    }

    /**
     * Sets the toggle button custom tag.
     *
     * @param string|Stringable $value The toggle button custom tag.
     *
     * @return self A new instance with the specified toggle button custom tag.
     */
    public function toggleTag(string|Stringable $value): self
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
     * Sets the ID of the toggle button for the dropdown component.
     *
     * @param bool|string $value The ID of the dropdown component. If `true`, an ID will be generated automatically.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return self A new instance with the specified ID of the toggle button for the dropdown component.
     */
    public function toggleId(bool|string $value): self
    {
        $new = clone $this;
        $new->toggleId = $value;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle as a link.
     *
     * @param bool $value Whether to render the dropdown toggle as a link. If set to `true`, the dropdown toggle will be
     * rendered as a link. If set to `false`, the dropdown toggle will be rendered as a button.
     *
     * @return self A new instance with the specified dropdown toggle as a link setting.
     */
    public function toggleAsLink(bool $value = true): self
    {
        $new = clone $this;
        $new->toggleLink = $value;

        return $new;
    }

    /**
     * Whether to render the dropdown toggle button as a large button.
     *
     * @param bool $value Whether to render the dropdown toggle button as a large button. If set to `true`, the dropdown
     * toggle button will be rendered as a large button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal-sized button.
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
     * @param bool $value Whether to render the dropdown toggle button as a small button. If set to `true`, the dropdown
     * toggle button will be rendered as a small button. If set to `false`, the dropdown toggle button will be rendered
     * as a normal-sized button.
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
    public function toggleSplitContent(string|Stringable $value): self
    {
        $new = clone $this;
        $new->toggleSplitContent = (string) $value;

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
        $toggleId = match ($this->toggleId) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->toggleId,
        };

        Html::addCssClass($attributes, [$containerClass, $classes, ...$this->cssClass]);

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
     * @psalm-param non-empty-string|null $toggleId
     */
    private function renderItems(string|null $toggleId): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->getContent();
        }

        $ulTag = Ul::tag()
            ->addAttributes(
                [
                    'aria-labelledby' => $toggleId,
                ],
            )
            ->addClass(self::DROPDOWN_LIST_CLASS, ...$this->alignmentClasses)
            ->items(...$items);

        return $ulTag->render();
    }

    /**
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

        $classes = $toggleAttributes['class'] ?? null;

        unset($toggleAttributes['class']);

        if ($this->toggleLink) {
            return $this->renderToggleLink($toggleAttributes, $toggleContent, $classes);
        }

        $toggleAttributes['data-bs-toggle'] = 'dropdown';
        $toggleAttributes['aria-expanded'] = 'false';

        return Button::button('')
            ->addClass(
                self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                $this->toggleVariant,
                $this->toggleSize,
                self::DROPDOWN_TOGGLE_CLASS,
                $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
                $classes,
            )
            ->addAttributes($toggleAttributes)
            ->addContent($toggleContent)
            ->encode(false)
            ->id($toggleId)
            ->render();
    }

    private function renderToggleLink(array $toggleAttributes, string $toggleContent, string|null $classes): string
    {
        $toggleAttributes['role'] = 'button';
        $toggleAttributes['data-bs-toggle'] = 'dropdown';
        $toggleAttributes['aria-expanded'] = 'false';

        return A::tag()
            ->addClass(
                self::DROPDOWN_TOGGLE_BUTTON_CLASS,
                $this->toggleVariant,
                $this->toggleSize,
                self::DROPDOWN_TOGGLE_CLASS,
                $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
                $classes,
            )
            ->addAttributes($toggleAttributes)
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
