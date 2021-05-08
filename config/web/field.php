<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\Field;

if ($params['yiisoft/form']['bootstrap5']['enabled'] === true) {
    return [
        Field::class => static fn () => Field::widget($params['yiisoft/form']['bootstrap5']['fieldConfig']),
    ];
}
