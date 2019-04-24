Виджеты Yii
===========

Большинство сложных Bootstrap компонентов обернуты в виджеты Yii, чтобы обеспечить более надежный синтаксис и интеграцию с особенностями фреймворка. Все виджеты относятся к пространству имен `\Yiisoft\Yii\Bootstrap4`:

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


## Настройка CSS классов виджетов <span id="customizing-css-classes"></span>

Виджеты позволяют быстро создавать HTML Bootstrap компоненты, которые требуют CSS классы Bootstrap. Классы по умолчанию, для конкретного компонента, будут добавлены автоматически виджетом, и необязательные классы, которые вы можете настроить, как правило, поддерживаются через свойства виджета.

Например, вы можете использовать [[Yiisoft\Yii\Bootstrap4\Button::options]] чтобы настроить внешний вид кнопки. Класс `btn`, который требуется для кнопки, будет добавлен автоматически. Все, что вам нужно, это указать конкретный класс кнопки:

```php
echo Button::widget([
    'label' => 'Action',
    'options' => ['class' => 'btn-primary'], // создаст класс "btn btn-primary"
]);
```

Тем не менее, иногда вам может понадобиться заменить классы по умолчанию альтернативными. Например, виджет [[Yiisoft\Yii\Bootstrap4\ButtonGroup]] использует класс `btn-group` для контейнера `div` по умолчанию, но вам, возможно, придётся использовать `btn-group-vertical` чтобы выровнять кнопки по вертикали. Добавление `btn-group-vertical` в параметр `class` приведет к неправильному результату. Для того, чтобы переопределить классы виджета по умолчанию, необходимо указать параметр `class` как массив, содержащий определение класса, настроенное в ключе `widget`:

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
