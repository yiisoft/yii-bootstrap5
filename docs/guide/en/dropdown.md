# Dropdown

The **Dropdown** widget renders a Bootstrap 5 dropdown menu component within the **Yii framework**.

You can use it to create interactive dropdown menus with various item types such as links, buttons, headers, dividers,
or plain text. This component is highly customizable, supporting directions, alignments, themes, and toggle variations.

## Key Features
- Supports multiple item types: links, buttons, headers, dividers, and text.
- Customizable toggle button or link with variants, sizes, and split options.
- Configurable menu alignment and direction using Bootstrap 5 classes.
- Auto close behavior control (for example, close on inside/outside clicks).
- Flexible HTML attribute and CSS class management.

## Quick Start
To get started, instantiate the **Dropdown** widget and add items to it. Here is a basic example:

```php
<?php

declare(strict_types=1);

use Yiisoft\Bootstrap5\Dropdown;
use Yiisoft\Bootstrap5\DropdownItem;
?>

<?= Dropdown::widget()
    ->togglerContent('Toggle Dropdown')
    ->items(
        DropdownItem::link('Action', '#'),
        DropdownItem::link('Another action', '#'),
        DropdownItem::divider(),
        DropdownItem::link('Separated link', '#'),
    )
?>
```

This generates a simple dropdown menu with a toggle button and three clickable items separated by a divider.

## Basic Usage

### Instantiation
Create a new **Dropdown** instance using the `widget()` method:

```php
$dropdown = Dropdown::widget();
```

### Adding Items
Use the `items()` method to define menu items. Each item is an instance of **DropdownItem**:

```php
$dropdown = Dropdown::widget()
    ->items(
        DropdownItem::link('Home', '/home'),
        DropdownItem::header('Options'),
        DropdownItem::link('Profile', '/profile'),
        DropdownItem::divider(),
        DropdownItem::text('Logged in as Admin')
    );
```

### Rendering
Render the dropdown as HTML using `render()` or cast it to a string:

```php
// Using render()
$html = $dropdown->render();

// Using __toString()
$html = (string) $dropdown;
```

## Configuration

### Setting Attributes
Customize the dropdown container with HTML attributes:

```php
$dropdown = Dropdown::widget()
    ->attributes(['id' => 'my-dropdown'])
    ->class('custom-dropdown');
```

For the toggle button, use `togglerAttributes()` and `togglerClass()`:

```php
$dropdown = Dropdown::widget()
    ->togglerAttributes(['data-test' => 'toggle'])
    ->togglerClass('btn-lg');
```

### Customizing the Toggle Button
Change the toggle content, variant, or size:

```php
use Yiisoft\Bootstrap5\ButtonVariant;
use Yiisoft\Bootstrap5\ButtonSize;

$dropdown = Dropdown::widget()
    ->togglerContent('Menu')
    ->togglerVariant(ButtonVariant::PRIMARY)
    ->togglerSize(ButtonSize::SMALL());
```

To use a link instead of a button:

```php
$dropdown = Dropdown::widget()
    ->togglerAsLink()
    ->togglerUrl('/menu');
```

For a split button:

```php
$dropdown = Dropdown::widget()
    ->togglerSplit()
    ->togglerSplitContent('Action')
    ->togglerContent('Options');
```

### Direction and Alignment
Set the dropdown direction with `direction()`:

```php
use Yiisoft\Bootstrap5\DropdownDirection;

$dropdown = Dropdown::widget()->direction(DropdownDirection::DROPUP);
```

Align the menu with `alignment()`:

```php
use Yiisoft\Bootstrap5\DropdownAlignment;

$dropdown = Dropdown::widget()->alignment(DropdownAlignment::END);
```

### Auto close Behavior
Control when the dropdown closes using `autoClose()`:

```php
use Yiisoft\Bootstrap5\DropdownAutoClose;

$dropdown = Dropdown::widget()->autoClose(DropdownAutoClose::OUTSIDE);
```

### Themes
Apply a Bootstrap theme (for example, dark mode):

```php
$dropdown = Dropdown::widget()->theme('dark');
```

## Item Types
The **DropdownItem** class supports various item types:

- **Link Item**:
  ```php
  DropdownItem::link('Settings', '/settings', active: true)
  ```
- **Button Item**:
  ```php
  DropdownItem::button('Submit', ['data-action' => 'submit'])
  ```
- **Header Item**:
  ```php
  DropdownItem::header('User Menu', 'h5')
  ```
- **Divider Item**:
  ```php
  DropdownItem::divider()
  ```
- **Text Item**:
  ```php
  DropdownItem::text('Status: Online')
  ```
- **Custom Content Item**:
  ```php
  DropdownItem::listContent('<strong>Custom HTML</strong>')
  ```

## Available Methods

| Method                   | Description                                                                   |
|--------------------------|-------------------------------------------------------------------------------|
| `addAttributes()`        | Adds a sets of attributes.                                                    |
| `addClass()`             | Adds one or more CSS classes to the existing classes.                         |
| `addCssStyle()`          | Adds a CSS style.                                                             |
| `addTogglerAttributes()` | Adds a set of attributes for the toggler button.                              |
| `addTogglerClass()`      | Adds one or more CSS classes to the existing classes.                         |
| `alignment()`            | Sets the alignment. (for example, `DropdownAlignment::END`).                  |
| `attribute()`            | Adds a sets attribute value.                                                  |
| `attributes()`           | Sets the HTML attributes.                                                     |
| `autoClose()`            | Sets the auto-close setting. (for example `DropdownAutoClose::OUTSIDE`).      |
| `class()`                | Replaces all existing CSS classes with the specified one(s).                  |
| `container`              | Whether to render in a container `<div>` tag.                                 |
| `containerClasses()`     | Sets the CSS classes for the container.                                       |
| `direction()`            | Set the direction. (for example, `DropdownDirection::DOWN`).                  |
| `items()`                | List of links. If this property is empty, the widget will not render anything.|
| `theme()`                | Sets the theme. (for example, `dark`).                                        |
| `toggler()`              | Sets the toggler custom element.                                              |
| `togglerAsLink()`        | Whether to render the toggler as a link.                                      |
| `togglerAttributes()`    | Sets the HTML attributes for the toggler.                                     |
| `togglerClass()`         | Replaces all existing CSS classes with the specified one(s).                  |
| `togglerContent()`       | Sets the content of the toggler.                                              |
| `togglerId()`            | Sets the ID for the toggler.                                                  |
| `togglerSize()`          | Sets the large size for the toggler. (for example, `ButtonSize::SMALL`).      |
| `togglerSplit()`         | Whether to render the toggler as a split.                                     |
| `togglerSplitContent()`  | Sets the content of the toggler split.                                        |
| `togglerUrl()`           | Sets the URL for the toggler link.                                            |
| `togglerVariant()`       | Sets the variant for the toggler. (for example, `ButtonVariant::PRIMARY`).    |
| `render()`               | Run the widget.                                                               |

## Additional Resources
- [Bootstrap 5 Dropdown Documentation](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [GitHub Repository](https://github.com/yiisoft/bootstrap5)
- [Report an Issue](https://github.com/yiisoft/bootstrap5/issues)

