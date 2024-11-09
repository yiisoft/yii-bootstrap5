<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Img;

/**
 * Represents a carousel item.
 */
final class CarouselItem
{
    public function __construct(
        private readonly string|Stringable|Img $content = '',
        private readonly string|null $contentCaption = null,
        private readonly string|null $contentCaptionPlaceholder = null,
        private readonly int|null $autoPlayingInterval = null,
        private readonly bool $active = false,
        private readonly bool $encodeContentCaption = true,
        private readonly bool $encodeContentCaptionPlaceholder = true,
        private readonly array $attributes = [],
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
     * @return Img|string|Stringable Returns the content for the carrusel item.
     */
    public function getContent(): string|Stringable|Img
    {
        return $this->content;
    }

    /**
     * @return string|null Returns the caption content for the carrusel item.
     */
    public function getContentCaption(): string|null
    {
        return $this->encodeContentCaption
            ? Html::encode($this->contentCaption) : $this->contentCaption;
    }

    /**
     * @return string|null Returns the caption placeholder for the carrusel item.
     */
    public function getContentCaptionPlaceholder(): string|null
    {
        return $this->encodeContentCaptionPlaceholder
            ? Html::encode($this->contentCaptionPlaceholder) : $this->contentCaptionPlaceholder;
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
