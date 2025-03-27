<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests\Provider;

use Yiisoft\Bootstrap5\Utility\BackgroundColor;

final class BackgroundColorProvider
{
    public static function variant(): array
    {
        return [
            [BackgroundColor::BLACK, 'bg-black'],
            [BackgroundColor::BODY, 'bg-body'],
            [BackgroundColor::BODY_SECONDARY, 'bg-body-secondary'],
            [BackgroundColor::BODY_TERTIARY, 'bg-body-tertiary'],
            [BackgroundColor::DANGER, 'bg-danger'],
            [BackgroundColor::DANGER_SUBTLE, 'bg-danger-subtle'],
            [BackgroundColor::DARK, 'bg-dark'],
            [BackgroundColor::DARK_SUBTLE, 'bg-dark-subtle'],
            [BackgroundColor::INFO, 'bg-info'],
            [BackgroundColor::INFO_SUBTLE, 'bg-info-subtle'],
            [BackgroundColor::LIGHT, 'bg-light'],
            [BackgroundColor::LIGHT_SUBTLE, 'bg-light-subtle'],
            [BackgroundColor::PRIMARY, 'bg-primary'],
            [BackgroundColor::PRIMARY_SUBTLE, 'bg-primary-subtle'],
            [BackgroundColor::SECONDARY, 'bg-secondary'],
            [BackgroundColor::SECONDARY_SUBTLE, 'bg-secondary-subtle'],
            [BackgroundColor::SUCCESS, 'bg-success'],
            [BackgroundColor::SUCCESS_SUBTLE, 'bg-success-subtle'],
            [BackgroundColor::TRANSPARENT, 'bg-transparent'],
            [BackgroundColor::WARNING, 'bg-warning'],
            [BackgroundColor::WARNING_SUBTLE, 'bg-warning-subtle'],
            [BackgroundColor::WHITE, 'bg-white'],
        ];
    }
}
