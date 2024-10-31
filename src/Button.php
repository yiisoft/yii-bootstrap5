<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Html\Tag\Input;

use function array_merge;
use function array_filter;

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
final class Button extends \Yiisoft\Widget\Widget
{
    private const NAME = 'btn';
    private array $attributes = [];
    private ButtonVariant|null $buttonVariant = null;
    private array $cssClass = [];
    private bool $disabled = false;
    private bool|string $id = true;
    private string|Stringable $label = '';
    private A|ButtonTag|Input|null $tag = null;

    /**
     * Whether the button should be a link.
     *
     * @param string|Stringable $label The content of the button.
     * @param string|null $url The URL of the link button.
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a link.
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
     * @param string|Stringable $value The content of the button. By default, it's "Reset".
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the input of "reset" type.
     */
    public static function resetInput(
        string|Stringable $value = 'Reset',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::INPUT_RESET);
    }

    /**
     * Get an instance of a submit button input.
     *
     * @param string|Stringable $value The content of the button. By default, it's "Submit".
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance of an input with "submit" type.
     */
    public static function submitInput(
        string|Stringable $value = 'Submit',
        array $constructorArguments = [],
        array $config = [],
        string|null $theme = null
    ): self {
        return self::widget($constructorArguments, $config, $theme)->label($value)->type(ButtonType::INPUT_SUBMIT);
    }

    /**
     * Whether the button should be a reset button.
     *
     * @param string|Stringable $value The content of the button. For default, it is 'Reset'.
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a reset button.
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
     * Whether the button should be a submit button.
     *
     * @param string|Stringable $value The content of the button. For default, it is 'Submit'.
     * @param array $constructorArguments The constructor arguments.
     * @param array $config The configuration.
     * @param string|null $theme The theme.
     *
     * @return self A new instance with the button as a submit button.
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
     * Sets the button to be active.
     *
     * @param bool $value Whether the button should be active.
     *
     * @return self A new instance with the button active.
     */
    public function active(bool $value = true): self
    {
        $activeClass = $value === true ? 'active' : null;
        $ariaPressed = $value === true ? 'true' : null;
        $dataBsToggle = $value === true ? 'button' : null;

        $new = $this->toggle($dataBsToggle);
        $new->attributes['aria-pressed'] = $ariaPressed;
        $new->cssClass['active'] = $activeClass;

        return $new;
    }

    /**
     * Adds a sets of attributes for the button component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-button']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $values);

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the button component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$value One or more CSS class names to add. Pass null to skip adding a class.
     * For example:
     *
     * ```php
     * $button->addClass('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = array_merge(
            $new->cssClass,
            array_filter($value, static fn ($v) => $v !== null)
        );

        return $new;
    }

    /**
     * Adds a style class for the button component.
     *
     * @param array|string $value The style class for the button component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified style class value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

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
        $new->attributes['aria-expanded'] = $value === true ? 'true' : 'false';

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
     * Replaces all existing CSS classes of the button component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$value One or more CSS class names to set. Pass null to skip setting a class.
     * For example:
     *
     * ```php
     * $button->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = array_filter($value, static fn ($v) => $v !== null);

        return $new;
    }

    /**
     * Add `text-nowrap` CSS class to the button component to prevent text from wrapping.
     *
     * @return self A new instance with the text wrapping disabled.
     */
    public function disableTextWrapping(): self
    {
        $new = clone $this;
        $new->cssClass['text-nowrap'] = 'text-nowrap';

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
     * @param string|Stringable $value The label to display on the button.
     * @param bool $encode Whether the label value should be HTML-encoded. Use this when rendering user-generated
     * content to prevent XSS attacks.
     *
     * @return self A new instance with the specified label value.
     */
    public function label(string|Stringable $value, bool $encode = true): self
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
     * @return self A new instance with the button as a large button.
     */
    public function largeSize(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = 'btn-lg';

        return $new;
    }

    /**
     * Sets the button size to be normal.
     *
     * @return self A new instance with the button as a normal button.
     */
    public function normalSize(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = null;

        return $new;
    }

    /**
     * Sets the button size to be small.
     *
     * @return self A new instance with the button as a small button.
     */
    public function smallSize(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = 'btn-sm';

        return $new;
    }

    /**
     * Sets the Bootstrap toggle behavior by the `data-bs-toggle` attribute, enabling interactive functionality such as
     * `button`, `dropdown`, `modal`, and `tooltip`.
     *
     * @param string|null $value The Bootstrap toggle type to be set. Common values include: `button`, `dropdown`,
     * `modal`, `tooltip`, `popover`, `collapse`, or `null` to remove.
     * Defaults to `button`.
     *
     * @return self A new instance with the specified Bootstrap toggle behavior.
     */
    public function toggle(string|null $value = 'button'): self
    {
        $new = clone $this;
        $new->attributes['data-bs-toggle'] = $value;

        return $new;
    }

    /**
     * Sets the button type. The following options are allowed:
     * - `ButtonType::LINK`: A link button.
     * - `ButtonType::RESET`: A reset button.
     * - `ButtonType::SUBMIT`: A submit button.
     */
    public function type(ButtonType $value): self
    {
        $new = clone $this;
        $new->tag = match ($value) {
            ButtonType::LINK => A::tag(),
            ButtonType::INPUT_RESET => Input::resetButton(),
            ButtonType::INPUT_SUBMIT => Input::submitButton(),
            ButtonType::RESET => ButtonTag::tag()->type('reset'),
            ButtonType::SUBMIT => ButtonTag::tag()->type('submit'),
        };

        return $new;
    }

    /**
     * Sets the URL of the link button.
     *
     * @param string|null $value The URL of the link button.
     *
     * @return self A new instance with the specified URL.
     */
    public function url(string|null $value): self
    {
        $new = clone $this;
        $new->attributes['href'] = $value;

        return $new;
    }

    /**
     * Set the button variant. The following options are allowed:
     *
     * - `ButtonVariant::PRIMARY`: Primary button.
     * - `ButtonVariant::SECONDARY`: Secondary button.
     * - `ButtonVariant::SUCCESS`: Success button.
     * - `ButtonVariant::DANGER`: Danger button.
     * - `ButtonVariant::WARNING`: Warning button.
     * - `ButtonVariant::INFO`: Info button.
     * - `ButtonVariant::LIGHT`: Light button.
     * - `ButtonVariant::DARK`: Dark button.
     *
     * @param ButtonVariant $value The button variant.
     *
     * @return self A new instance with the specified button variant.
     */
    public function variant(ButtonVariant $value): self
    {
        $new = clone $this;
        $new->buttonVariant = $value;

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
        $tag = $this->tag ?? ButtonTag::tag()->button('');

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $this->buttonVariant?->value, $classes]);

        $attributes = $this->setAttributes($attributes);
        $tag = $tag->addAttributes($attributes)->addClass(...$this->cssClass)->id($id);

        if ($tag instanceof Input) {
            if ($this->label !== '') {
                $tag = $tag->value($this->label);
            }

            return $tag->render();
        }

        return $tag->addContent($this->label)->encode(false)->render();
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
                $attributes['data-bs-toggle'] = 'button';
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
