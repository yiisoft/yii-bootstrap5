<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Provider;

use Yiisoft\Yii\Bootstrap5\ButtonVariant;

final class ButtonProvider
{
    public static function variant(): array
    {
        return [
            [
                ButtonVariant::PRIMARY,
                <<<HTML
                <button type="button" class="btn btn-primary">A simple btn-primary check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::SECONDARY,
                <<<HTML
                <button type="button" class="btn btn-secondary">A simple btn-secondary check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::SUCCESS,
                <<<HTML
                <button type="button" class="btn btn-success">A simple btn-success check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::DANGER,
                <<<HTML
                <button type="button" class="btn btn-danger">A simple btn-danger check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::WARNING,
                <<<HTML
                <button type="button" class="btn btn-warning">A simple btn-warning check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::INFO,
                <<<HTML
                <button type="button" class="btn btn-info">A simple btn-info check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::LIGHT,
                <<<HTML
                <button type="button" class="btn btn-light">A simple btn-light check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::DARK,
                <<<HTML
                <button type="button" class="btn btn-dark">A simple btn-dark check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_PRIMARY,
                <<<HTML
                <button type="button" class="btn btn-outline-primary">A simple btn-outline-primary check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_SECONDARY,
                <<<HTML
                <button type="button" class="btn btn-outline-secondary">A simple btn-outline-secondary check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_SUCCESS,
                <<<HTML
                <button type="button" class="btn btn-outline-success">A simple btn-outline-success check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_DANGER,
                <<<HTML
                <button type="button" class="btn btn-outline-danger">A simple btn-outline-danger check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_WARNING,
                <<<HTML
                <button type="button" class="btn btn-outline-warning">A simple btn-outline-warning check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_INFO,
                <<<HTML
                <button type="button" class="btn btn-outline-info">A simple btn-outline-info check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_LIGHT,
                <<<HTML
                <button type="button" class="btn btn-outline-light">A simple btn-outline-light check it out!</button>
                HTML,
            ],
            [
                ButtonVariant::OUTLINE_DARK,
                <<<HTML
                <button type="button" class="btn btn-outline-dark">A simple btn-outline-dark check it out!</button>
                HTML,
            ],
        ];
    }
}
