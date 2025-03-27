Migrating from Yii2 bootstrap
=============================

According to [Migrating to v5](https://getbootstrap.com/docs/5.0/migration/), Bootstrap 5 is a major rewrite of the entire project.
The same goes for this package.
The most notable changes are summarized below:

## General

* The namespace is `Yiisoft\Bootstrap5`
* `npm` package is used instead of `bower`
* There is no theme asset anymore
* No `popper.js` is needed any more (gets delivered with bootstrap js bundle) 

## Widgets / Classes

* [[yii\bootstrap\Collapse|Collapse]] was renamed to [[Yiisoft\Bootstrap5\Accordion|Accordion]]
* [[yii\bootstrap\BootstrapThemeAsset|BootstrapThemeAsset]] was removed
* [[Yiisoft\Bootstrap5\Breadcrumbs|Breadcrumbs]] was added (Bootstrap 4 implementation of [[yii\widgets\Breadcrumbs]])
* [[Yiisoft\Bootstrap5\ButtonToolbar|ButtonToolbar]] was added (https://getbootstrap.com/docs/4.2/components/button-group/#button-toolbar)

