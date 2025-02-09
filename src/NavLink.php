<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;

/**
 * NavLink represents a navigation link item in a Bootstrap Nav component.
 *
 * Each NavLink can be either active, disabled, or a regular link. The label can be either a string or a Stringable
 * object, and can be optionally encoded.
 *
 * Example:
 * ```php
 * // Create a standard nav link
 * NavLink::to('Home', '/');
 *
 * // Create an active nav link
 * NavLink::to('Current Page', '#', true);
 *
 * // Create a disabled nav link
 * NavLink::to('Disabled', '#', false, true);
 *
 * // Create a tab with content
 * NavLink::tab('Tab 1', 'Content 1');
 *
 * // Create an active tab with content
 * NavLink::tab('Tab 2', 'Content 2', true);
 * ```
 */
final class NavLink
{
    /**
     * Use {@see NavLink::to()} to create an instance.
     */
    private function __construct(
        private bool $active = false,
        private array $attributes = [],
        private bool $encodeLabel = true,
        private bool $disabled = false,
        private string|Stringable $label = '',
        private string|null $url = '',
        private array $urlAttributes = [],
        private bool $visible = true,
        private string|Stringable $content = '',
        private bool|string $paneId = false,
        private array $paneAttributes = [],
    ) {
    }

    /**
     * Creates a {@see NavLink} instance.
     *
     * @param string|Stringable $label The label of the link.
     * @param string|null $url The URL of the link.
     * @param bool $active Whether the link is active.
     * @param bool $disabled Whether the link is disabled.
     * @param bool $encodeLabel Whether the label should be encoded.
     * @param array $attributes The HTML attributes for the nav item.
     * @param array $urlAttributes The HTML attributes for the nav item link.
     * @param bool $visible Whether the nav item is visible.
     *
     * @throws InvalidArgumentException If the link is both active and disabled.
     *
     * @return self A new instance with the specified attributes.
     */
    public static function to(
        string|Stringable $label = '',
        string|null $url = null,
        bool $active = false,
        bool $disabled = false,
        bool $encodeLabel = true,
        array $attributes = [],
        array $urlAttributes = [],
        bool $visible = true,
    ): self {
        if ($active && $disabled) {
            throw new InvalidArgumentException('A nav link cannot be both active and disabled.');
        }

        return new self($active, $attributes, $encodeLabel, $disabled, $label, $url, $urlAttributes, $visible);
    }

    /**
     * Creates a {@see NavLink} instance for a tab.
     *
     * @param string|Stringable $label The label of the tab.
     * @param string|Stringable $content The content of the tab pane.
     * @param bool $active Whether the tab is active.
     * @param bool $encodeLabel Whether the label should be encoded.
     * @param array $attributes The HTML attributes for the nav item.
     * @param array $urlAttributes The HTML attributes for the nav item link.
     * @param array $paneAttributes The HTML attributes for the tab pane.
     * @param bool $visible Whether the nav item is visible.
     *
     * @throws InvalidArgumentException If the tab is both active and disabled.
     *
     * @return self A new instance with the specified attributes.
     */
    public static function tab(
        string|Stringable $label,
        string|Stringable $content,
        bool $active = false,
        bool $encodeLabel = true,
        array $attributes = [],
        array $urlAttributes = [],
        bool|string $paneId = true,
        array $paneAttributes = [],
        bool $visible = true,
    ): self {
        return new self(
            active: $active,
            attributes: $attributes,
            encodeLabel: $encodeLabel,
            disabled: false,
            label: $label,
            url: '#',
            urlAttributes: $urlAttributes,
            visible: $visible,
            content: $content,
            paneId: $paneId,
            paneAttributes: $paneAttributes
        );
    }

    /**
     * Sets the active state of the nav item.
     *
     * @param bool $enabled Whether the nav item is active.
     *
     * @return self A new instance with the specified active state.
     */
    public function active(bool $enabled): self
    {
        $new = clone $this;
        $new->active = $enabled;

        return $new;
    }

    /**
     * Sets the HTML attributes for the nav item.
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
     * Sets the content of the tab pane.
     *
     * @param string|Stringable $content The content of the tab pane.
     *
     * @return self A new instance with the specified content.
     */
    public function content(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    /**
     * Sets the disabled state of the nav item.
     *
     * @param bool $disabled Whether the nav item is disabled.
     *
     * @return self A new instance with the specified disabled state.
     */
    public function disabled(bool $disabled): self
    {
        $new = clone $this;
        $new->disabled = $disabled;

        return $new;
    }

    /**
     * Sets weather to HTML-encode the label.
     *
     * @param bool $enabled Whether to encode the label.
     *
     * @return self New instance with the specified encoded setting.
     */
    public function encodeLabel(bool $enabled): self
    {
        $new = clone $this;
        $new->encodeLabel = $enabled;

        return $new;
    }

    /**
     * @return string|Stringable The content of the tab pane.
     */
    public function getContent(): string|Stringable
    {
        return $this->content;
    }

    public function getId(): string
    {
        /** @psalm-var non-empty-string|null $id */
        return match ($this->paneId) {
            true => $this->paneAttributes['id'] ?? Html::generateId('pane'),
            '', false => throw new InvalidArgumentException('The tab pane ID must be specified.'),
            default => $this->paneId,
        };
    }

    /**
     * @return string|Stringable The label of Stringable object.
     */
    public function getLabel(): string|Stringable
    {
        return $this->label;
    }

    /**
     * @return array The HTML attributes for the tab pane.
     */
    public function getPaneAttributes(): array
    {
        return $this->paneAttributes;
    }

    /**
     * @return string|null The URL of the nav item.
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * @return array The HTML attributes for the nav item link.
     */
    public function getUrlAttributes(): array
    {
        return $this->urlAttributes;
    }

    /**
     * @return bool Whether the nav item has content.
     */
    public function hasContent(): bool
    {
        return $this->content !== '';
    }

    /**
     * Sets the ID of the nav component.
     *
     * @param bool|string $id The ID of the alert component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     */
    public function paneId(bool|string $id): self
    {
        $new = clone $this;
        $new->paneId = $id;

        return $new;
    }

    /**
     * Sets the label text for the nav item.
     *
     * @param string|Stringable $label The label text or Stringable object
     *
     * @return self New instance with the specified label text.
     */
    public function label(string|Stringable $label): self
    {
        $new = clone $this;
        $new->label = $label;

        return $new;
    }

    /**
     * Sets the HTML attributes for the tab pane.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self New instance with the specified pane attributes.
     *
     * @see Html::renderTagAttributes() for details on how attributes are rendered.
     */
    public function paneAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->paneAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the URL for the nav item.
     *
     * @param string|null $url The URL or `null` for no URL.
     *
     * @return self New instance with the specified URL.
     */
    public function url(string|null $url): self
    {
        $new = clone $this;
        $new->url = $url;

        return $new;
    }

    /**
     * Sets HTML attributes for the nav item link.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self New instance with the specified link attributes.
     *
     * @see Html::renderTagAttributes() for details on how attributes are rendered.
     */
    public function urlAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->urlAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the visibility of the nav item.
     *
     * @param bool $enabled Whether the nav item is visible.
     *
     * @return self A new instance with the specified visibility.
     */
    public function visible(bool $enabled): self
    {
        $new = clone $this;
        $new->visible = $enabled;

        return $new;
    }

    /**
     * @return array The HTML attributes for the nav item.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return bool Whether the nav item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool Whether the nav item is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return bool Whether the nav item is visible.
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @return bool Whether the label should be encoded.
     */
    public function shouldEncodeLabel(): bool
    {
        return $this->encodeLabel;
    }
}
