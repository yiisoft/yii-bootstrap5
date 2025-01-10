<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;

/**
 * Represents a Bootstrap Nav item and link.
 *
 * ```php
 * NavLink::to('Home', '/', true)->attributes(['class' => 'nav-link']);
 * NavLink::to('Home', '/', disabled: true)->urlAttributes(['class' => 'nav-link']);
 */
final class NavLink
{
    private bool $active = false;
    private array $attributes = [];
    private bool $disabled = false;
    private string $label = '';
    private string|null $url = '';
    private array $urlAttributes = [];

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
    ): self {
        $navlink = new self();

        if ($active === true && $disabled === true) {
            throw new InvalidArgumentException('A nav link cannot be both active and disabled.');
        }

        $navlink->active = $active;
        $navlink->disabled = $disabled;
        $navlink->label = $label;
        $navlink->url = $url;

        return $navlink;
    }

    /**
     * Returns the HTML attributes for the nav item.
     *
     * @return array The HTML attributes for the nav item.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Returns the label of the nav item.
     *
     * @return string The label of the nav item.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Returns the URL of the nav item.
     *
     * @return string|null The URL of the nav item.
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * Returns the HTML attributes for the nav item link.
     *
     * @return array The HTML attributes for the nav item link.
     */
    public function getUrlAttributes(): array
    {
        return $this->urlAttributes;
    }

    /**
     * Returns whether the nav item is active.
     *
     * @return bool Whether the nav item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Returns whether the nav item is disabled.
     *
     * @return bool Whether the nav item is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
