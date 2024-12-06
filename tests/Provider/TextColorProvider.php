<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\Utility\TextColor;

final class TextColorProvider
{
    public static function variant(): array
    {
        return [
            [TextColor::PRIMARY, 'text-primary'],
            [TextColor::PRIMARY_EMPHASIS, 'text-primary-emphasis'],
            [TextColor::SECONDARY, 'text-secondary'],
            [TextColor::SECONDARY_EMPHASIS, 'text-secondary-emphasis'],
            [TextColor::SUCCESS, 'text-success'],
            [TextColor::SUCCESS_EMPHASIS, 'text-success-emphasis'],
            [TextColor::DANGER, 'text-danger'],
            [TextColor::DANGER_EMPHASIS, 'text-danger-emphasis'],
            [TextColor::WARNING, 'text-warning'],
            [TextColor::WARNING_EMPHASIS, 'text-warning-emphasis'],
            [TextColor::INFO, 'text-info'],
            [TextColor::INFO_EMPHASIS, 'text-info-emphasis'],
            [TextColor::LIGHT, 'text-light'],
            [TextColor::LIGHT_EMPHASIS, 'text-light-emphasis'],
            [TextColor::DARK, 'text-dark'],
            [TextColor::DARK_EMPHASIS, 'text-dark-emphasis'],
            [TextColor::BODY, 'text-body'],
            [TextColor::BODY_EMPHASIS, 'text-body-emphasis'],
            [TextColor::BODY_SECONDARY, 'text-body-secondary'],
            [TextColor::BODY_TERTIARY, 'text-body-tertiary'],
            [TextColor::BLACK, 'text-black'],
            [TextColor::WHITE, 'text-white'],
        ];
    }
}
