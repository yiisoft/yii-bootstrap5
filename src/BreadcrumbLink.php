<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

/**
 * Represents a link.
 */
final class BreadcrumbLink
{
    private string $label = '';
    private string|null $url = null;
    private bool $active = false;
    private bool $encodeLabel = true;
    private array $attributes = [];

    public static function to(
        string $label,
        string $url = null,
        bool $active = false,
        array $attributes = [],
        bool $encodeLabel = true
    ): self {
        $new = new self();
        $new->label = $label;
        $new->url = $url;
        $new->active = $active;
        $new->attributes = $attributes;
        $new->encodeLabel = $encodeLabel;

        return $new;
    }

    /**
     * Returns the HTML attributes for the link.
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
     * Returns the URL for the link.
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
