<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;

final class DropdownItem
{
    public function __construct(
        private readonly string $label = '',
        private readonly string|null $url = null,
        private readonly bool $divider = false,
        private readonly bool $text = false,
        private readonly bool $active = false,
        private readonly bool $disabled = false,
        private readonly bool $encodeLabel = true,
        private readonly array $attributes = [],
    ) {
        if ($this->active && $this->disabled) {
            throw new InvalidArgumentException('The dropdown item cannot be active and disabled at the same time.');
        }

        if ($this->divider && $this->text) {
            throw new InvalidArgumentException('The dropdown item cannot be a divider and text at the same time.');
        }
    }

    /**
     * @return array Returns the HTML attributes for the link.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string Returns the encoded label content.
     */
    public function getLabel(): string
    {
        return $this->encodeLabel ? Html::encode($this->label) : $this->label;
    }

    /**
     * @return string|null Returns the URL for the link.
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

    /**
     * @return bool Whether the item is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return bool Whether the item is a divider.
     */
    public function isDivider(): bool
    {
        return $this->divider;
    }

    /**
     * @return bool Whether the item is a text.
     */
    public function isText(): bool
    {
        return $this->text;
    }
}
