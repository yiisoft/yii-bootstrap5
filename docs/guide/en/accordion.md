# Accordion

The Accordion widget renders a Bootstrap 5 accordion component within the **Yii framework**.

You can use it to create collapsible content sections where clicking a header toggles the visibility of its associated
body. 

This component is highly customizable, supporting options like always-open behavior, flush styling, custom HTML tags,
and CSS classes.

## Key Features
- Supports multiple collapsible items with headers and bodies.
- Configurable to allow multiple items to remain open simultaneously (`alwaysOpen`).
- Customizable header and toggler tags, attributes, and styles.
- Optional flush styling to remove borders and rounded corners.
- Flexible HTML attribute and CSS class management for container, header, body, and toggler elements.

## Quick Start
To get started, instantiate the `Accordion` widget and add items to it. Here is a basic example:

```php
<?php

declare(strict_types=1);

use Yiisoft\Bootstrap5\Accordion;
use Yiisoft\Bootstrap5\AccordionItem;
?>

<?= Accordion::widget()
    ->items(
        AccordionItem::to('Item #1', 'This is the first item\'s content.'),
        AccordionItem::to('Item #2', 'This is the second item\'s content.'),
        AccordionItem::to('Item #3', 'This is the third item\'s content.'),
    )
?>
```

This generates a simple accordion with three collapsible items, each with a clickable header and a body that
expands/collapses.

## Basic Usage

### Instantiation
Create a new `Accordion` instance using the `widget()` method:

```php
$accordion = Accordion::widget();
```

### Adding Items
Use the `items()` method to define accordion items. Each item is an instance of `AccordionItem`:

```php
$accordion = Accordion::widget()
    ->items(
        AccordionItem::to('Section 1', 'Content for section 1.'),
        AccordionItem::to('Section 2', 'Content for section 2.', active: true),
        AccordionItem::to('Section 3', 'Content for section 3.'),
    );
```

### Rendering
Render the accordion as HTML using `render()` or cast it to a string:

```php
// Using render()
$html = $accordion->render();

// Using __toString()
$html = (string) $accordion;
```

## Configuration

### Setting Attributes
Customize the accordion container with HTML attributes:

```php
$accordion = Accordion::widget()
    ->attributes(['id' => 'my-accordion'])
    ->class('custom-accordion');
```

For the toggler, use `togglerAttributes()`:

```php
$accordion = Accordion::widget()->togglerAttributes(['data-test' => 'toggle']);
```

### Customizing Headers
Set the header tag (defaults to `h2`):

```php
$accordion = Accordion::widget()->headerTag('h3');
```

Add attributes to headers:

```php
$accordion = Accordion::widget()->headerAttributes(['class' => 'text-primary']);
```

### Customizing the Toggler
Change the toggler tag (defaults to `button`):

```php
$accordion = Accordion::widget()->togglerTag('div');
```

Add custom attributes or classes to the toggler:

```php
$accordion = Accordion::widget()
    ->togglerAttributes(['data-action' => 'toggle'])
    ->addClass('bg-light');
```

### Always Open Behavior
Allow multiple items to remain open simultaneously:

```php
$accordion = Accordion::widget()->alwaysOpen();
```

### Flush Styling
Remove borders and rounded corners for a flush appearance:

```php
$accordion = Accordion::widget()->flush();
```

### Body Attributes
Customize the body section of each item:

```php
$accordion = Accordion::widget()->bodyAttributes(['class' => 'p-4']);
```

### Collapse Attributes
Customize the collapse section (the wrapper around the body):

```php
$accordion = Accordion::widget()->collapseAttributes(['data-test' => 'collapse']);
```

## Item Configuration
The `AccordionItem` class allows customization of individual items:

**Basic Item:**

```php
AccordionItem::to('Header', 'Body content')
```

**Active Item (expanded by default):**

```php
AccordionItem::to('Header', 'Body content', active: true)
```

**Custom ID:**

```php
AccordionItem::to('Header', 'Body content', id: 'custom-id')
```

**Raw HTML Content (disable encoding):**

```php
AccordionItem::to('<strong>Header</strong>', '<p>Body content</p>', encodeHeader: false, encodeBody: false)
```

## Available Methods

### `Accordion` Methods
| Method                   | Description                                                                   |
|--------------------------|-------------------------------------------------------------------------------|
| `addAttributes()`        | Adds a sets of attribute.                                                     |
| `addClass()`             | Adds one or more CSS classes to the existing classes.                         |
| `addCssStyle()`          | Adds a CSS style.                                                             |
| `attribute()`            | Adds a sets attribute value.                                                  |
| `attributes()`           | Sets the HTML attributes.                                                     |
| `alwaysOpen()`           | Sets whether it should always allow multiple items to be open simultaneously. |
| `bodyAttributes()`       | Sets the HTML attributes for the body section.                                |
| `class()`                | Replaces all existing CSS classes with the specified one(s).                  |
| `collapseAttributes()`   | Sets the HTML attributes for the collapse section.                            |
| `flush()`                | Sets whether should use the flush style.                                      |
| `headerAttributes()`     | Sets the HTML attributes for the header section.                              |
| `headerTag()`            | Sets the HTML tag to be used for the header section, (for example, 'h3').     |
| `id()`                   | Sets the ID, (auto-generated if `true`).                                      |
| `items()`                | Sets the items. If empty, nothing is rendered.                                |
| `togglerAttributes()`    | Sets the HTML attributes for the toggler.                                     |
| `togglerTag()`           | Sets the HTML tag to be used for the toggler.                                 |
| `render()`               | Run the widget.                                                               |

### `AccordionItem` Methods
| Method                   | Description                                                                   |
|--------------------------|-------------------------------------------------------------------------------|
| `active()`               | Sets the active state.                                                        |
| `body()`                 | Sets the body content.                                                        |
| `encodeBody()`           | Sets whether to encode the body content.                                      |
| `encodeHeader()`         | Sets whether to encode the header content.                                    |
| `header()`               | Sets the header content.                                                      |
| `id()`                   | Sets the ID, (auto-generated if `true`).                                      |

## Additional Resources
- [Bootstrap 5 Accordion Documentation](https://getbootstrap.com/docs/5.3/components/accordion/)
- [GitHub Repository](https://github.com/yiisoft/bootstrap5)
- [Report an Issue](https://github.com/yiisoft/bootstrap5/issues)
