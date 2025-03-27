<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

use function array_key_exists;
use function preg_replace;
use function strtr;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()->body('Say hello...')->variant(AlertVariant::PRIMARY)->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
final class Alert extends Widget
{
    private const CLASS_CLOSE_BUTTON = 'btn-close';
    private const NAME = 'alert';
    private array $attributes = [];
    private AlertVariant $alertType = AlertVariant::SECONDARY;
    private string|Stringable $body = '';
    private array $cssClasses = [];
    private array $closeButtonAttributes = [];
    private string|null $closeButtonTag = null;
    private string $closeButtonLabel = '';
    private bool $dismissable = false;
    private bool $fade = false;
    private string|null $header = null;
    private array $headerAttributes = [];
    private string $headerTag = 'h4';
    private bool|string $id = true;
    private string $templateContent = "\n{header}\n{body}\n{toggler}\n";

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $alert->addAttributes(['data-id' => '123']);
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
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $alert->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * @param array|string $style The CSS style. If an array, the values will be separated by a space. If a string, it
     * will be added as is. For example, `color: red`. If the value is an array, the values will be separated by a
     * space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $alert->addCssStyle('color: red');
     *
     * // or
     * $alert->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Adds a sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute added.
     *
     * Example usage:
     * ```php
     * $alert->attribute('data-id', '123');
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
     * $alert->attributes(['data-id' => '123']);
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
     * @param string|Stringable $content The body content.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance with the specified body content.
     *
     * Example usage:
     * ```php
     * $alert->body('Say hello...');
     * ```
     */
    public function body(string|Stringable $content, bool $encode = true): self
    {
        if ($encode) {
            $content = Html::encode($content);
        }

        $new = clone $this;
        $new->body = $content;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $alert->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the HTML attributes for the close button.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified HTML attributes for the close button.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $alert->closeButtonAttributes(['class' => 'my-class']);
     * ```
     */
    public function closeButtonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->closeButtonAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the label for the close button.
     *
     * @param string $label The label for the close button.
     *
     * @return self A new instance with the specified close button label.
     *
     * Example usage:
     * ```php
     * $alert->closeButtonLabel('Close');
     * ```
     */
    public function closeButtonLabel(string $label): self
    {
        $new = clone $this;
        $new->closeButtonLabel = $label;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the close button.
     *
     * @param string $tag The HTML tag name for the close button.
     *
     * @return self A new instance with the specified close button tag.
     *
     * Example usage:
     * ```php
     * $alert->closeButtonTag('button');
     * ```
     */
    public function closeButtonTag(string $tag): self
    {
        $new = clone $this;
        $new->closeButtonTag = $tag;

        return $new;
    }

    /**
     * Makes the alert dismissible by adding a close button.
     *
     * @param bool $enabled Whether to make the alert dismissible.
     *
     * @return self A new instance with the specified dismissable value.
     *
     * Example usage:
     * ```php
     * $alert->dismissable(true);
     * ```
     */
    public function dismissable(bool $enabled): self
    {
        $new = clone $this;
        $new->dismissable = $enabled;

        return $new;
    }

    /**
     * Adds a fade effect.
     *
     * @param bool $enabled Whether to add a fade effect.
     *
     * @return self A new instance with the specified fade value.
     *
     * Example usage:
     * ```php
     * $alert->fade(true);
     * ```
     */
    public function fade(bool $enabled): self
    {
        $new = clone $this;
        $new->fade = $enabled;

        return $new;
    }

    /**
     * Sets the header content.
     *
     * @param string|null $content The header content.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance with the specified header content.
     *
     * Example usage:
     * ```php
     * $alert->header('Header content');
     * ```
     */
    public function header(string|null $content, bool $encode = true): self
    {
        if ($encode) {
            $content = Html::encode($content);
        }

        $new = clone $this;
        $new->header = $content;

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
     * $alert->headerAttributes(['class' => 'my-class']);
     * ```
     */
    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the header section.
     *
     * @param string $tag The HTML tag name for the header section.
     *
     * @return self A new instance with the specified header tag.
     *
     * Example usage:
     * ```php
     * $alert->headerTag('h4');
     * ```
     */
    public function headerTag(string $tag): self
    {
        $new = clone $this;
        $new->headerTag = $tag;

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
     * $alert->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the template content to be used for rendering.
     *
     * @param string $content The template content string.
     *
     * @return self A new instance with the specified template content.
     *
     * Example usage:
     * ```php
     * $alert->templateContent("\n{header}\n{body}\n{toggler}\n");
     * ```
     */
    public function templateContent(string $content): self
    {
        $new = clone $this;
        $new->templateContent = $content;

        return $new;
    }

    /**
     * Set the alert variant.
     *
     * @param AlertVariant $variant The alert variant.
     *
     * @return self A new instance with the specified alert variant.
     *
     * Example usage:
     * ```php
     * $alert->variant(AlertVariant::PRIMARY);
     * ```
     */
    public function variant(AlertVariant $variant): self
    {
        $new = clone $this;
        $new->alertType = $variant;

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = self::NAME;
        $toggler = '';
        $classes = $attributes['class'] ?? null;

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $this->alertType->value, $classes, ...$this->cssClasses]);

        if ($this->dismissable) {
            Html::addCssClass($attributes, 'alert-dismissible');
            $toggler = $this->renderToggler();
        }

        if ($this->fade) {
            Html::addCssClass($attributes, 'fade show');
        }

        $content = strtr(
            $this->templateContent,
            [
                '{header}' => $this->renderHeader(),
                '{body}' => $this->body,
                '{toggler}' => $toggler,
            ]
        );

        $content = preg_replace("/\n{2}/", "\n", $content) ?? '';

        return Div::tag()->addAttributes($attributes)->content($content)->encode(false)->id($this->getId())->render();
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
     * Render the header.
     *
     * @throws InvalidArgumentException If the header tag is an empty string.
     *
     * @return string The HTML representation of the element.
     */
    private function renderHeader(): string
    {
        if ($this->header === null) {
            return '';
        }

        $headerAttributes = $this->headerAttributes;

        Html::addCssClass($headerAttributes, 'alert-heading');

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('Header tag cannot be empty string.');
        }

        return Html::tag($this->headerTag, '', $headerAttributes)->content($this->header)->encode(false)->render();
    }

    /**
     * Renders the toggler.
     *
     * @throws InvalidArgumentException If the close button tag is an empty string.
     *
     * @return string The HTML representation of the element.
     */
    private function renderToggler(): string
    {
        $buttonTag = match ($this->closeButtonTag) {
            null => Button::button(''),
            '' => throw new InvalidArgumentException('Close button tag cannot be empty string.'),
            default => Html::tag($this->closeButtonTag),
        };

        $closeButtonAttributes = $this->closeButtonAttributes;
        $classesButton = $closeButtonAttributes['class'] ?? null;

        unset($closeButtonAttributes['class']);

        $buttonTag = $buttonTag
            ->addClass(self::CLASS_CLOSE_BUTTON, $classesButton)
            ->addAttributes($closeButtonAttributes)
            ->addContent($this->closeButtonLabel);

        if (array_key_exists('data-bs-dismiss', $closeButtonAttributes) === false) {
            $buttonTag = $buttonTag->attribute('data-bs-dismiss', 'alert');
        }

        if (array_key_exists('aria-label', $closeButtonAttributes) === false) {
            $buttonTag = $buttonTag->attribute('aria-label', 'Close');
        }

        return $buttonTag->render();
    }
}
