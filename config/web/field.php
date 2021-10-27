<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\Field;

/** @var array $params */

if ($params['yiisoft/form']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => Field::widget($params['yiisoft/form']['bootstrap5']['fieldConfig']),
    ];
}
