Migration von yii2-bootstrap
============================

yii2-bootstrap4 ist eine komplette Überarbeitung des Projekts (siehe den Bootstrap 4 von Bootstrap 3 Migrationsguide).
Die grössten Änderungen finden Sie hier zusammengefasst:

## Allgemein

* Der Namespace ist nun `Yiisoft\Yii\Bootstrap4` anstatt `yii\bootstrap`
* Es wird das `npm` Paket verwendet anstatt das `bower` Paket
* Es gibt kein Theme Asset mehr
* `popper.js` muss nicht mehr extra installiert werden (wird vom Bootstrap JS Bundle mitgeliefert) 

## Widgets / Klassen

* [[yii\bootstrap\Collapse|Collapse]] wurde umbenannt zu [[Yiisoft\Yii\Bootstrap4\Accordion|Accordion]]
* [[yii\bootstrap\BootstrapThemeAsset|BootstrapThemeAsset]] wurde entfernt
* [[Yiisoft\Yii\Bootstrap4\Breadcrumbs|Breadcrumbs]] wurde hinzugefügt (Bootstrap 4 Implementation von [[yii\widgets\Breadcrumbs]])
* [[Yiisoft\Yii\Bootstrap4\ButtonToolbar|ButtonToolbar]] wurde hinzugefügt (https://getbootstrap.com/docs/4.2/components/button-group/#button-toolbar)


