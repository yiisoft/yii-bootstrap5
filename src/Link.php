<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

final class Link
{
    private array $attributes = [];

    public function __construct(
        public readonly string $label = '',
        public readonly string|null $url = null,
    ) {
    }

    /**
     * Sets the HTML attributes for the link.
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
     * Returns the HTML attributes for the link.
     *
     * @return array The attributes.
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
