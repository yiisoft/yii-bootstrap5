<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;

/**
 * CarouselItem represents a single item within a Bootstrap Carousel widget.
 *
 * Each item can contain content, caption, and caption placeholder.
 *
 * The item can be set as active and supports autoplaying intervals.
 *
 * - Active state: When is `true`, sets this item as the first visible slide.
 * - Auto-playing: When enabled, cycling can be paused by hovering over the carousel, focusing on it, or clicking
 * on carousel controls/indicators.
 *
 * Example usage:
 * ```php
 * CarouselItem::to(
 *     '<img src="example.jpg" alt="Example">',
 *     'Image Caption',
 *     'Caption Placeholder'
 * );
 *
 * // Create an active carousel item with autoplay.
 * CarouselItem::to(
 *     content: '<img src="example.jpg">',
 *     caption: 'Slide 1',
 *     active: true,
 *     autoPlayingInterval: 5000
 * );
 * ```
 */
final class CarouselItem
{
    /**
     * Use {@see CarouselItem::to()} to create a new instance.
     */
    private function __construct(
        private readonly bool $active = false,
        private readonly array $attributes = [],
        private readonly int|null $autoPlayingInterval = null,
        private readonly string|null $caption = null,
        private readonly array $captionAttributes = [],
        private readonly string|null $captionPlaceholder = null,
        private readonly array $captionPlaceholderAttributes = [],
        private readonly string|Stringable $content = '',
        private readonly bool $encodeCaption = true,
        private readonly bool $encodeCaptionPlaceholder = true,
    ) {
    }

    /**
     * Creates a new {@see CarouselItem} instance.
     *
     * @param string|Stringable $content The content of the carousel item.
     * @param string|null $caption The caption content for the carousel item.
     * @param string|null $captionPlaceholder The caption placeholder content for the carousel item.
     * @param int|null $autoPlayingInterval The autoplaying interval for the carousel item.
     * @param bool $active Whether the item is active.
     * @param bool $encodeCaption Whether to encode the caption content.
     * @param bool $encodeCaptionPlaceholder Whether to encode the caption placeholder content.
     * @param array $attributes The HTML attributes for the carousel item.
     * @param array $captionAttributes The HTML attributes for the caption.
     * @param array $captionPlaceholderAttributes The HTML attributes for the caption placeholder.
     *
     * @return self A new instance with the specified configuration.
     */
    public static function to(
        string|Stringable $content = '',
        string|null $caption = null,
        string|null $captionPlaceholder = null,
        int|null $autoPlayingInterval = null,
        bool $active = false,
        bool $encodeCaption = true,
        bool $encodeCaptionPlaceholder = true,
        array $attributes = [],
        array $captionAttributes = [],
        array $captionPlaceholderAttributes = [],
    ): self {
        return new self(
            $active,
            $attributes,
            $autoPlayingInterval,
            $caption,
            $captionAttributes,
            $captionPlaceholder,
            $captionPlaceholderAttributes,
            $content,
            $encodeCaption,
            $encodeCaptionPlaceholder,
        );
    }

    /**
     * @return array Returns the HTML attributes for the carousel item.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return int|null Returns the autoplaying interval for the carousel item.
     */
    public function getAutoPlayingInterval(): int|null
    {
        return $this->autoPlayingInterval;
    }

    /**
     * @return string|null Returns the caption content for the carousel item.
     */
    public function getCaption(): string|null
    {
        return $this->encodeCaption ? Html::encode($this->caption) : $this->caption;
    }

    /**
     * @return array Returns the HTML attributes for the caption.
     */
    public function getCaptionAttributes(): array
    {
        return $this->captionAttributes;
    }

    /**
     * @return string|null Returns the caption placeholder content for the carousel item.
     */
    public function getCaptionPlaceholder(): string|null
    {
        return $this->encodeCaptionPlaceholder ? Html::encode($this->captionPlaceholder) : $this->captionPlaceholder;
    }

    /**
     * @return array Returns the HTML attributes for the caption placeholder.
     */
    public function getCaptionPlaceholderAttributes(): array
    {
        return $this->captionPlaceholderAttributes;
    }

    /**
     * @return string|Stringable Returns the content for the carousel item.
     */
    public function getContent(): string|Stringable
    {
        return $this->content;
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
