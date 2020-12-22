<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\Field;

if (class_exists(Field::class) && $params['yiisoft/form']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => fn () => Field::Widget($params['yiisoft/form']['bootstrap5']['fieldConfig']),
    ];
}
