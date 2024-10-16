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
    private array $attributes = [];
    private ButtonType $buttonType = ButtonType::SECONDARY;
    private string|null $cssClass = null;
    private bool|string $id = true;
    private string $label = 'Button';
    private string $tagName = 'button';

    /**
     * Sets the button to be active.
     *
     * @return self A new instance of the current class with the button active.
     */
    public function active(): self
    {
        $new = clone $this;
        $new->attributes['aria-pressed'] = 'true';
        $new->attributes['data-bs-toggle'] = 'button';
        $new->cssClass = 'active';

        return $new;
    }

    /**
     * Sets the CSS class attribute for the button component.
     *
     * @param string $value The CSS class for the button component (e.g., 'test-class').
     *
     * @return self A new instance of the current class with the specified class value.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string $value): self
    {
        $new = clone $this;
        $new->cssClass = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the button component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance of the current class with the specified attributes.
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
     * @return self A new instance of the current class with the specified 'data-bs-toggle' value.
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
     * @return self A new instance of the current class with the button disabled.
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;

        return $new;
    }

    /**
     * Sets the ID of the button component.
     *
     * @param bool|string $value The ID of the button component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance of the current class with the specified ID.
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
     * @param bool $encode Whether to encode the label.
     *
     * @return self A new instance of the current class with the specified label value.
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
     * @return self A new instance of the current class with the button as a large button.
     */
    public function large(): self
    {
        $new = clone $this;
        $new->cssClass = 'btn-lg';

        return $new;
    }

    /**
     * Whether the button should be a link.
     *
     * @return self A new instance of the current class with the button as a link.
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
     * @return self A new instance of the current class with the button as a reset button.
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
     * @return self A new instance of the current class with the button as a small button.
     */
    public function small(): self
    {
        $new = clone $this;
        $new->cssClass = 'btn-sm';

        return $new;
    }

    /**
     * Whether the button should be a submit button.
     *
     * @return self A new instance of the current class with the button as a submit button.
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
     * @return self A new instance of the current class with the specified tag name.
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }

    /**
     * Set the button type. The following options are allowed:
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
     * @return self A new instance of the current class with the specified button type.
     */
    public function type(ButtonType $value): self
    {
        $new = clone $this;
        $new->buttonType = $value;

        return $new;
    }

    public function render(): string
    {
        $attributes = $this->attributes;
        $id = is_string($this->id) && $this->id !== '' ? $this->id : null;
        $classes = $attributes['class'] ?? null;
        unset($attributes['class']);

        if ($this->id === true) {
            $id = Html::generateId(self::NAME . '-');
        }

        switch ($this->tagName) {
            case 'button':
                $attributes['type'] ??= 'button';
                break;
            case 'input':
                $attributes['type'] ??= 'button';
                $attributes['value'] = $this->label;
                break;
            case 'a':
                $attributes['role'] = 'button';

                if (isset($attributes['disabled'])) {
                    $attributes['aria-disabled'] = 'true';
                    $attributes['disabled'] = null;
                    $classes .= 'disabled';
                }

                break;
            default:
                throw new InvalidArgumentException('Invalid tag name, use "button", "input", or "a".');
        }

        Html::addCssClass($attributes, [self::NAME, $this->buttonType->value, $classes, $this->cssClass]);

        return Html::tag($this->tagName, $this->label, $attributes)->encode(false)->id($id)->render();
    }
}
