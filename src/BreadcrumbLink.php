<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

final class BreadcrumbLink
{
    public function __construct(
        public readonly string $label = '',
        public readonly string|null $url = null,
        public readonly array $attributes = []
    ) {
    }
}
