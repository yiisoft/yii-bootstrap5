Asset Bundles
=============

Bootstrap - это комплексное front-end решение, включающее CSS, JavaScript, шрифты и т.д. Для того чтобы обеспечить гибкий контроль над компонентами Bootstrap, расширение предоставляет несколько Asset Bundles. Вот они:

- [[Yiisoft\Yii\Bootstrap4\BootstrapAsset|BootstrapAsset]] - содержит CSS файлы.
- [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset|BootstrapPluginAsset]] - зависит от [[Yiisoft\Yii\Bootstrap4\BootstrapAsset]], содержащий javascript файлы.

Конкретные приложения могут потребовать различного использования. Если вам нужны только CSS-стили, то пакета [[Yiisoft\Yii\Bootstrap4\BootstrapAsset]] будет достаточно. Тем не менее, если вы хотите использовать Bootstrap JavaScript, вам необходимо зарегистрировать [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]].

> Tip: большинство виджетов регистрируются с помощью [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]] автоматически.
