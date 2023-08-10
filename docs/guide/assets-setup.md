Assets Setup
============

## Using CDN

You may use Bootstrap assets from [official CDN](https://www.bootstrapcdn.com).

In the `composer.json` of your project, add the following lines in order to prevent redundant Bootstrap asset installation:

```json
"replace": {
    "npm-asset/bootstrap": ">=4.2.1"
},
```

Configure 'assetManager' application component, overriding Bootstrap asset bundles with CDN links:

```php
return [
    'components' => [
        'assetManager' => [
            // override bundles to use CDN :
            'bundles' => [
                'Yiisoft\Yii\Bootstrap5\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1',
                    'css' => [
                        'css/bootstrap.min.css'
                    ],
                ],
                'Yiisoft\Yii\Bootstrap5\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1',
                    'js' => [
                        'js/bootstrap.bundle.min.js'
                    ],
                ],
            ],
        ],
        // ...
    ],
    // ...
];
```


## Compiling from the .sass files

If you want to customize the Bootstrap CSS source directly, you may want to compile it from source *.sass files.

In such case installing Bootstrap assets from Composer or Bower/NPM makes no sense, since you can not modify files
inside 'vendor' directory.
You'll have to download Bootstrap assets manually and place them somewhere inside your project source code,
for example in the 'assets/source/bootstrap' folder.

In the `composer.json` of your project, add the following lines in order to prevent redundant Bootstrap asset installation:

```json
"replace": {
    "npm-asset/bootstrap": ">=4.2.1"
},
```

Configure 'assetManager' application component, overriding Bootstrap asset bundles:

```php
return [
    'components' => [
        'assetManager' => [
            // override bundles to use local project files :
            'bundles' => [
                'Yiisoft\Yii\Bootstrap5\BootstrapAsset' => [
                    'sourcePath' => '@app/assets/source/bootstrap/dist',
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ],
                ],
                'Yiisoft\Yii\Bootstrap5\BootstrapPluginAsset' => [
                    'sourcePath' => '@app/assets/source/bootstrap/dist',
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ],
            ],
        ],
        // ...
    ],
    // ...
];
```

After you make changes to Bootstrap's source files, make sure to [compile them](https://getbootstrap.com/docs/4.1/getting-started/build-tools/), eg. using `npm run dist`.
