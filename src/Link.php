<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

final class Link
{
    private array $attributes = [];
    private bool $active = false;

    public function __construct(
        public readonly string $label = '',
        public readonly string|null $url = null,
    ) {
    }

    /**
     * Sets the HTML attributes for the breadcrumb item.
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
     * Sets the active state of the breadcrumb item.
     *
     * @param bool $value Whether the item is active.
     *
     * @return self A new instance with the specified active state.
     */
    public function active(bool $value = true): self
    {
        $new = clone $this;
        $new->active = $value;

        return $new;
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
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
