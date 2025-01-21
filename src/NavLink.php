<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;

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
    ) {
    }

    /**
     * Creates a nav {@see NavLink} instance.
     *
     * @param string|Stringable $label The label of the link.
     * @param string|null $url The URL of the link.
     * @param bool $active Whether the link is active.
     * @param bool $disabled Whether the link is disabled.
     * @param bool $encodeLabel Whether the label should be encoded.
     * @param array $attributes The HTML attributes for the nav item.
     * @param array $urlAttributes The HTML attributes for the nav item link.
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
    ): self {
        if ($active === true && $disabled === true) {
            throw new InvalidArgumentException('A nav link cannot be both active and disabled.');
        }

        return new self($active, $attributes, $encodeLabel, $disabled, $label, $url, $urlAttributes);
    }

    /**
     * Sets the active state of the nav item.
     *
     * @param bool $value Whether the nav item is active.
     *
     * @return self A new instance with the specified active state.
     */
    public function active(bool $value): self
    {
        $new = clone $this;
        $new->active = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the nav item.
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
     * Sets the disabled state of the nav item.
     *
     * @param bool $value Whether the nav item is disabled.
     *
     * @return self A new instance with the specified disabled state.
     */
    public function disabled(bool $value): self
    {
        $new = clone $this;
        $new->disabled = $value;

        return $new;
    }

    /**
     * Sets whether to HTML-encode the label.
     *
     * @param bool $value Whether to encode the label
     *
     * @return self New instance with the specified encode setting.
     */
    public function encodeLabel(bool $value): self
    {
        $new = clone $this;
        $new->encodeLabel = $value;

        return $new;
    }

    /**
     * Sets the label text for the nav item.
     *
     * @param string|Stringable $value The label text or Stringable object
     *
     * @return self New instance with the specified label text.
     */
    public function label(string|Stringable $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * Sets the URL for the nav item.
     *
     * @param string|null $value The URL or `null` for no URL.
     *
     * @return self New instance with the specified URL.
     */
    public function url(string|null $value): self
    {
        $new = clone $this;
        $new->url = $value;

        return $new;
    }

    /**
     * Sets HTML attributes for the nav item link.
     *
     * @param array $values Attribute values indexed by attribute names
     *
     * @return self New instance with the specified link attributes
     *
     * @see \Yiisoft\Html\Html::renderTagAttributes() for details on how attributes are rendered
     */
    public function urlAttributes(array $values): self
    {
        $new = clone $this;
        $new->urlAttributes = $values;

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
     * @return string|Stringable The label of Stringable object.
     */
    public function getLabel(): string|Stringable
    {
        return $this->label;
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
     * @return bool Whether the nav item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool Whether the label should be encoded.
     */
    public function shouldEncodeLabel(): bool
    {
        return $this->encodeLabel;
    }

    /**
     * @return bool Whether the nav item is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
