<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Html\Tag\Input;

use function array_merge;

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
    private bool $active = false;
    private array $attributes = [];
    private ButtonVariant $buttonVariant = ButtonVariant::SECONDARY;
    private array $cssClass = [];
    private bool $disabled = false;
    private bool|string $id = true;
    private string|Stringable $label = '';
    private A|ButtonTag|Input|null $tag = null;

    /**
     * Whether the button should be a link.
     *
     * @param string|stringable $label The content of the button.
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
     * Whether the button should be a reset button.
     *
     * @param string|stringable $value The content of the button. For default, it is 'Reset'.
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
     * @param string|stringable $value The content of the button. For default, it is 'Submit'.
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
        $new = clone $this;
        $new->active = $value;

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
     * @param string|stringable $value The label to display on the button.
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
            ButtonType::RESET => Input::resetButton(),
            ButtonType::SUBMIT => Input::submitButton(),
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

        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id']);

        Html::addCssClass($attributes, [self::NAME, $this->buttonVariant->value, $classes]);

        $attributes = $this->setAttributes($attributes);

        if ($tag instanceof Input) {
            if ($this->label !== '') {
                $tag = $tag->value($this->label);
            }

            return $tag->addAttributes($attributes)->addClass(...$this->cssClass)->id($id)->render();
        }

        return $tag
            ->addAttributes($attributes)
            ->addClass(...$this->cssClass)
            ->addContent($this->label)
            ->id($id)
            ->encode(false)
            ->render();
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
        if ($this->active) {
            $attributes['aria-pressed'] = 'true';
            $attributes['data-bs-toggle'] = 'button';

            Html::addCssClass($attributes, 'active');
        }

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
