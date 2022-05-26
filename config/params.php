<?php

declare(strict_types=1);

/**
 * For use bootstrap 5 style as default in Yii Forms set `$params['yiisoft/form']['defaultConfig']` to `bootstrap5`.
 */

return [
    'yiisoft/form' => [
        'configs' => [
            'bootstrap5' => [
                'containerClass' => 'mb-3',
                'invalidClass' => 'is-invalid',
                'errorClass' => 'text-danger fst-italic',
                'hintClass' => 'form-text',
                'inputClass' => 'form-control',
                'labelClass' => 'form-label',
                'validClass' => 'is-valid',
            ],
        ],
    ],
];
