<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Img;

/**
 * Represents a carousel item.
 */
final class CarouselItem
{
    public function __construct(
        private readonly Img $image,
        private readonly string $caption = '',
        private readonly bool $active = false,
        private readonly bool $encodeCaption = true,
        private readonly array $attributes = [],
    ) {
    }

    /**
     * Returns the HTML attributes for the carrusel item.
     *
     * @return array The attributes.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Returns the encoded caption content for the carrusel item.
     *
     * @return string The encoded caption content.
     */
    public function getCaption(): string
    {
        return $this->encodeCaption ? Html::encode($this->caption) : $this->caption;
    }

    /**
     * Returns the image URL for the carrusel item.
     *
     * @return string The image URL.
     */
    public function getImage(): Img
    {
        return $this->image;
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
