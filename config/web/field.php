<?php

declare(strict_types=1);

use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Form\Widget\Field;

/** @var array $params */

if ($params['yiisoft/form']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => DynamicReference::to(
            static function (array $params): Field {
                return Field::widget($params['yiisoft/form']['bootstrap5']['fieldConfig']);
            }
        ),
    ];
}
