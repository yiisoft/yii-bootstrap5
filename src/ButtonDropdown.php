<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Html\{Html, Tag\Div};

use function array_merge;

/**
 * ButtonDropdown renders a group or split button dropdown bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdown::widget()
 *     ->label('Action')
 *     ->items([
*             ['label' => 'DropdownA', 'url' => '/'],
*             ['label' => 'DropdownB', 'url' => '#'],
 *     ]);
 * ```
 */
final class ButtonDropdown extends \Yiisoft\Widget\Widget
{
    private const NAME = 'dropdown';
    private array $attributes = [];
    private array $buttonAttributes = [];
    private bool|string $buttonId = false;
    private array $cssClass = [];
    private array $dropdownAttributes = [];
    private bool|string $id = true;
    private string $label = 'Dropdown button';
    private array $labelAttributes = [];
    private bool $labelContainer = false;
    private bool $labelEncode = true;
    private string $labelTagName = 'span';
    private array|string|Stringable $items = [];
    private bool $renderContainer = true;

    /**
     * Adds a CSS class for the button dropdown component.
     *
     * @param string $value The CSS class for the button dropdown component (e.g., 'test-class').
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
     * Sets the HTML attributes for the button dropdown component.
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
        $new->attributes = array_merge($new->attributes, $values);

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
    public function buttonAttributes(array $values): self
    {
        $new = clone $this;
        $new->buttonAttributes = array_merge($new->buttonAttributes, $values);

        return $new;
    }

    /**
     * Sets the ID of the button component.
     *
     * @param bool|string $value The ID of the button component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     */
    public function buttonId(bool|string $value): self
    {
        $new = clone $this;
        $new->buttonId = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the dropdown component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function dropdownAttributes(array $values): self
    {
        $new = clone $this;
        $new->dropdownAttributes = array_merge($new->dropdownAttributes, $values);

        return $new;
    }

    /**
     * Sets the ID of the button dropdown component.
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
     * Sets the items for the dropdown component.
     *
     * The configuration array for example:
     *
     * ```php
     *    [
     *        ['label' => 'DropdownA', 'url' => '/'],
     *        ['label' => 'DropdownB', 'url' => '#'],
     *    ]
     * ```
     *
     * {@see Dropdown}
     */
    public function items(array|string|Stringable $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Set the content of the label tag for the button component.
     *
     * @param string $value The label to display on the button.
     *
     * @return self A new instance with the specified label value.
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the label tag of the button component.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelAttributes(array $value): self
    {
        $new = clone $this;
        $new->labelAttributes = $value;

        return $new;
    }

    /**
     * Whether the label content should be rendered inside a container tag.
     *
     * @param bool $value If `true`, the label content will be rendered inside a container tag.
     *
     * @return self A new instance with the specified the label container value.
     */
    public function labelContainer(bool $value): self
    {
        $new = clone $this;
        $new->labelContainer = $value;

        return $new;
    }

    /**
     * Whether the label tag should be encoded.
     *
     * @param bool $value Whether the label tag should be encoded.
     *
     * @return self A new instance with the specified the label encode value.
     */
    public function labelEncode(bool $value): self
    {
        $new = clone $this;
        $new->labelEncode = $value;

        return $new;
    }

    /**
     * Sets the tag name for the label tag of the button component.
     *
     * @param string $value The tag name for the label tag of the button component.
     *
     * @return self A new instance with the specified label tag name.
     */
    public function labelTagName(string $value): self
    {
        $new = clone $this;
        $new->labelTagName = $value;

        return $new;
    }

    public function render(): string
    {
        if (empty($this->items)) {
            return '';
        }

        if ($this->renderContainer) {
            $attributes = $this->attributes;
            $classes = $attributes['class'] ?? null;

            $id = match ($this->id) {
                true => Html::generateId(self::NAME . '-'),
                '', false => $attributes['id'] ?? null,
                default => $this->id,
            };

            unset($attributes['class'], $attributes['id']);

            Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClass]);

            $content = "\n" . $this->renderButton() . "\n" . $this->renderDropdown() . "\n";

            return Div::tag()->attributes($attributes)->content($content)->encode(false)->id($id)->render();
        }

        return $this->renderButton() . "\n" . $this->renderDropdown();
    }

    /**
     * Generates the button dropdown.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    private function renderButton(): string
    {
        $labelEncode = match ($this->labelContainer) {
            true => false,
            default => $this->labelEncode,
        };

        return Button::widget()
            ->ariaExpanded(false)
            ->attributes($this->buttonAttributes)
            ->addClass('dropdown-toggle')
            ->dataBsToggle('dropdown')
            ->label($this->renderLabel(), $labelEncode)
            ->id($this->buttonId)
            ->render();
    }

    /**
     * Renders the label.
     *
     * @return string the rendering result.
     */
    private function renderLabel(): string
    {
        if ($this->labelContainer === false) {
            return $this->label;
        }

        if ($this->labelTagName === '') {
            throw new InvalidConfigException('LabelTagName cannot be empty string.');
        }

        return Html::tag($this->labelTagName, $this->label, $this->labelAttributes)->encode(false)->render();
    }

    /**
     * Generates the dropdown menu.
     *
     * @return string the rendering result.
     */
    private function renderDropdown(): string
    {
        return Dropdown::widget()
            ->items($this->items)
            ->options($this->dropdownAttributes)
            ->withoutEncodeLabels()
            ->render();
    }
}
