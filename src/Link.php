<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

/**
 * Link represents a single link in a {@see Breadcrumbs} widget.
 *
 * For example:
 *
 * ```php
 * echo Breadcrumbs::widget()
 *     ->links(
 *         new Link('Home', '#'),
 *         new Link('Library', '#'),
 *         new Link('Data', active: true),
 *     )
 *     ->render();
 * ```
 */
final class Link
{
    public function __construct(
        private readonly string $label = '',
        private readonly string|null $url = null,
        private readonly bool $active = false,
        private readonly bool $encodeLabel = true,
        private readonly array $attributes = [],
    ) {
    }

    /**
     * Returns the HTML attributes for the breadcrumb item.
     *
     * @return array The attributes.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Returns the encoded label content.
     *
     * @return string The encoded label content.
     */
    public function getLabel(): string
    {
        return $this->encodeLabel ? Html::encode($this->label) : $this->label;
    }

    /**
     * Returns the URL for the breadcrumb item.
     *
     * @return string|null The URL.
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
