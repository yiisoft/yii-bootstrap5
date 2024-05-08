アセット・バンドル
==================

Bootstrap は、CSS、JavaScript、フォントなどを含む複雑なフロントエンド・ソリューションです。
Bootstrap コンポーネントに対する最大限の柔軟な制御を可能にするために、このエクステンションは複数のアセット・バンドルを提供しています。
すなわち、

- [[Yiisoft\Yii\Bootstrap4\BootstrapAsset|BootstrapAsset]] - メインの CSS ファイルのみを含みます。
- [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset|BootstrapPluginAsset]] - [[Yiisoft\Yii\Bootstrap4\BootstrapAsset]] に依存し、javascript ファイルを含みます。

個々のアプリケーションは、その要求に応じて、異なるバンドル (またはバンドルの組み合わせ) を必要とするでしょう。
CSS のスタイルだけが必要なのであれば、[[Yiisoft\Yii\Bootstrap4\BootstrapAsset]] だけで十分です。
しかし、Bootstrap の JavaScript を必要とする場合は、[[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]]
をも登録しなければなりません。

> Tip: ほとんどのウィジェットは [[Yiisoft\Yii\Bootstrap4\BootstrapPluginAsset]] を自動的に登録します。
