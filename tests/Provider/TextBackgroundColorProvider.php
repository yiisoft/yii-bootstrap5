<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests\Provider;

use Yiisoft\Bootstrap5\Utility\TextBackgroundColor;

final class TextBackgroundColorProvider
{
    public static function variant(): array
    {
        return [
            [TextBackgroundColor::PRIMARY, 'text-bg-primary'],
            [TextBackgroundColor::SECONDARY, 'text-bg-secondary'],
            [TextBackgroundColor::SUCCESS, 'text-bg-success'],
            [TextBackgroundColor::DANGER, 'text-bg-danger'],
            [TextBackgroundColor::WARNING, 'text-bg-warning'],
            [TextBackgroundColor::INFO, 'text-bg-info'],
            [TextBackgroundColor::LIGHT, 'text-bg-light'],
            [TextBackgroundColor::DARK, 'text-bg-dark'],
        ];
    }
}
