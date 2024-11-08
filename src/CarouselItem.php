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
        private readonly string $captionPlaceholder = '',
        private readonly int|null $autoPlayingInterval = null,
        private readonly bool $active = false,
        private readonly bool $encodeCaption = true,
        private readonly bool $encodeCaptionPlaceholder = true,
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
     * Returns the auto playing interval for the carrusel item.
     *
     * @return int|null The auto playing interval.
     */
    public function getAutoPlayingInterval(): int|null
    {
        return $this->autoPlayingInterval;
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
     * Returns the caption placeholder for the carrusel item.
     *
     * @return string The caption placeholder.
     */
    public function getCaptionPlaceholder(): string
    {
        return $this->encodeCaptionPlaceholder ? Html::encode($this->captionPlaceholder) : $this->captionPlaceholder;
    }

    /**
     * Returns the image URL for the carrusel item.
     *
     * @return Img The image URL.
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
