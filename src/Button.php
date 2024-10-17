<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget()->label('Block button')->large()->type(ButtonType::PRIMARY)->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.2/components/buttons/
 */
final class Button extends \Yiisoft\Widget\Widget
{
    private const NAME = 'btn';
    private bool $active = false;
    private array $attributes = [];
    private ButtonType $buttonType = ButtonType::SECONDARY;
    private array $cssClass = [];
    private bool $disabled = false;
    private bool|string $id = true;
    private string $label = 'Button';
    private string $tagName = 'button';

    /**
     * Sets the button to be active.
     *
     * @param bool $value Whether the button should be active.
     *
     * @return self A new instance with the button active.
     */
    public function active(bool $value = true): self
    {
        $new = clone $this;
        $new->active = $value;

        return $new;
    }

    /**
     * Adds a CSS class for the button group component.
     *
     * @param string $value The CSS class for the button component (e.g., 'test-class').
     *
     * @return self A new instance with the specified class value added.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string $value): self
    {
        $new = clone $this;
        $new->cssClass[] = $value;

        return $new;
    }

    /**
     * Sets the 'aria-expanded' attribute for the button, indicating whether the element is currently expanded or
     * collapsed.
     *
     * @param bool $value The value to set for the 'aria-expanded' attribute.
     *
     * @return self A new instance with the specified 'aria-expanded' value.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-expanded
     */
    public function ariaExpanded(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['aria-expanded'] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the button component.
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
     * Sets the 'data-bs-toggle' attribute for the button.
     *
     * @param string $value The value to set for the 'data-bs-toggle' attribute.
     *
     * @return self A new instance with the specified 'data-bs-toggle' value.
     */
    public function dataBsToggle(string $value): self
    {
        $new = clone $this;
        $new->attributes['data-bs-toggle'] = $value;

        return $new;
    }

    /**
     * Sets the button to be disabled.
     *
     * @param bool $value Whether the button should be disabled.
     *
     * @return self A new instance with the button disabled.
     */
    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->disabled = $value;

        return $new;
    }

    /**
     * Sets the ID of the button component.
     *
     * @param bool|string $value The ID of the button component. If `true`, an ID will be generated automatically.
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
     * The button label.
     *
     * @param string $value The label to display on the button.
     * @param bool $encode Whether the label value should be HTML-encoded. Use this when rendering user-generated
     * content to prevent XSS attacks.
     *
     * @return self A new instance with the specified label value.
     */
    public function label(string $value, bool $encode = true): self
    {
        if ($encode) {
            $value = Html::encode($value);
        }

        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * Sets the button size to be large.
     *
     * @return @return self A new instance with the button as a large button.
     */
    public function large(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = 'btn-lg';

        return $new;
    }

    /**
     * Whether the button should be a link.
     *
     * @return self A new instance with the button as a link.
     */
    public function link(): self
    {
        $new = clone $this;
        $new->tagName = 'a';

        return $new;
    }

    /**
     * Whether the button should be a reset button.
     *
     * @return self A new instance with the button as a reset button.
     */
    public function reset(): self
    {
        $new = clone $this;
        $new->tagName = 'input';
        $new->attributes['type'] = 'reset';
        $new->label = 'Reset';

        return $new;
    }

    /**
     * Sets the button size to be small.
     *
     * @return self A new instance with the button as a small button.
     */
    public function small(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = 'btn-sm';

        return $new;
    }

    /**
     * Whether the button should be a submit button.
     *
     * @return self A new instance with the button as a submit button.
     */
    public function submit(): self
    {
        $new = clone $this;
        $new->tagName = 'input';
        $new->attributes['type'] = 'submit';
        $new->label = 'Submit';

        return $new;
    }

    /**
     * The tag to use to render the button.
     *
     * @param string $value The tag to use to render the button.
     *
     * @return self A new instance with the specified tag name.
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }

    /**
     * Set the button type. The following options are allowed:
     *
     * - `Type::PRIMARY`: Primary button.
     * - `Type::SECONDARY`: Secondary button.
     * - `Type::SUCCESS`: Success button.
     * - `Type::DANGER`: Danger button.
     * - `Type::WARNING`: Warning button.
     * - `Type::INFO`: Info button.
     * - `Type::LIGHT`: Light button.
     * - `Type::DARK`: Dark button.
     *
     * @param ButtonType $value The type of the button.
     *
     * @return self A new instance with the specified button type.
     */
    public function type(ButtonType $value): self
    {
        $new = clone $this;
        $new->buttonType = $value;

        return $new;
    }

    /**
     * Run the button widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;
        unset($attributes['class']);

        $id = match ($this->id) {
            true => Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, $this->buttonType->value, $classes, ...$this->cssClass]);

        $attributes = $this->setAttributes($attributes);

        if ($this->tagName === '' || in_array($this->tagName, ['button', 'input', 'a'], true) === false) {
            throw new InvalidArgumentException('Invalid tag name, use "button", "input", or "a".');
        }

        return Html::tag($this->tagName, $this->label, $attributes)->encode(false)->id($id)->render();
    }

    /**
     * Sets the attributes for the button.
     *
     * @param array $attributes The attributes to set.
     *
     * @return array The updated attributes.
     */
    public function setAttributes(array $attributes): array
    {
        $attributes['type'] ??= ($this->tagName === 'button' || $this->tagName === 'input' ? 'button' : null);

        if ($this->active) {
            $attributes['aria-pressed'] = 'true';
            $attributes['data-bs-toggle'] = 'button';

            Html::addCssClass($attributes, 'active');
        }

        if ($this->disabled) {
            $attributes['disabled'] = true;

            if ($this->tagName === 'a') {
                $attributes['aria-disabled'] = 'true';

                unset($attributes['disabled']);
                Html::addCssClass($attributes, 'disabled');
            }
        }

        if ($this->tagName === 'input') {
            $attributes['value'] ??= $this->label;
        }

        if ($this->tagName === 'a') {
            $attributes['role'] ??= 'button';
        }

        return $attributes;
    }
}
