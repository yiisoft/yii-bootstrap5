<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\Utility\TextColorBackground;

final class TextColorBackgroundProvider
{
    public static function variant(): array
    {
        return [
            [TextColorBackground::PRIMARY, 'text-bg-primary'],
            [TextColorBackground::SECONDARY, 'text-bg-secondary'],
            [TextColorBackground::SUCCESS, 'text-bg-success'],
            [TextColorBackground::DANGER, 'text-bg-danger'],
            [TextColorBackground::WARNING, 'text-bg-warning'],
            [TextColorBackground::INFO, 'text-bg-info'],
            [TextColorBackground::LIGHT, 'text-bg-light'],
            [TextColorBackground::DARK, 'text-bg-dark'],
        ];
    }
}
