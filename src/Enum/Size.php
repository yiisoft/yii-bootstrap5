<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

enum Size: string
{
    case ExtraSmall = 'xs';
    case Small = 'sm';
    case Medium = 'md';
    case Large = 'lg';
    case ExtraLarge = 'xl';
    case ExtraExtraLarge = 'xxl';

    public function formatClassName(string $prefix, ?string $suffix = null): string
    {
        if ($this === self::ExtraSmall) {
            return $prefix . ($suffix ? '-' . $suffix : '');
        }

        return $prefix . '-' . $this->value . ($suffix ? '-' . $suffix : '');
    }
}
