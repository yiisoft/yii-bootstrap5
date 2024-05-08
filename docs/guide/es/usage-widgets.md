Yii widgets
===========

La mayoría de los componentes de bootstrap están encapsulados dentro de Yii widgets lo que permite una sintaxis
más robusta y poder integrarse con las características del framework. Todos los widgets pertenecen
al namespace `\Yiisoft\Yii\Bootstrap4`:

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


## Personalización de las clases css para los widget <span id="customizing-css-classes"></span>

Los widgets permiten una rápida composición del HTML para los componentes de bootstrap que requieren las clases
CSS de bootstrap.
Las clases por defecto para un componente en particular serán añadidas automáticamente por los widgets, y las clases
opcionales que quieres personalizar son frecuentemente soportadas a través de las propiedades de los widgets.

Por ejemplo, puedas usar [[Yiisoft\Yii\Bootstrap4\Button::options]] para personalizar la apariencia de un botón.
La clase 'btn' que se requiere para un botón será añadida automáticamente, por lo que no necesitas preocuparte
por ello.
Todo lo que necesitas es especificar una clase de botón en particular:

```php
echo Button::widget([
    'label' => 'Action',
    'options' => ['class' => 'btn-primary'], // produce la clase "btn btn-primary"
]);
```

Sin embargo, a veces puede que tengas que remplazar las clases por defecto por las alternativas.
Por ejemplo, el widget [[Yiisoft\Yii\Bootstrap4\ButtonGroup]] utiliza por defecto la clase 'btn-group' para el contenido del div, pero necesitas usar 'btn-group-vertical' en lugar de alinear los botones verticalmente.
El uso directo de la opción 'class' simplemente añade 'btn-group-vertical' a 'btn-group, el cual producirá un resultado incorrecto.
Con el fin de sobrescribir las clases por defecto de un widget, necesitas especificar la opción 'class' como un
array que contiene la definición de la clase personalizada bajo la clave 'widget':

```php
echo ButtonGroup::widget([
    'options' => [
        'class' => ['widget' => 'btn-group-vertical'] // remplaza 'btn-group' con 'btn-group-vertical'
    ],
    'buttons' => [
        ['label' => 'A'],
        ['label' => 'B'],
    ]
]);
```
