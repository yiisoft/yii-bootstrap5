Html helper
===========

Bootstrap introduce muchas construcciones y esqueletos consistentes de HTML, que permiten crear diferentes efectos visuales.
Unicamente lo más complejo está cubierto por los widgets proporcionados en esta extensión. El resto debería ser
compuesto manualmente usando HTML directamente.
Sin embargo, algunas marcas especiales de Bootstrap son cubiertas por el helper [[\Yiisoft\Yii\Bootstrap4\Html]].
[[\Yiisoft\Yii\Bootstrap4\Html]] es una versión mejorada de la regular [[\yii\helpers\Html]] dedicada a las necesidades de Bootstrap.
Proporciona varios métodos útiles:

 - `icon()` - permite renderizar iconos de Glyphicon
 - `staticControl()` - permite renderizar formularios "static controls"

[[\Yiisoft\Yii\Bootstrap4\Html]] hereda todas las funcionalidades disponibles en [[\yii\helpers\Html]] y puede usarse como sustituto,
así que no es necesario incluir ambos dentro de los archivos de tus vistas.
Por ejemplo:

```php
<?php
use Yiisoft\Yii\Bootstrap4\Html;
?>
<?= Button::widget([
    'label' => Html::icon('approve') . Html::encode('Save & apply'),
    'encodeLabel' => false,
    'options' => ['class' => 'btn-primary'],
]); ?>
```

> Atención: no confundas [[\Yiisoft\Yii\Bootstrap4\Html]] con [[\yii\helpers\Html]], ten cuidado que clases estás usando dentro de tus vistas.
