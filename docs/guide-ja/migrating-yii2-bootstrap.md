yii-bootstrap3 から移行する
===========================

[Migrating to v4](https://getbootstrap.com/docs/4.0/migration/) によれば、Bootstrap 4 はプロジェクト全体を書き改めたものです。
そのことは yii-bootstrap4 にも当てはまります。
最も注目すべき変更点を要約すると以下のようになります。

## 一般

* 名前空間は `yii\bootstrap` ではなく `Yiisoft\Yii\Bootstrap4` です
* `bower` パッケージではなく `npm` パッケージが使用されます
* テーマ・アセットは廃止されました
* `popper.js` は必要ではなくなりました (bootstrap の js バンドルとともに配備されます)

## ウィジェット / クラス

* [[yii\bootstrap\Collapse|Collapse]] は [[Yiisoft\Yii\Bootstrap4\Accordion|Accordion]] に名前が変更されました
* [[yii\bootstrap\BootstrapThemeAsset|BootstrapThemeAsset]] は削除されました
* [[Yiisoft\Yii\Bootstrap4\Breadcrumbs|Breadcrumbs]] が追加されました ([[yii\widgets\Breadcrumbs]] の Bootstrap 4 による実装です)
* [[Yiisoft\Yii\Bootstrap4\ButtonToolbar|ButtonToolbar]] が追加されました (https://getbootstrap.com/docs/4.2/components/button-group/#button-toolbar)

