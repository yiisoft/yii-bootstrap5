<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

enum NavType: string
{
    case Tabs = 'nav-tabs';
    case Pills = 'nav-pills';
    case Underline = 'nav-underline';

    public function toggleComponent(): string
    {
        return match ($this) {
            self::Pills => 'pill',
            default => 'tab',
        };
    }
}
