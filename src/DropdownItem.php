<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use InvalidArgumentException;

/**
 * DropdownItem represents a single item within a Bootstrap Dropdown menu.
 *
 * Supports multiple item types:
 * - Buttons: Button-style menu items.
 * - Dividers: Horizontal separators.
 * - Headers: Section headers.
 * - Links: Standard clickable menu items.
 * - Text: Plain text items.
 *
 * Example usage:
 * ```php
 * // Create a link item
 * DropdownItem::link('Profile', '/profile');
 *
 * // Create an active item
 * DropdownItem::link('Dashboard', '/dashboard', true);
 *
 * // Create a divider
 * DropdownItem::divider();
 *
 * // Create a header
 * DropdownItem::header('Section Title');
 * ```
 */
final class DropdownItem
{
    private const TYPE_BUTTON = 'button';

    private const TYPE_CUSTOM_CONTENT = 'custom-content';

    private const TYPE_DIVIDER = 'divider';

    private const TYPE_HEADER = 'header';

    private const TYPE_LINK = 'link';

    private const TYPE_TEXT = 'text';

    /**
     * Use {@see DropdownItem::button()} to create a new button instance.
     * Use {@see DropdownItem::divider()} to create a new divider instance.
     * Use {@see DropdownItem::header()} to create a new header instance.
     * Use {@see DropdownItem::link()} to create a new link instance.
     * Use {@see DropdownItem::text()} to create a new text instance.
     *
     * @psalm-param non-empty-string $headerTag
     */
    private function __construct(
        private string $type = '',
        private string|Stringable $content = '',
        private string $url = '',
        private bool $active = false,
        private bool $disabled = false,
        private array $attributes = [],
        private array $itemAttributes = [],
        private string $headerTag = 'h6',
    ) {
    }

    /**
     * Creates a button-type dropdown item.
     *
     * @param string|Stringable $content The button content.
     * @param array $attributes The HTML attributes for the `<li>` tag.
     * @param array $itemAttributes The HTML attributes for the `<button>` tag.
     *
     * @throws InvalidArgumentException When item is set as both active and disabled.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::button('Submit', active: true);
     * ```
     */
    public static function button(
        string|Stringable $content = '',
        array $attributes = [],
        array $itemAttributes = [],
    ): self {
        return new self(
            self::TYPE_BUTTON,
            $content,
            attributes: $attributes,
            itemAttributes: $itemAttributes,
        );
    }

    /**
     * Creates a divider dropdown item.
     *
     * @param array $attributes The HTML attributes for the `<li>` tag.
     * @param array $itemAttributes The HTML attributes for the `<hr>` tag.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::divider();
     * ```
     */
    public static function divider(array $attributes = [], array $itemAttributes = []): self
    {
        return new self(self::TYPE_DIVIDER, attributes: $attributes, itemAttributes: $itemAttributes);
    }

    /**
     * Creates a header dropdown item.
     *
     * @param string|Stringable $content The header text.
     * @param string $tag The HTML tag to use (defaults to `h6`).
     * @param array $attributes The HTML attributes for the `<li>` tag.
     * @param array $itemAttributes The HTML attributes for the `<h6>` tag.
     *
     * @throws InvalidArgumentException When header tag is empty.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::header('Section Title');
     * ```
     */
    public static function header(
        string|Stringable $content = '',
        string $headerTag = 'h6',
        array $attributes = [],
        array $itemAttributes = [],
    ): self {
        if ($headerTag === '') {
            throw new InvalidArgumentException('The header tag cannot be empty.');
        }

        return new self(
            self::TYPE_HEADER,
            $content,
            headerTag: $headerTag,
            attributes: $attributes,
            itemAttributes: $itemAttributes,
        );
    }

    /**
     * Creates a link-type dropdown item.
     *
     * @param string|Stringable $content The link text.
     * @param string $url The URL (defaults to '#').
     * @param bool $active Whether the link is active.
     * @param bool $disabled Whether the link is disabled.
     * @param array $attributes The HTML attributes for the `<li>` tag.
     * @param array $itemAttributes The HTML attributes for the `<a>` tag.
     *
     * @throws InvalidArgumentException When item is set as both active and disabled.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::link('Profile', '/profile');
     * ```
     */
    public static function link(
        string|Stringable $content = '',
        string $url = '#',
        bool $active = false,
        bool $disabled = false,
        array $attributes = [],
        array $itemAttributes = [],
    ): self {
        if ($active && $disabled) {
            throw new InvalidArgumentException('The dropdown item cannot be active and disabled at the same time.');
        }

        return new self(self::TYPE_LINK, $content, $url, $active, $disabled, $attributes, $itemAttributes);
    }

    /**
     * Creates a list with custom content dropdown item.
     *
     * @param string|Stringable $content The list content.
     * @param array $attributes The HTML attributes for the `<li>` tag.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::listContent('Simple list item');
     * ```
     */
    public static function listContent(string|Stringable $content = '', array $attributes = []): self
    {
        return new self(self::TYPE_CUSTOM_CONTENT, $content, attributes: $attributes);
    }

    /**
     * Creates a text dropdown item.
     *
     * @param string|Stringable $content The text content.
     * @param array $attributes The HTML attributes for the `<li>` tag.
     * @param array $itemAttributes The HTML attributes for the `<span>` tag.
     *
     * @return self A new instance with the specified configuration.
     *
     * Example:
     * ```php
     * DropdownItem::text('Simple text item');
     * ```
     */
    public static function text(
        string|Stringable $content = '',
        array $attributes = [],
        array $itemAttributes = [],
    ): self {
        return new self(self::TYPE_TEXT, $content, attributes: $attributes, itemAttributes: $itemAttributes);
    }

    /**
     * @return array The HTML attributes for the `<li>` tag.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string|Stringable The content of the dropdown item.
     */
    public function getContent(): string|Stringable
    {
        return $this->content;
    }

    /**
     * @return string The header tag for the dropdown item.
     *
     * @psalm-return non-empty-string
     */
    public function getHeaderTag(): string
    {
        return $this->headerTag;
    }

    /**
     * @return array The HTML attributes for the item tag.
     */
    public function getItemAttributes(): array
    {
        return $this->itemAttributes;
    }

    /**
     * @return string The URL for the dropdown item.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string The type of the dropdown item.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool Whether the item is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
