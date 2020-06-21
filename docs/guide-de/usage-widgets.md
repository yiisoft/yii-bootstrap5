Yii widgets
===========

Die komplexesten Bootstrap Komponenten sind umgesetzt mittels Yii-Widget zur vereinfachten Verwendung und Integration 
von Framework-Funktionen. Alle Widgets gehören zum `\Yiisoft\Yii\Bootstrap4` Namespace:

- [[Yiisoft\Yii\Bootstrap4\Accordion|Accordion]]
- [[Yiisoft\Yii\Bootstrap4\ActiveField|ActiveField]]
- [[Yiisoft\Yii\Bootstrap4\ActiveForm|ActiveForm]]
- [[Yiisoft\Yii\Bootstrap4\Alert|Alert]]
- [[Yiisoft\Yii\Bootstrap4\Breadcrumbs|Breadcrumbs]]
- [[Yiisoft\Yii\Bootstrap4\Button|Button]]
- [[Yiisoft\Yii\Bootstrap4\ButtonDropdown|ButtonDropdown]]
- [[Yiisoft\Yii\Bootstrap4\ButtonGroup|ButtonGroup]]
- [[Yiisoft\Yii\Bootstrap4\ButtonToolbar|ButtonToolbar]]
- [[Yiisoft\Yii\Bootstrap4\Carousel|Carousel]]
- [[Yiisoft\Yii\Bootstrap4\Dropdown|Dropdown]]
- [[Yiisoft\Yii\Bootstrap4\Modal|Modal]]
- [[Yiisoft\Yii\Bootstrap4\Nav|Nav]]
- [[Yiisoft\Yii\Bootstrap4\NavBar|NavBar]]
- [[Yiisoft\Yii\Bootstrap4\Progress|Progress]]
- [[Yiisoft\Yii\Bootstrap4\Tabs|Tabs]]
- [[Yiisoft\Yii\Bootstrap4\ToggleButtonGroup|ToggleButtonGroup]]


## Anpassen der Widget CSS-Klassen <span id="customizing-css-classes"></span>

Die Widgets erlauben die schnelle Erstellung von HTML-Markup der Bootstrap Komponenten.
Die Standard-CSS-Klassen einer bestimmten Komponente wird automatisch vom Widget hinzugefügt. Alle weiteren (optionalen)
Klassen können Sie mittels der Attribute des Widgets anpassen.

Verwenden Sie z.B. [[Yiisoft\Yii\Bootstrap4\Button::options]] zur Anpassung des Aussehens des Buttons. Die Klasse `btn`, welche
benötigt vom Button Widget benötigt wird, wird automatisch hinzugefügt. Sie müssen lediglich die besondere Button-Klasse
hinzufügen:

```php
echo Button::widget([
    'label' => 'Action',
    'options' => ['class' => 'btn-primary'], // produces class "btn btn-primary"
]);
```

Manchmal möchte man aber die Standard-Klasse ersetzen.
Das [[Yiisoft\Yii\Bootstrap4\ButtonGroup]]-Widget beispielsweise verwendet standardmässig die 'btn-group' Klasse für den Container,
es müsste aber 'btn-group-vertical' erhalten zur vertikalen Ausrichtung.
Würden Sie wie oben nur die 'class'-Option verwenden, würde die 'btn-group-vertical'-Klasse zur 'btn-group'-Klasse hinzugefügt.
Zum Überschreiben der Standard-Klassen eines Widgets, müssen Sie die 'class'-Option unter dem Array-Schlüssel 'widget' angeben:

```php
echo ButtonGroup::widget([
    'options' => [
        'class' => ['widget' => 'btn-group-vertical'] // replaces 'btn-group' with 'btn-group-vertical'
    ],
    'buttons' => [
        ['label' => 'A'],
        ['label' => 'B'],
    ]
]);
```


## Navbar widget <span id="navbar-widget"></span>

Das Navbar Widget hat so seine Eigenheiten. Bei der Verwendung des Widgets sollten Sie darauf achten, dass der Breakpoint,
ab welchem die Navigation zugeklappt wird (Mobile Navigation) sowie das Farbschema definiert sind.

Diese Definition geschieht über CSS Klassen. Die Standartwerte lauten `navbar-light bg-light` fürs Farbschema und
`navbar-expand-lg` für den brakpoint. Für weitere Informationen, konsultieren Sie die [Bootstrap Dokumentation](https://getbootstrap.com/docs/4.2/components/navbar/):
```php
Navbar::begin([
    'options' => [
        'class' => ['navbar-dark', 'bg-dark', 'navbar-expand-md']
    ]
]);
    [...]
Navbar::end();
``` 

Falls Sie die Reihenfolge des Logos und des "Toggle Buttons" ändern möchten, können Sie dies wie folgt tun:
```php
Navbar::begin([
	'brandOptions' => [
		'class' => ['order-1']
	],
	'togglerOptions' => [
		'class' => ['order-0']
	]
]);
    [...]
Navbar::end();
```
