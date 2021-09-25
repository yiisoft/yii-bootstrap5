<?php

declare(strict_types=1);

return [
    'yiisoft/form' => [
        'bootstrap5' => [
            'enabled' => true,
            'fieldConfig' => [
                'containerClass()' => ['mb-3'],
                'invalidClass()' => ['is-invalid'],
                'errorClass()' => ['text-danger fst-italic'],
                'hintClass()' => ['form-text'],
                'inputClass()' => ['form-control'],
                'labelClass()' => ['form-label'],
                'validClass()' => ['is-valid'],
            ],
        ],
    ],
];
