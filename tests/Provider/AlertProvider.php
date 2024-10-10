<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\Enum\Type;

final class AlertProvider
{
    public static function type(): array
    {
        return [
            [
                Type::PRIMARY,
                <<<HTML
                <div class="alert alert-primary" role="alert">
                A simple primary alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::SECONDARY,
                <<<HTML
                <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::SUCCESS,
                <<<HTML
                <div class="alert alert-success" role="alert">
                A simple success alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::DANGER,
                <<<HTML
                <div class="alert alert-danger" role="alert">
                A simple danger alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::WARNING,
                <<<HTML
                <div class="alert alert-warning" role="alert">
                A simple warning alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::INFO,
                <<<HTML
                <div class="alert alert-info" role="alert">
                A simple info alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::LIGHT,
                <<<HTML
                <div class="alert alert-light" role="alert">
                A simple light alert—check it out!
                </div>
                HTML,
            ],
            [
                Type::DARK,
                <<<HTML
                <div class="alert alert-dark" role="alert">
                A simple dark alert—check it out!
                </div>
                HTML,
            ],
        ];
    }
}
