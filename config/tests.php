<?php

return [
    'app' => [
        'id' => 'testapp',
        'aliases' => [
            '@webroot' => '@yii/bootstrap4/tests',
            '@public'  => '@yii/bootstrap4/tests',
            '@web'     => '@yii/bootstrap4/tests',
            '@bower'   => '@vendor/bower-asset',
            '@npm'     => '@vendor/npm-asset',
        ],
    ],
    'request' => [
        'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
        'scriptFile' => __DIR__ . '/index.php',
        'scriptUrl' => '/index.php',
    ],
    'assetManager' => [
        '__class'   => \yii\web\AssetManager::class,
        'basePath'  => '@webroot/assets',
        'baseUrl'   => '@web/assets',
    ],
    'session' => [
        '__class' => \yii\captcha\tests\data\Session::class,
    ],
];
