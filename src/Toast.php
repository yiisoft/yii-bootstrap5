<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Small;
use Yiisoft\Html\Tag\Strong;
use Yiisoft\Widget\Widget;

use function is_string;

/**
 * Toasts renders a toast bootstrap widget.
 *
 * For example,
 *
 * ```php
 * echo Toast::widget()
 *     ->body('Hello, world! This is a toast message.')
 *     ->image('https://example.com/150', 'Bootstrap5', ['class' => 'rounded me-2'])
 *     ->time('11 mins ago')
 *     ->title('Bootstrap')
 *     ->render();
 * ```
 *
 * @see https://getbootstrap.com/docs/5.0/components/toasts/
 */
final class Toast extends Widget
{
    private const CLASS_CLOSE_BUTTON = 'btn-close';
    private const NAME = 'toast';
    private const TOAST_BODY = 'toast-body';
    private const TOAST_CONTAINER = 'toast-container position-fixed bottom-0 end-0 p-3';
    private const TOAST_HEADER = 'toast-header';
    private const TOAST_TITLE_HEADER = 'me-auto';
    private array $attributes = [];
    private string $body = '';
    private string|Stringable $closeButton = '';
    private string|Stringable $content = '';
    private array $cssClasses = [];
    private bool $container = false;
    private array $headerAttributes = [];
    private bool|string $id = true;
    private string|Stringable $image = '';
    private string $time = '';
    private string|Stringable $title = '';
    private string|Stringable $triggerButton = '';

    /**
     * Adds a set of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $progress->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $progress->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style.
     *
     * @param array|string $style The CSS style. If the value is an array, the values will be separated by a space.
     * e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
     * If a string, it will be added as is. For example, `color: red`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $progress->addCssStyle('color: red');
     *
     * // or
     * $progress->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute set.
     *
     * Example usage:
     * ```php
     * $progress->attribute('data-id', '123');
     * ```
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $progress->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the body content.
     *
     * @param string|Stringable $content The body content. If a string, it will be wrapped in a `<div>` tag.
     * @param array $attributes Additional HTML attributes for the `<div>` tag. Used only when $content is a string.
     * @param BackedEnum|string|null ...$class CSS class names to add to the `<div>` tag. Pass `null` to skip adding a
     * class.
     *
     * @return self A new instance with the specified the body content.
     *
     * Example usage:
     * ```php
     * // Basic usage
     * $toast->body('Hello, world! This is a toast message.');
     *
     * // With additional attributes
     * $toast->body('Custom toast message', ['data-id' => '123']);
     *
     * // With additional classes
     * $toast->body('Custom toast message', [], 'text-primary', 'p-4');
     *
     * // Using a Stringable object (pre-rendered HTML)
     * $toast->body($customBodyHtml);
     * ```
     *
     * @see https://getbootstrap.com/docs/5.3/components/toasts/#basic
     */
    public function body(string|Stringable $content, $attributes = [], BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->body = is_string($content)
            ? Div::tag()
                ->addAttributes($attributes)
                ->addClass(
                    self::TOAST_BODY,
                    ...$class,
                )
                ->content(
                    "\n",
                    $content,
                    "\n",
                )
                ->render()
            : (string) $content;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $progress->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the close button for the header section.
     *
     * @param string|Stringable $content The close button. If empty, a default close button will be rendered.
     * If provided, this content will be used instead of the default button.
     *
     * @return self A new instance with the specified close button for the header section.
     *
     * Example usage:
     * ```php
     * // Use default close button
     * $toast->closeButton();
     *
     * // Label for the close button
     * $toast->closeButton('Close');
     *
     * // Custom close button content
     * $toast->closeButton('<span class="custom-close">&times;</span>');
     *
     * // Using a Stringable object
     * $toast->closeButton($customButtonHtml);
     * ```
     */
    public function closeButton(string|Stringable $content = ''): self
    {
        $new = clone $this;
        $new->closeButton = $content;

        return $new;
    }

    /**
     * Whether to render in a container `<div>` tag.
     *
     * @param bool $enabled Whether to render in a container `<div>` tag. By default, it will be rendered in a container
     * `<div>` tag. If set to `false`, the container will not be rendered.
     *
     * @return self A new instance with the specified container setting.
     *
     * Example usage:
     * ```php
     * $toast->container(false);
     * ```
     */
    public function container(bool $enabled): self
    {
        $new = clone $this;
        $new->container = $enabled;

        return $new;
    }

    /**
     * Sets custom content.
     *
     * @param string|Stringable ...$content The custom content to display. This will replace all standard content
     * rendering. Multiple parameters will be joined with newlines.
     *
     * @return self A new instance with the specified custom content.
     *
     * Example usage:
     * ```php
     * // Using a string
     * $toast->content('<div class="custom-toast">My custom toast implementation</div>');
     *
     * // Using multiple strings
     * $toast->content(
     *     '<div class="header">',
     *     'Toast Header', '</div>',
     *     '<div class="body">',
     *     'Toast Body',
     *     '</div>',
     * );
     *
     * // Using a Stringable object
     * $toast->content($customToastHtml);
     * ```
     */
    public function content(string|Stringable ...$content): self
    {
        $new = clone $this;
        $new->content = implode("\n", $content);

        return $new;
    }

    /**
     * Sets the HTML attributes for the header section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the header section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $toast->headerAttributes(['class' => 'my-class']);
     * ```
     */
    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     *
     * Example usage:
     * ```php
     * $toast->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the image for the header section.
     *
     * @param string|Stringable $content The image content. If a string, it will be treated as the URL for the image
     * source. If a Stringable object, it will be treated as the HTML content for the image.
     * @param string $alt The alt attribute for the `<img>` tag. Used only when $content is a string.
     * @param array $attributes Additional HTML attributes for the `<img>` tag. Used only when $content is a string.
     *
     * @return self A new instance with the specified image for the header section.
     *
     * Example usage:
     * ```php
     * // Using a URL
     * $toast->image('path/to/image.jpg', 'Bootstrap logo', ['class' => 'rounded me-2']);
     *
     * // Using a Stringable object
     * $toast->image($customImageHtml);
     * ```
     */
    public function image(string|Stringable $content, string $alt = '', array $attributes = []): self
    {
        $new = clone $this;
        $new->image = is_string($content)
            ? Img::tag()->addAttributes($attributes)->alt($alt)->src($content)->render()
            : (string) $content;

        return $new;
    }

    /**
     * Sets the time display for the header section.
     *
     * @param string|Stringable $content The time content. If a string, it will be wrapped in a `<small>` tag.
     * @param array $attributes Additional HTML attributes for the `<small>` tag. Used only when $content is a string.
     * @param BackedEnum|string|null ...$class CSS class names to add to the `<small>` tag. Pass `null` to skip adding a
     * class.
     *
     * @return self A new instance with the specified time display for the header section.
     *
     * Example usage:
     * ```php
     * // Basic usage
     * $toast->time('11 mins ago');
     *
     * // With additional classes
     * $toast->time('11 mins ago', [], 'text-body-secondary');
     *
     * // With attributes
     * $toast->time('11 mins ago', ['data-id' => '123']);
     *
     * // Using a Stringable object
     * $toast->time($customTimeHtml);
     * ```
     */
    public function time(string|Stringable $content, $attributes = [], BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->time = is_string($content)
            ? Small::tag()->addAttributes($attributes)->addClass(...$class)->content($content)->render()
            : (string) $content;

        return $new;
    }

    /**
     * Sets the title for the header section.
     *
     * @param string|Stringable $content The title content. If a string, it will be wrapped in a `<strong>` tag.
     * @param array $attributes Additional HTML attributes for the `<strong>` tag. Used only when $content is a string.
     * @param BackedEnum|string|null ...$class CSS class names to add to the `<strong>` tag. Pass `null` to skip adding
     * a class.
     *
     * @return self A new instance with the specified title for the header section.
     *
     * Example usage:
     * ```php
     * // Basic usage
     * $toast->title('Bootstrap');
     *
     * // With additional classes
     * $toast->title('Bootstrap', [], 'text-primary');
     *
     * // With attributes
     * $toast->title('Bootstrap', ['data-id' => '123']);
     *
     * // Using a Stringable object
     * $toast->title($customTitleHtml);
     * ```
     */
    public function title(string|Stringable $content, $attributes = [], BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->title = is_string($content)
            ? Strong::tag()
                ->addAttributes($attributes)
                ->addClass(
                    self::TOAST_TITLE_HEADER,
                    ...$class,
                )
                ->content($content)
                ->render()
            : (string) $content;

        return $new;
    }

    /**
     * Sets the trigger button for displaying the toast.
     *
     * @param string|Stringable $content The content of the trigger button.
     * @param array $attributes The HTML attributes for the trigger button.
     *
     * @return self A new instance with the specified trigger button for displaying the toast.
     *
     * Example usage:
     * ```php
     * $toast->triggerButton('Show notification');
     * ```
     */
    public function triggerButton(string|Stringable $content = 'Show live toast', array $attributes = []): self
    {
        if (is_string($content)) {
            $classes = $attributes['class'] ?? 'btn btn-primary';

            unset($attributes['class']);

            $content = Button::button($content)->addAttributes($attributes)->addClass($classes)->render();
        }

        $new = clone $this;
        $new->triggerButton = $content !== '' ? $content . "\n" : '';

        return $new->container(true);
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        if ($this->body === '' && $this->content === '') {
            return '';
        }

        return match ($this->container) {
            true => $this->triggerButton . Div::tag()
                ->addClass(self::TOAST_CONTAINER)
                ->content(
                    "\n",
                    $this->renderToast(),
                    "\n",
                )
                ->encode(false)
                ->render(),
            default => $this->renderToast(),
        };
    }

    /**
     * Generates the ID.
     *
     * @return string|null The generated ID.
     *
     * @psalm-return non-empty-string|null The generated ID.
     */
    private function getId(): string|null
    {
        return match ($this->id) {
            true => $this->attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };
    }

    /**
     * Renders the close button for the header section.
     *
     * @param string $content The content.
     *
     * @return string The HTML representation of the element.
     */
    private function renderCloseButton(string $content): string
    {
        return Button::tag()
            ->addClass(self::CLASS_CLOSE_BUTTON)
            ->attribute('data-bs-dismiss', self::NAME)
            ->attribute('aria-label', 'Close')
            ->content($content)
            ->type('button')
            ->render();
    }

    /**
     * Render the header.
     *
     * @return string The HTML representation of the element.
     */
    private function renderHeader(): string
    {
        $content = [];
        $headerAttributes = $this->headerAttributes;
        $headerClasses = $headerAttributes['class'] ?? null;

        unset($headerAttributes['class']);

        if ($this->image !== '') {
            $content[] = $this->image;
        }

        if ($this->title !== '') {
            $content[] = $this->title;
        }

        if ($this->time !== '') {
            $content[] = $this->time;
        }

        if ($content === []) {
            return '';
        }

        return Div::tag()
            ->addAttributes($headerAttributes)
            ->addClass(
                self::TOAST_HEADER,
                $headerClasses,
            )
            ->addContent(
                "\n",
                implode("\n", $content),
                "\n",
            )
            ->addContent(
                is_string($this->closeButton) ? $this->renderCloseButton($this->closeButton) : $this->closeButton,
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the toast.
     *
     * @return string The HTML representation of the element.
     */
    private function renderToast(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        $content = $this->content === ''
            ? "\n" . $this->renderHeader() . "\n" . $this->body . "\n"
            : "\n" . $this->content . "\n";

        $content = preg_replace("/\n{2}/", "\n", $content) ?? '';

        return Div::tag()
            ->addAttributes($attributes)
            ->addClass(
                self::NAME,
                ...$this->cssClasses,
            )
            ->addClass($classes)
            ->attribute('role', 'alert')
            ->attribute('aria-live', 'assertive')
            ->attribute('aria-atomic', 'true')
            ->content($content)
            ->encode(false)
            ->id($this->getId())
            ->render();
    }
}
