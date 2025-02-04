<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Widget\Widget;
use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;

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
    private string $templateContent = "\n{header}\n{body}\n{toggle}\n";

    /**
     * Adds a sets of attributes to the alert component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-alert']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$values];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the alert component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$values One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $alert->addClass('custom-class', null, 'another-class', BackgroundColor::PRIMARY);
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(BackedEnum|string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$values];

        return $new;
    }

    /**
     * Adds a CSS style for the alert component.
     *
     * @param array|string $value The CSS style for the alert component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the alert component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Sets the body content of the alert component.
     *
     * @param string|Stringable $value The body content of the alert component.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance with the specified body content.
     */
    public function body(string|Stringable $value, bool $encode = true): self
    {
        if ($encode) {
            $value = Html::encode($value);
        }

        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the alert component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$values One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $alert->class('custom-class', null, 'another-class', BackgroundColor::PRIMARY);
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = $values;

        return $new;
    }

    /**
     * Sets the HTML attributes for the close button in the alert component.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified close button attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function closeButtonAttributes(array $value): self
    {
        $new = clone $this;
        $new->closeButtonAttributes = $value;

        return $new;
    }

    /**
     * Sets the label for the close button in the alert component.
     *
     * @param string $value The label for the close button.
     *
     * @return self A new instance with the specified close button label.
     */
    public function closeButtonLabel(string $value): self
    {
        $new = clone $this;
        $new->closeButtonLabel = $value;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the close button in the alert component.
     *
     * @param string $value The HTML tag name for the close button.
     *
     * @return self A new instance with the specified close button tag.
     */
    public function closeButtonTag(string $value): self
    {
        $new = clone $this;
        $new->closeButtonTag = $value;

        return $new;
    }

    /**
     * Makes the alert dismissible by adding a close button.
     *
     * @param bool $value Whether to make the alert dismissible.
     *
     * @return self A new instance with the specified dismissable value.
     */
    public function dismissable(bool $value): self
    {
        $new = clone $this;
        $new->dismissable = $value;

        return $new;
    }

    /**
     * Adds a fade effect to the alert.
     *
     * @param bool $value Whether to add a fade effect to the alert.
     *
     * @return self A new instance with the specified fade value.
     */
    public function fade(bool $value): self
    {
        $new = clone $this;
        $new->fade = $value;

        return $new;
    }

    /**
     * Sets the header content of the alert component.
     *
     * @param string|null $value The header content of the alert component.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance with the specified header content.
     */
    public function header(string|null $value, bool $encode = true): self
    {
        if ($encode) {
            $value = Html::encode($value);
        }

        $new = clone $this;
        $new->header = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the header tag in the alert component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified header attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the header.
     *
     * @param string $value The HTML tag name for the header.
     *
     * @return self A new instance with the specified header tag.
     */
    public function headerTag(string $value): self
    {
        $new = clone $this;
        $new->headerTag = $value;

        return $new;
    }

    /**
     * Sets the ID of the alert component.
     *
     * @param bool|string $value The ID of the alert component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Sets the template content to be used for rendering the alert component.
     *
     * @param string $value The template content string.
     *
     * @return self A new instance with the specified template content.
     */
    public function templateContent(string $value): self
    {
        $new = clone $this;
        $new->templateContent = $value;

        return $new;
    }

    /**
     * Set the alert variant.
     *
     * @param AlertVariant $value The alert variant.
     *
     * @return self A new instance with the specified alert variant.
     */
    public function variant(AlertVariant $value): self
    {
        $new = clone $this;
        $new->alertType = $value;

        return $new;
    }

    /**
     * Run the alert widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = self::NAME;
        $content = '';
        $toggle = '';
        $classes = $attributes['class'] ?? null;

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $this->alertType->value, $classes, ...$this->cssClasses]);

        if ($this->dismissable) {
            Html::addCssClass($attributes, 'alert-dismissible');
            $toggle = $this->renderToggle();
        }

        if ($this->fade) {
            Html::addCssClass($attributes, 'fade show');
        }

        $content = strtr(
            $this->templateContent,
            [
                '{header}' => $this->renderHeader(),
                '{body}' => $this->body,
                '{toggle}' => $toggle,
            ]
        );

        $content = preg_replace("/\n{2}/", "\n", $content) ?? '';

        return Div::tag()->addAttributes($attributes)->content($content)->encode(false)->id($id)->render();
    }

    /**
     * Render header tag.
     *
     * @throws InvalidArgumentException if the header tag is an empty string.
     *
     * @return string The rendered header tag. Empty string if header is not set.
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
     * Render toggle component.
     *
     * @throws InvalidArgumentException if the close button tag is an empty string.
     *
     * @return string The rendered toggle component.
     */
    private function renderToggle(): string
    {
        $buttonTag = match ($this->closeButtonTag) {
            null => Button::button(''),
            '' => throw new InvalidArgumentException('Close button tag cannot be empty string.'),
            default => Html::tag($this->closeButtonTag),
        };

        $closeButtonAttributes = $this->closeButtonAttributes;

        $classesButton = $closeButtonAttributes['class'] ?? null;

        unset($closeButtonAttributes['class']);

        if (array_key_exists('data-bs-dismiss', $closeButtonAttributes) === false) {
            $closeButtonAttributes['data-bs-dismiss'] = 'alert';
        }

        if (array_key_exists('aria-label', $closeButtonAttributes) === false) {
            $closeButtonAttributes['aria-label'] = 'Close';
        }

        Html::addCssClass($closeButtonAttributes, [self::CLASS_CLOSE_BUTTON, $classesButton]);

        return $buttonTag->addAttributes($closeButtonAttributes)->addContent($this->closeButtonLabel)->render();
    }
}
