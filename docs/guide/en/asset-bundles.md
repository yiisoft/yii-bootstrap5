# Asset Bundles

Bootstrap is a complex front-end solution, which includes CSS, JavaScript, fonts, and so on.
To allow you the most flexible control over Bootstrap components, this extension provides several asset bundles.
They are:

- [[Yiisoft\Yii\Bootstrap5\BootstrapAsset|BootstrapAsset]] - contains only the main CSS files.
- [[Yiisoft\Yii\Bootstrap5\BootstrapPluginAsset|BootstrapPluginAsset]] - depends on [[Yiisoft\Yii\Bootstrap5\BootstrapAsset]],
  contains the JavaScript files.

Particular application needs may require different bundle (or bundle combination) usage.
If you only need CSS styles, [[Yiisoft\Yii\Bootstrap5\BootstrapAsset]] will be enough for you. However, if
you intend to use Bootstrap JavaScript, you will need to register [[Yiisoft\Yii\Bootstrap5\BootstrapPluginAsset]]
as well.

> Tip: most of the widgets register [[Yiisoft\Yii\Bootstrap5\BootstrapPluginAsset]] automatically.
