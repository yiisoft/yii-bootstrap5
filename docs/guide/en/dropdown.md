# Dropdown

The **Dropdown** widget renders a Bootstrap 5 dropdown menu component within the **Yiisoft Bootstrap 5** framework.

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
use Yiisoft\Bootstrap5\Dropdown;
use Yiisoft\Bootstrap5\DropdownItem;

echo Dropdown::widget()
    ->togglerContent('Toggle Dropdown')
    ->items(
        DropdownItem::link('Action', '#'),
        DropdownItem::link('Another action', '#'),
        DropdownItem::divider(),
        DropdownItem::link('Separated link', '#')
    )
    ->render();
```

This generates a simple dropdown menu with a toggle button and three clickable items separated by a divider.

## Installation
The **Dropdown** widget is part of the **yiisoft/bootstrap5** package. Install it via Composer:

```bash
composer require yiisoft/bootstrap5
```

Ensure you have PHP 8.1 or higher, as the package leverages modern PHP features.

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

$dropdown = Dropdown::widget()
    ->togglerContent('Menu')
    ->togglerVariant(ButtonVariant::PRIMARY)
    ->togglerSizeLarge();
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

| Method             | Description                                                |
|--------------------|------------------------------------------------------------|
| `addAttributes()`  | Adds multiple HTML attributes to the container.            |
| `addClass()`       | Adds CSS classes to the container.                         |
| `alignment()`      | Sets menu alignment (e.g., `END`, `SM_START`).             |
| `autoClose()`      | Configures auto-close behavior.                            |
| `class()`          | Replaces existing CSS classes on the container.            |
| `direction()`      | Sets the dropdown direction (e.g., `DROPUP`, `DROPRIGHT`). |
| `items()`          | Defines the menu items.                                    |
| `render()`         | Generates the HTML output.                                 |
| `theme()`          | Applies a Bootstrap theme (e.g., `dark`).                  |
| `togglerContent()` | Sets the toggle button/link content.                       |
| `togglerVariant()` | Sets the toggle button variant.                            |

## Additional Resources
- [Bootstrap 5 Dropdown Documentation](https://getbootstrap.com/docs/5.3/components/dropdowns/)
- [GitHub Repository](https://github.com/yiisoft/bootstrap5)
- [Report an Issue](https://github.com/yiisoft/bootstrap5/issues)

