<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;

/**
 * Represents a carousel item.
 */
final class CarouselItem
{
    public function __construct(
        private readonly string|Stringable $content = '',
        private readonly string|null $caption = null,
        private readonly string|null $captionPlaceholder = null,
        private readonly int|null $autoPlayingInterval = null,
        private readonly bool $active = false,
        private readonly bool $encodeCaption = true,
        private readonly bool $encodeCaptionPlaceholder = true,
        private readonly array $attributes = [],
        private readonly array $captionAttributes = [],
        private readonly array $captionPlaceholderAttributes = [],
    ) {
    }

    /**
     * @return array Returns the HTML attributes for the carrusel item.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return int|null Returns the auto playing interval for the carrusel item.
     */
    public function getAutoPlayingInterval(): int|null
    {
        return $this->autoPlayingInterval;
    }

    /**
     * @return string|null Returns the caption content for the carrusel item.
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
     * @return string|null Returns the caption placeholder content for the carrusel item.
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
     * @return string|Stringable Returns the content for the carrusel item.
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
