<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;

final class BreadcrumbLink
{
    private array $attributes = [];

    public function __construct(
        public readonly string $label = '',
        public readonly string|null $url = null,
    ) {
    }

    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $values);

        return $new;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
