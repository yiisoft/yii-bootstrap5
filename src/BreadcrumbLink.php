<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

/**
 * BreadcrumbLink represents a single breadcrumb navigation link.
 *
 * Each link can be either active or inactive, and can be rendered as a plain text (when active) or as a hyperlink
 * (when inactive).
 *
 * Example:
 * ```php
 * // Create a standard link
 * BreadcrumbLink::to('Home', '/');
 *
 * // Create an active link (current page)
 * BreadcrumbLink::to('Current Page', null, true);
 *
 * // Create a link with custom attributes
 * BreadcrumbLink::to('Link', '/path', false, ['class' => 'custom-link']);
 * ```
 */
final class BreadcrumbLink
{
    private string $label = '';
    private string|null $url = null;
    private bool $active = false;
    private bool $encodeLabel = true;
    private array $attributes = [];

    /**
     * Use {@see BreadcrumbLink::to()} to create an instance.
     */
    private function __construct()
    {
    }

    /**
     * Creates a new {@see BreadcrumbLink} instance.
     *
     * @param string $label The label text to display.
     * @param string|null $url The URL for the link.
     * @param bool $active Whether this link represents the current page.
     * @param array $attributes Additional HTML attributes for the link.
     * @param bool $encodeLabel Whether to HTML encode the label.
     *
     * @return self A new instance with the specified configuration.
     */
    public static function to(
        string $label,
        string $url = null,
        bool $active = false,
        array $attributes = [],
        bool $encodeLabel = true
    ): self {
        $new = new self();
        $new->active = $active;
        $new->attributes = $attributes;
        $new->encodeLabel = $encodeLabel;
        $new->label = $label;
        $new->url = $url;

        return $new;
    }

    /**
     * @return array Returns the HTML attributes for the link.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string Returns the encoded label content. For default behavior, the label will be HTML-encoded. You can
     * disable this by setting `encodeLabel` to `false`.
     */
    public function getLabel(): string
    {
        return $this->encodeLabel ? Html::encode($this->label) : $this->label;
    }

    /**
     * @return string|null  Returns the URL for the breadcrumb link.
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
