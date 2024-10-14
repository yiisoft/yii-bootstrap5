<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\AlertType;

final class AlertProvider
{
    public static function type(): array
    {
        return [
            [
                AlertType::PRIMARY,
                <<<HTML
                <div class="alert alert-primary" role="alert">
                A simple alert-primary check it out!
                </div>
                HTML,
            ],
            [
                AlertType::SECONDARY,
                <<<HTML
                <div class="alert alert-secondary" role="alert">
                A simple alert-secondary check it out!
                </div>
                HTML,
            ],
            [
                AlertType::SUCCESS,
                <<<HTML
                <div class="alert alert-success" role="alert">
                A simple alert-success check it out!
                </div>
                HTML,
            ],
            [
                AlertType::DANGER,
                <<<HTML
                <div class="alert alert-danger" role="alert">
                A simple alert-danger check it out!
                </div>
                HTML,
            ],
            [
                AlertType::WARNING,
                <<<HTML
                <div class="alert alert-warning" role="alert">
                A simple alert-warning check it out!
                </div>
                HTML,
            ],
            [
                AlertType::INFO,
                <<<HTML
                <div class="alert alert-info" role="alert">
                A simple alert-info check it out!
                </div>
                HTML,
            ],
            [
                AlertType::LIGHT,
                <<<HTML
                <div class="alert alert-light" role="alert">
                A simple alert-light check it out!
                </div>
                HTML,
            ],
            [
                AlertType::DARK,
                <<<HTML
                <div class="alert alert-dark" role="alert">
                A simple alert-dark check it out!
                </div>
                HTML,
            ],
        ];
    }
}
