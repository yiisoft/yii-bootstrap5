Using the .sass files of Bootstrap directly
===========================================

If you want to include the [Bootstrap css directly in your sass files](https://getbootstrap.com/getting-started/#customizing)
you may need to disable the bootstrap css files loaded by this extension.
You can do this by setting the css property of [[Yiisoft\Yii\Bootstrap5\BootstrapAsset|BootstrapAsset]] to be empty.
For this, you need to configure the `assetManager` [application component](https://github.com/yiisoft/yii2/blob/master/docs/guide/structure-application-components.md) as follows:

```php
    'assetManager' => [
        'bundles' => [
            'Yiisoft\Yii\Bootstrap5\BootstrapAsset' => [
                'css' => [],
            ]
        ]
    ]
```
