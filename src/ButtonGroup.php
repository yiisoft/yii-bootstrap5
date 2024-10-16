<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\{Html, Tag\Div};

use function implode;
use function is_string;

/**
 * ButtonGroup renders a button group bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo ButtonGroup::widget()
 *     ->addClass('btn-lg')
 *     ->ariaLabel('Basic example')
 *     ->buttons(
 *         Button::widget()->label('Left')->id(false)->type(ButtonType::PRIMARY),
 *         Button::widget()->label('Middle')->id(false)->type(ButtonType::PRIMARY),
 *         Button::widget()->label('Right')->id(false)->type(ButtonType::PRIMARY),
 *     )
 *     ->render();
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 *
 * @link https://getbootstrap.com/docs/5.2/components/button-group/
 */
final class ButtonGroup extends \Yiisoft\Widget\Widget
{
    private const NAME = 'btn-group';
    private array $attributes = [];
    /** psalm-var Button[] $buttons */
    private array $buttons = [];
    private array $cssClass = [];
    private bool|string $id = true;

    /**
     * Adds a CSS class for the button group component.
     *
     * @param string $value The CSS class for the button group component (e.g., 'test-class').
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
     * Sets the ARIA label for the button group component.
     *
     * @param string $value The ARIA label for the button group component.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the button group component.
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
     * List of buttons.
     *
     * @param Button ...$value The button configuration.
     *
     * @return self A new instance with the specified buttons.
     */
    public function buttons(Button ...$value): self
    {
        $new = clone $this;
        $new->buttons = $value;

        return $new;
    }

    /**
     * Sets the ID of the button group component.
     *
     * @param bool|string $value The ID of the button group component. If `true`, an ID will be generated automatically.
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
     * Sets the button group size to be large.
     *
     * @return self A new instance with the button as a large button.
     */
    public function large(): self
    {
        $new = clone $this;
        $new->cssClass['size'] = 'btn-lg';

        return $new;
    }

    /**
     * Sets the button group size to be small.
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
     * Sets the button group to be vertical.
     *
     * @return self A new instance of the current class with the button group as vertical.
     */
    public function vertical(): self
    {
        $new = clone $this;
        $new->cssClass[] = 'btn-group-vertical';

        return $new;
    }

    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = 'group';
        $classes = $attributes['class'] ?? null;
        unset($attributes['class']);

        $id = match ($this->id) {
            true => Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClass]);

        $buttons = implode("\n", $this->buttons);
        $buttons = $buttons === '' ? null : PHP_EOL . $buttons . PHP_EOL;

        return Div::tag()->attributes($attributes)->content($buttons)->encode(false)->id($id)->render();
    }
}
