<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
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
 *     ->toggleVariant(ButtonVariant::DANGER)
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
    private const DROPDOWN_TOGGLER_BUTTON_CLASS = 'btn';
    private const DROPDOWN_TOGGLER_CLASS = 'dropdown-toggle';
    private const DROPDOWN_TOGGLER_CONTAINER_CLASS = 'btn-group';
    private const DROPDOWN_TOGGLER_SPAN_CLASS = 'visually-hidden';
    private const DROPDOWN_TOGGLER_SPLIT_CLASS = 'dropdown-toggle-split';
    private const NAME = 'dropdown';
    private array $alignmentClasses = [];
    private array $attributes = [];
    private array $cssClasses = [];
    private bool $container = true;
    private array $containerClasses = [self::DROPDOWN_CLASS];
    /** @psalm-var DropdownItem[] */
    private array $items = [];
    private string|Stringable $toggler = '';
    private array $togglerAttributes = [];
    private array $togglerClasses = [];
    private string $togglerContent = 'Dropdown button';
    private bool|string $togglerId = false;
    private bool $togglerLink = false;
    private string $togglerUrl = '#';
    private string|null $togglerSize = null;
    private bool $togglerSplit = false;
    private string $togglerSplitContent = 'Action';
    private ButtonVariant $togglerVariant = ButtonVariant::SECONDARY;

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $dropdown->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $dropdown->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style.
     *
     * @param array|string $style The CSS style. If an array, the values will be separated by a space. If a string, it
     * will be added as is. For example, `color: red`. If the value is an array, the values will be separated by a
     * space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $dropdown->addCssStyle('color: red');
     *
     * // or
     * $dropdown->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Adds a set of attributes for the toggler button.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes for the toggler button.
     *
     * Example usage:
     * ```php
     * $dropdown->addTogglerAttributes(['data-id' => '123']);
     * ```
     */
    public function addTogglerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerAttributes = [...$this->togglerAttributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $dropdown->addTogglerClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function addTogglerClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->togglerAttributes, $class);

        return $new;
    }

    /**
     * Sets the alignment.
     *
     * @param DropdownAlignment|null ...$alignment The alignment. If `null`, the alignment will
     * not be set.
     *
     * @return self A new instance with the specified alignment.
     *
     * Example usage:
     * ```php
     * $dropdown->alignment(DropdownAlignment::END());
     * ```
     */
    public function alignment(DropdownAlignment|null ...$alignment): self
    {
        $new = clone $this;
        $new->alignmentClasses = $alignment;

        return $new;
    }

    /**
     * Adds a sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute added.
     *
     * Example usage:
     * ```php
     * $droddown->attribute('data-id', '123');
     * ```
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $dropdown->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the auto-close setting.
     *
     * @param DropdownAutoClose $autoClose The auto-close setting.
     *
     * @return self A new instance with the specified auto-close setting.
     *
     * Example usage:
     * ```php
     * $dropdown->autoClose(DropdownAutoClose::OUTSIDE());
     * ```
     */
    public function autoClose(DropdownAutoClose $autoClose): self
    {
        return $this->addTogglerAttributes(['data-bs-auto-close' => $autoClose->value]);
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $dropdown->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Whether to render in a container `<div>` tag.
     *
     * @param bool $enabled Whether to render in a container `<div>` tag. By default, it will be rendered in a container
     * `<div>` tag. If set to `false`, the container will not be rendered.
     *
     * @return self A new instance with the specified container setting.
     *
     * Example usage:
     * ```php
     * $dropdown->container(false);
     * ```
     */
    public function container(bool $enabled): self
    {
        $new = clone $this;
        $new->container = $enabled;

        return $new;
    }

    /**
     * Sets the CSS classes for the container.
     *
     * @param BackedEnum|string ...$classes The CSS class for the container.
     *
     * @return self A new instance with the specified CSS class for the container.
     *
     * Example usage:
     * ```php
     * $dropdown->containerClasses(BackGroundColor::PRIMARY(), 'custom-class');
     * ```
     */
    public function containerClasses(BackedEnum|string ...$classes): self
    {
        $new = clone $this;
        $new->containerClasses = $classes;

        return $new;
    }

    /**
     * Set the direction.
     *
     * @param DropdownDirection $direction The direction.
     *
     * @return self A new instance with the specified direction.
     *
     * Example usage:
     * ```php
     * $dropdown->direction(DropdownDirection::DOWN());
     * ```
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
     * List of links. If this property is empty, the widget will not render anything.
     *
     * @param array $items The links.
     *
     * @return self A new instance with the specified links.
     *
     * @psalm-param DropdownItem[] $items The links to appear in the dropdown.
     *
     * Example usage:
     * ```php
     * $dropdown->items(
     *     DropdownItem::link('Action', '#'),
     *     DropdownItem::link('Another action', '#'),
     *     DropdownItem::link('Something else here', '#'),
     *     DropdownItem::divider(),
     *     DropdownItem::link('Separated link', '#'),
     * );
     */
    public function items(DropdownItem ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the theme.
     *
     * @param string $theme The theme.
     *
     * @return self A new instance with the specified theme.
     *
     * Example usage:
     * ```php
     * $dropdown->theme('dark');
     * ```
     */
    public function theme(string $theme): self
    {
        return $this->addAttributes(['data-bs-theme' => $theme === '' ? null : $theme]);
    }

    /**
     * Sets the toggler custom element.
     *
     * @param string|Stringable $tag The toggler custom element.
     *
     * @return self A new instance with the specified toggler custom element.
     *
     * Example usage:
     * ```php
     * $dropdown->toggler(
     *     Button::tag()
     *         ->addAttributes(
     *             [
     *                 'data-bs-toggle' => 'dropdown',
     *                 'aria-expanded' => 'false',
     *             ],
     *         )
     *         ->addClass('btn btn-primary dropdown-toggle')
     *         ->content('Dropdown custom button'),
     * );
     * ```
     */
    public function toggler(string|Stringable $tag): self
    {
        $new = clone $this;
        $new->toggler = (string) $tag;

        return $new;
    }

    /**
     * Whether to render the toggler as a link.
     *
     * @param bool $enable Whether to render the toggler as a link. If set to `true`, the toggler will be rendered as a
     * link. If set to `false`, the toggler will be rendered as a button.
     *
     * @return self A new instance with the specified toggler as a link setting.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerAsLink();
     * ```
     */
    public function togglerAsLink(bool $enable = true): self
    {
        $new = clone $this;
        $new->togglerLink = $enable;

        return $new;
    }

    /**
     * Sets the HTML attributes for the toggler.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the toggler.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerAttributes(['data-id' => '123']);
     * ```
     */
    public function togglerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerAttributes = $attributes;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set for the toggler.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function togglerClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->togglerClasses = $class;

        return $new;
    }

    /**
     * Sets the content of the toggler.
     *
     * @param string|Stringable $content The content of the toggler.
     *
     * @return self A new instance with the specified content of the toggler.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerContent('Toggler dropdown');
     * ```
     */
    public function togglerContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->togglerContent = (string) $content;

        return $new;
    }

    /**
     * Sets the ID for the toggler.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID for the toggler.
     *
     * Example usage:
     * ```php
     * $droddown->togglerId(true);
     * ```
     */
    public function togglerId(bool|string $id): self
    {
        $new = clone $this;
        $new->togglerId = $id;

        return $new;
    }

    /**
     * Sets the size for the toggler.
     *
     * @param ButtonSize|null $size The size. If `null`, the size will not be set.
     *
     * @return self A new instance with the specified size for the toggler.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerSize(ButtonSize::SMALL());
     * ```
     */
    public function togglerSize(ButtonSize|null $size): self
    {
        $new = clone $this;
        $new->togglerSize = $size?->value;

        return $new;
    }

    /**
     * Whether to render the toggler as a split.
     *
     * @param bool $enable Whether to render the toggler as a split. If set to `true`, the toggler will be rendered as a
     * split. If set to `false`, the toggler will be rendered as a normal.
     *
     * @return self A new instance with the specified the toggler split setting.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerSplit();
     * ```
     */
    public function togglerSplit(bool $enable = true): self
    {
        $new = clone $this;
        $new->togglerSplit = $enable;

        return $new;
    }

    /**
     * Sets the content of the toggler split.
     *
     * @param string|Stringable $content The content of the toggler split.
     *
     * @return self A new instance with the specified content of the toggler split.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerSplitContent('Action');
     * ```
     */
    public function togglerSplitContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->togglerSplitContent = (string) $content;

        return $new;
    }

    /**
     * Sets the URL for the toggler link.
     *
     * @param string $url The URL for the toggler link.
     *
     * @return self A new instance with the specified URL for the toggler link.
     *
     * Example usage:
     * ```php
     * $dropdown->togglerUrl('https://example.com');
     * ```
     */
    public function togglerUrl(string $url): self
    {
        $new = clone $this;
        $new->togglerUrl = $url;

        return $new;
    }

    /**
     * Sets the variant for the toggler.
     *
     * @param ButtonVariant $variant The variant for the toggler.
     *
     * @return self A new instance with the specified variant for the toggler.
     */
    public function togglerVariant(ButtonVariant $variant): self
    {
        $new = clone $this;
        $new->togglerVariant = $variant;

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
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

        $togglerId = $this->getTogglerId();

        if ($this->togglerSplit) {
            $containerClasses = [self::DROPDOWN_TOGGLER_CONTAINER_CLASS];
        }

        $renderToggler = match ($this->togglerSplit) {
            true => $this->renderTogglerSplit() . "\n" . $this->renderToggler($togglerId),
            false => $this->renderToggler($togglerId),
        };

        $renderItems = $this->renderItems($togglerId);

        return match ($this->container) {
            true => Div::tag()
                ->addAttributes($attributes)
                ->addClass(...$containerClasses)
                ->addClass($classes)
                ->addClass(...$this->cssClasses)
                ->addContent(
                    "\n",
                    $renderToggler,
                    "\n",
                    $renderItems,
                    "\n",
                )
                ->encode(false)
                ->render(),
            false => $renderToggler . "\n" . $renderItems,
        };
    }

    /**
     * Generates the ID.
     *
     * @return string|null The generated ID.
     *
     * @psalm-return non-empty-string|null The generated ID.
     */
    private function getTogglerId(): string|null
    {
        return match ($this->togglerId) {
            true => $this->attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->togglerId,
        };
    }

    /**
     * Renders the list item.
     *
     * @param DropdownItem $item The dropdown item.
     *
     * @return Li The list item tag.
     */
    private function renderItem(DropdownItem $item): Li
    {
        return match ($item->getType()) {
            DropdownItemType::BUTTON => $this->renderItemButton($item),
            DropdownItemType::CUSTOM_CONTENT => $this->renderListContentItem($item),
            DropdownItemType::DIVIDER => $this->renderItemDivider($item),
            DropdownItemType::HEADER => $this->renderItemHeader($item),
            DropdownItemType::LINK => $this->renderItemLink($item),
            DropdownItemType::TEXT => $this->renderItemText($item),
        };
    }

    /**
     * Renders the list item with a button.
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
     * Renders the list item with a divider.
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
     * Renders the list item with a header.
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
     * Renders the list item with a link.
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
     * Renders the list item with custom content.
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
     * Renders the list item with text.
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
     * Render the list.
     *
     * @param string|null $togglerId The ID of the toggler.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string|null $togglerId
     */
    private function renderItems(string|null $togglerId): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        $ulTag = Ul::tag()
            ->addAttributes(['aria-labelledby' => $togglerId])
            ->addClass(self::DROPDOWN_LIST_CLASS, ...$this->alignmentClasses)
            ->items(...$items);

        return $ulTag->render();
    }

    /**
     * Render toggler.
     *
     * @param string|null $toggleId The ID of the toggler.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string|null $togglerId
     */
    private function renderToggler(string|null $togglerId): string
    {
        if ($this->toggler !== '') {
            return (string) $this->toggler;
        }

        $togglerContent = match ($this->togglerSplit) {
            true => "\n" .
                Span::tag()
                    ->addContent($this->togglerContent)
                    ->addClass(self::DROPDOWN_TOGGLER_SPAN_CLASS)
                    ->render() .
                "\n",
            default => $this->togglerContent,
        };

        $togglerAttributes = $this->togglerAttributes;
        $togglerClasses = $this->togglerClasses;
        $classes = $togglerAttributes['class'] ?? [];

        unset($togglerAttributes['class']);

        match ($togglerClasses) {
            [] => Html::addCssClass(
                $togglerAttributes,
                [
                    self::DROPDOWN_TOGGLER_BUTTON_CLASS,
                    $this->togglerVariant,
                    $this->togglerSize,
                    self::DROPDOWN_TOGGLER_CLASS,
                    $this->togglerSplit ? self::DROPDOWN_TOGGLER_SPLIT_CLASS : null,
                    ...$classes,
                ],
            ),
            default => Html::addCssClass($togglerAttributes, $togglerClasses),
        };

        if ($this->togglerLink) {
            return $this->renderTogglerLink($togglerAttributes, $togglerContent);
        }

        return Button::button('')
            ->addAttributes($togglerAttributes)
            ->attribute('data-bs-toggle', 'dropdown')
            ->attribute('aria-expanded', 'false')
            ->addContent($togglerContent)
            ->encode(false)
            ->id($togglerId)
            ->render();
    }

    /**
     * Render the toggler link.
     *
     * @param array $togglerAttributes The HTML attributes for the toggler link.
     * @param string $togglerContent The content of the toggler link.
     *
     * @return string The HTML representation of the element.
     */
    private function renderTogglerLink(array $togglerAttributes, string $togglerContent): string
    {
        return A::tag()
            ->addAttributes($togglerAttributes)
            ->attribute('role', 'button')
            ->attribute('data-bs-toggle', 'dropdown')
            ->attribute('aria-expanded', 'false')
            ->addContent($togglerContent)
            ->encode(false)
            ->url($this->togglerUrl)
            ->render();
    }

    /**
     * Render the toggler split.
     *
     * @return string The HTML representation of the element.
     */
    private function renderTogglerSplit(): string
    {
        if ($this->togglerLink) {
            return A::tag()
                ->addAttributes(['role' => 'button'])
                ->addClass(
                    self::DROPDOWN_TOGGLER_BUTTON_CLASS,
                    $this->togglerVariant,
                    $this->togglerSize,
                )
                ->addContent($this->togglerSplitContent)
                ->encode(false)
                ->render();
        }

        return Button::button('')
            ->addClass(
                self::DROPDOWN_TOGGLER_BUTTON_CLASS,
                $this->togglerVariant,
                $this->togglerSize,
            )
            ->addContent($this->togglerSplitContent)
            ->encode(false)
            ->render();
    }
}
