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
    private bool $active = false;
    private array $attributes = [];
    private bool $encodeLabel = true;
    private bool $disabled = false;
    private string|Stringable $label = '';
    private string|null $url = '';
    private array $urlAttributes = [];

    /**
     * Use {@see NavLink::to()} to create an instance.
     */
    private function __construct()
    {
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
     * Sets the HTML attributes for the nav item link.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function urlAttributes(array $values): self
    {
        $new = clone $this;
        $new->urlAttributes = $values;

        return $new;
    }

    /**
     * Creates a nav item.
     *
     * @param string|Stringable $label The label of the link.
     * @param string|null $url The URL of the link.
     * @param bool $active Whether the link is active.
     * @param bool $disabled Whether the link is disabled.
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
        bool $encodeLabel = true
    ): self {
        $navlink = new self();

        if ($active === true && $disabled === true) {
            throw new InvalidArgumentException('A nav link cannot be both active and disabled.');
        }

        $navlink->active = $active;
        $navlink->disabled = $disabled;
        $navlink->encodeLabel = $encodeLabel;
        $navlink->label = $label;
        $navlink->url = $url;

        return $navlink;
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
