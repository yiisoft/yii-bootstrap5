Migrating from yii-bootstrap3
=============================

According to [Migrating to v5](https://getbootstrap.com/docs/5.0/migration/), Bootstrap 5 is a major rewrite of the entire project.
The same goes for yii-bootstrap5.
The most notable changes are summarized below:

## General

* The namespace is `Yiisoft\Yii\Bootstrap5` instead of `yii\bootstrap`
* `npm` package is used instead of `bower`
* There is no theme asset any more
* No `popper.js` is needed any more (gets delivered with bootstrap js bundle) 

## Widgets / Classes

* [[yii\bootstrap\Collapse|Collapse]] was renamed to [[Yiisoft\Yii\Bootstrap5\Accordion|Accordion]]
* [[yii\bootstrap\BootstrapThemeAsset|BootstrapThemeAsset]] was removed
* [[Yiisoft\Yii\Bootstrap5\Breadcrumbs|Breadcrumbs]] was added (Bootstrap 4 implementation of [[yii\widgets\Breadcrumbs]])
* [[Yiisoft\Yii\Bootstrap5\ButtonToolbar|ButtonToolbar]] was added (https://getbootstrap.com/docs/4.2/components/button-group/#button-toolbar)

