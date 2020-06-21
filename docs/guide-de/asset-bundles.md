Asset Bundles
=============

Bootstrap ist eine komplexe Front-End-Lösung, welche CSS, Javascript, Schriften usw. beinhaltet.
Um Ihnen die flexibelste Kontrolle über die einzelnen Komponenten zu ermöglichen enthält diese Erweiterung verschiedene Asset Bundles.

Das sind:
- [[Yiisoft\Yii\Bootstrap4\BootstrapAsset|BootstrapAsset]] - enthält nur das hauptsächliche CSS.
- [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset|BootstrapPluginAsset]] - enthält das Javascript. Abhängig von [[Yiisoft\Yii\Bootstrap4\BootstrapAsset]].

Verschiedene Anwendunganforderungen erfordern verschiedene Bundles (bzw. Kombinationen).
Falls Sie nur auf das CSS angewiesen sind, reicht es wenn Sie [[Yiisoft\Yii\Bootstrap4\BootstrapAsset]] laden.
Wenn Sie das Javascript verwenden möchten, müssen Sie [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]] auch laden.

> Tipp: Die meisten Widgets laden [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]] automatisch.
