<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\Utility\ColorText;

final class ColorTextProvider
{
    public static function variant(): array
    {
        return [
            [ColorText::PRIMARY, 'text-primary'],
            [ColorText::PRIMARY_EMPHASIS, 'text-primary-emphasis'],
            [ColorText::SECONDARY, 'text-secondary'],
            [ColorText::SECONDARY_EMPHASIS, 'text-secondary-emphasis'],
            [ColorText::SUCCESS, 'text-success'],
            [ColorText::SUCCESS_EMPHASIS, 'text-success-emphasis'],
            [ColorText::DANGER, 'text-danger'],
            [ColorText::DANGER_EMPHASIS, 'text-danger-emphasis'],
            [ColorText::WARNING, 'text-warning'],
            [ColorText::WARNING_EMPHASIS, 'text-warning-emphasis'],
            [ColorText::INFO, 'text-info'],
            [ColorText::INFO_EMPHASIS, 'text-info-emphasis'],
            [ColorText::LIGHT, 'text-light'],
            [ColorText::LIGHT_EMPHASIS, 'text-light-emphasis'],
            [ColorText::DARK, 'text-dark'],
            [ColorText::DARK_EMPHASIS, 'text-dark-emphasis'],
            [ColorText::BODY, 'text-body'],
            [ColorText::BODY_EMPHASIS, 'text-body-emphasis'],
            [ColorText::BODY_SECONDARY, 'text-body-secondary'],
            [ColorText::BODY_TERTIARY, 'text-body-tertiary'],
            [ColorText::BLACK, 'text-black'],
            [ColorText::WHITE, 'text-white'],
        ];
    }
}
