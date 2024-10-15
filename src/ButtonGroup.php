<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function implode;

/**
 * ButtonGroup renders a button group bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group with items configuration
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         ['label' => 'A'],
 *         ['label' => 'B'],
 *         ['label' => 'C', 'visible' => false],
 *     ]);
 *
 * // button group with an item as a string
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         Button::widget()->label('A'),
 *         ['label' => 'B'],
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
final class ButtonGroup extends \Yiisoft\Widget\Widget
{
    private const NAME = 'btn-group';
    private array $attributes = [];
    /** psalm-var Button[] $buttons */
    private array $buttons = [];
    private string|null $cssClass = null;
    private bool|string $id = true;

    /**
     * Sets the CSS class attribute for the button group component.
     *
     * @param string $value The CSS class for the button group component (e.g., 'test-class').
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
     * Sets the ARIA label for the button group component.
     *
     * @param string $value The ARIA label for the button group component.
     *
     * @return self A new instance of the current class with the specified ARIA label.
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
     * List of buttons.
     *
     * @param Button ...$value The button configuration.
     *
     * @return self A new instance of the current class with the specified buttons.
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
     * @return self A new instance of the current class with the specified ID.
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
     * @return self A new instance of the current class with the button as a large button.
     */
    public function large(): self
    {
        $new = clone $this;
        $new->cssClass = 'btn-lg';

        return $new;
    }

    /**
     * Sets the button group size to be small.
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
     * Sets the button group to be vertical.
     *
     * @return self A new instance of the current class with the button group as vertical.
     */
    public function vertical(): self
    {
        $new = clone $this;
        $new->cssClass = 'btn-group-vertical';

        return $new;
    }

    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = 'group';
        $id = is_string($this->id) && $this->id !== '' ? $this->id : null;
        $classes = $attributes['class'] ?? null;
        unset($attributes['class']);

        Html::addCssClass($attributes, [self::NAME, $classes, $this->cssClass]);

        if ($this->id === true) {
            $id = Html::generateId(self::NAME . '-');
        }

        $buttons = implode(PHP_EOL, $this->buttons);
        $buttons = $buttons === '' ? null : PHP_EOL . $buttons . PHP_EOL;

        return Div::tag()->attributes($attributes)->content($buttons)->encode(false)->id($id)->render();
    }
}
