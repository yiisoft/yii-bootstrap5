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
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-dropdown']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$values];

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
        $new->cssClasses = [...$this->cssClasses, ...$value];

        return $new;
    }

    /**
     * Adds a CSS style for the dropdown component.
     *
     * @param array|string $value The CSS style for the dropdown component.
     * If a string is used, it's added as is. For example, `color: red;`.
     * If the value is an array, the values are separated by a space,
     * e.g., `['color' => 'red', 'font-weight' => 'bold']` is rendered as `color: red; font-weight: bold;`.
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
     * @param DropdownAlignment|null ...$value The alignment of the dropdown component. If `null`, the alignment will
     * not be set.
     *
     * @return self A new instance with the specified alignment of the dropdown component.
     */
    public function alignment(DropdownAlignment|null ...$value): self
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
        $new->toggleAttributes = [...$this->toggleAttributes, ...$values];

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
     * Sets the auto-close setting for the dropdown component.
     *
     * @param DropdownAutoClose $value The auto-close setting for the dropdown component.
     *
     * @return self A new instance with the specified auto-close setting.
     */
    public function autoClose(DropdownAutoClose $value): self
    {
        return $this->addToggleAttributes(['data-bs-auto-close' => $value->value]);
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
        $new->cssClasses = $value;

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
     * Sets the CSS classes for the dropdown container.
     *
     * @param BackedEnum|string ...$values The CSS class for the dropdown container.
     *
     * @return self A new instance with the specified CSS class for the dropdown container.
     */
    public function containerClasses(BackedEnum|string ...$values): self
    {
        $new = clone $this;
        $new->containerClasses = $values;

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
        $new->containerClasses = [$value];

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
        return $this->addAttributes(['data-bs-theme' => $value === '' ? null : $value]);
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
     * Replaces all existing CSS classes of the dropdown toggle button with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $dropdown->toggleClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY());
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function toggleClass(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->toggleClasses = $value;

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

        if ($this->toggleSplit === true) {
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
            $items[] = $item->getLiContent();
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
                    $this->toggleSplit === true ? self::DROPDOWN_TOGGLE_SPLIT_CLASS : null,
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
