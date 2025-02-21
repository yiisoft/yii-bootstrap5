<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Widget\Widget;
use Yiisoft\Yii\Bootstrap5\Utility\TogglerType;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Button::widget()->label('Button')->largeSize()->variant(ButtonVariant::PRIMARY)->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/buttons/
 */
final class Button extends Widget
{
    private const NAME = 'btn';
    private array $attributes = [];
    private ButtonVariant|null $buttonVariant = ButtonVariant::SECONDARY;
    private array $cssClasses = [];
    private bool $disabled = false;
    private bool|string $id = true;
    private string|Stringable $label = '';
    private A|ButtonTag|Input|null $tag = null;

    /**
     * Whether the button should be a link.
     *
     * @param string|Stringable $label The content.
     * @param string|null $url The URL of the link.
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a link.
     *
     * Example usage:
     * ```php
     * echo Button::link('Button', '/path/to/page')->render();
     * ```
     */
    public static function link(
        string|Stringable $label = '',
        string|null $url = null,
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($label)->type(ButtonType::LINK)->url($url);
    }

    /**
     * Get an instance of a reset button input.
     *
     * @param string|Stringable $value The content. By default, it's "Reset".
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the input of "reset" type.
     *
     * Example usage:
     * ```php
     * echo Button::resetInput('Reset')->render();
     * ```
     */
    public static function resetInput(
        string|Stringable $value = 'Reset',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::RESET_INPUT);
    }

    /**
     * Get an instance of a submit button input.
     *
     * @param string|Stringable $value The content. By default, it's "Submit".
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance of an input with "submit" type.
     *
     * Example usage:
     * ```php
     * echo Button::submitInput('Submit')->render();
     * ```
     */
    public static function submitInput(
        string|Stringable $value = 'Submit',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::SUBMIT_INPUT);
    }

    /**
     * Whether the button should be a reset button.
     *
     * @param string|Stringable $value The content. For default, it is 'Reset'.
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a reset button.
     *
     * Example usage:
     * ```php
     * echo Button::reset('Reset')->render();
     * ```
     */
    public static function reset(
        string|Stringable $value = 'Reset',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::RESET);
    }

    /**
     * Whether the button should be a "submit" button.
     *
     * @param string|Stringable $value The content. For default, it is "Submit".
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a "submit" button.
     *
     * Example usage:
     * ```php
     * echo Button::submit('Submit')->render();
     * ```
     */
    public static function submit(
        string|Stringable $value = 'Submit',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::SUBMIT);
    }

    /**
     * Sets the active state.
     *
     * @param bool $enabled Whether the button should be active.
     *
     * @return self A new instance with the button active.
     *
     * Example usage:
     * ```php
     * $button->active();
     * ```
     */
    public function active(bool $enabled = true): self
    {
        $new = $this
            ->toggle($enabled ? TogglerType::BUTTON : null)
            ->attribute('aria-pressed', $enabled ? 'true' : null);
        $new->cssClasses['active'] = $enabled ? 'active' : null;

        return $new;
    }

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $button->addAttributes(['data-id' => '123']);
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
     * $button->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $button->addCssStyle('color: red');
     *
     * // or
     * $button->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the 'aria-expanded' attribute, indicating whether the element is currently expanded or collapsed.
     *
     * @param bool $enabled The value to set for the 'aria-expanded' attribute.
     *
     * @return self A new instance with the specified 'aria-expanded' value.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-expanded
     *
     * Example usage:
     * ```php
     * $button->ariaExpanded();
     * ```
     */
    public function ariaExpanded(bool $enabled = true): self
    {
        $new = clone $this;
        $new->attributes['aria-expanded'] = $enabled ? 'true' : 'false';

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
     * $button->attribute('data-id', '123');
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
     * $button->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

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
     * $button->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Add `text-nowrap` CSS class to prevent text from wrapping.
     *
     * @return self A new instance with the text wrapping disabled.
     *
     * Example usage:
     * ```php
     * $button->disableTextWrapping();
     * ```
     */
    public function disableTextWrapping(): self
    {
        $new = clone $this;
        $new->cssClasses['text-nowrap'] = 'text-nowrap';

        return $new;
    }

    /**
     * Sets the disable state.
     *
     * @param bool $enabled Whether the button should be disabled.
     *
     * @return self A new instance with the button disabled.
     *
     * Example usage:
     * ```php
     * $button->disabled();
     * ```
     */
    public function disabled(bool $enabled = true): self
    {
        $new = clone $this;
        $new->disabled = $enabled;

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
     * $button->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * The label.
     *
     * @param string|Stringable $label The label to display on the button.
     * @param bool $encode Whether the label value should be HTML-encoded. Use this when rendering user-generated
     * content to prevent XSS attacks.
     *
     * @return self A new instance with the specified label value.
     *
     * Example usage:
     * ```php
     * $button->label('Button');
     * ```
     */
    public function label(string|Stringable $label, bool $encode = true): self
    {
        if ($encode) {
            $label = Html::encode($label);
        }

        $new = clone $this;
        $new->label = $label;

        return $new;
    }

    /**
     * Sets the size.
     *
     * @param ButtonSize|null $size The size. If `null`, the size will not be set.
     *
     * @return self A new instance with the specified size.
     *
     * Example usage:
     * ```php
     * $button->size(ButtonSize::LARGE);
     * ```
     */
    public function size(ButtonSize|null $size): self
    {
        $new = clone $this;
        $new->cssClasses['size'] = $size?->value;

        return $new;
    }

    /**
     * Sets the toggle behavior by the `data-bs-toggle` attribute, enabling interactive functionality such as `button`,
     * `dropdown`, `modal`, and `tooltip`.
     *
     * @param TogglerType|null $type The toggle type to be set. If `null`, the toggle behavior will not be set.
     *
     * @return self A new instance with the specified toggle behavior.
     *
     * Example usage:
     * ```php
     * $button->toggle(TogglerType::BUTTON);
     * ```
     */
    public function toggle(TogglerType|null $type = TogglerType::BUTTON): self
    {
        return $this->attribute('data-bs-toggle', $type?->value);
    }

    /**
     * Sets the type.
     *
     * @param ButtonType $type The type.
     *
     * @return self A new instance with the specified type.
     *
     * Example usage:
     * ```php
     * $button->type(ButtonType::LINK);
     * ```
     */
    public function type(ButtonType $type): self
    {
        $new = clone $this;
        $new->tag = match ($type) {
            ButtonType::LINK => A::tag(),
            ButtonType::RESET => ButtonTag::reset(''),
            ButtonType::RESET_INPUT => Input::resetButton(),
            ButtonType::SUBMIT => ButtonTag::submit(''),
            ButtonType::SUBMIT_INPUT => Input::submitButton(),
        };

        return $new;
    }

    /**
     * Sets the URL of the link.
     *
     * @param string|null $url The URL of the link.
     *
     * @return self A new instance with the specified URL.
     *
     * Example usage:
     * ```php
     * $button->url('/path/to/page');
     * ```
     */
    public function url(string|null $url): self
    {
        return $this->attribute('href', $url);
    }

    /**
     * Set the variant.
     *
     * @param ButtonVariant|null $variant The variant. If `null`, the variant will not be set.
     *
     * @return self A new instance with the specified variant.
     *
     * Example usage:
     * ```php
     * $button->variant(ButtonVariant::PRIMARY);
     * ```
     */
    public function variant(ButtonVariant|null $variant): self
    {
        $new = clone $this;
        $new->buttonVariant = $variant;

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
        $classes = $attributes['class'] ?? null;
        $tag = $this->tag ?? ButtonTag::tag()->button('');

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $this->buttonVariant?->value, $classes]);

        $attributes = $this->setAttributes($attributes);
        $tag = $tag->addAttributes($attributes)->addClass(...$this->cssClasses)->id($this->getId());

        if ($tag instanceof Input) {
            if ($this->label !== '') {
                $tag = $tag->value($this->label);
            }

            return $tag->render();
        }

        return $tag->addContent($this->label)->addClass()->encode(false)->render();
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
     * Sets the attributes for the button.
     *
     * @param array $attributes The attributes to set.
     *
     * @return array The updated attributes.
     */
    private function setAttributes(array $attributes): array
    {
        if ($this->disabled) {
            $attributes['disabled'] = true;

            if ($this->tag instanceof A) {
                $attributes['aria-disabled'] = 'true';

                unset($attributes['disabled']);
                Html::addCssClass($attributes, 'disabled');
            }
        }

        if ($this->tag instanceof A) {
            $attributes['role'] ??= 'button';
        }

        return $attributes;
    }
}
