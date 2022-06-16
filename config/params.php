<?php

declare(strict_types=1);

/**
 * For use bootstrap theme i386 style as default in Yii Forms set `$params['yiisoft/form']['defaultConfig']` to `bootstrap`.
 */

return [
    'yii-bootstrap.386/form' => [
        'configs' => [
            'yii-bootstrap386' => [
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
