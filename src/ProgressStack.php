<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

/**
 * The progress stack component allows you to stack multiple progress bars on top of each other.
 *
 * For example,
 *
 * ```php
 * echo ProgressStack::widget()
 *    ->bars(
 *        Progress::widget()
 *            ->ariaLabel('Segment one')
 *            ->id('segment-one')
 *            ->percent(15),
 *        Progress::widget()
 *            ->ariaLabel('Segment two')
 *            ->backGroundColor(BackgroundColor::SUCCESS)
 *            ->id('segment-two')
 *            ->percent(30),
 *        Progress::widget()
 *            ->ariaLabel('Segment three')
 *            ->backGroundColor(BackgroundColor::INFO)
 *            ->id('segment-three')
 *            ->percent(20),
 *    )
 *    ->render();
 *
 * @see https://getbootstrap.com/docs/5.3/components/progress/#multiple-bars
 */
final class ProgressStack extends Widget
{
    private const NAME = 'progress-stack';
    private const PROGRESS_STACKED = 'progress-stacked';
    private array $attributes = [];
    private array $cssClasses = [];
    private array $bars = [];
    private bool|string $id = true;

    /**
     * Adds a set of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $progressStack->addAttributes(['data-id' => '123']);
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
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $progressStack->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * @param array|string $style The CSS style. If a string, it will be added as is. For example, `color: red`. If the
     * value is an array, the values will be separated by a space. e.g., `['color' => 'red', 'font-weight' => 'bold']`
     * will be rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $progressStack->addCssStyle('color: red');
     *
     * // or
     * $progressStack->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute set.
     *
     * Example usage:
     * ```php
     * $progressStack->attribute('data-id', '123');
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
     * $progressStack->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the progress bars to be displayed.
     *
     * @param Progress ...$bars One or more Progress instances to include in the stack.
     *
     * @return self A new instance with the specified bars.
     *
     * Example usage:
     * ```php
     * $progressStack->bars(
     *     Progress::widget()->percent(15)->backgroundColor(BackgroundColor::SUCCESS),
     *     Progress::widget()->percent(30)->backgroundColor(BackgroundColor::INFO)
     * );
     * ```
     */
    public function bars(Progress ...$bars): self
    {
        $new = clone $this;
        $new->bars = $bars;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $progressStack->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

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
     * $progressStack->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        if ($this->bars === []) {
            return '';
        }

        $attributes = $this->attributes;
        $content = '';
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        foreach ($this->bars as $bar) {
            $content .= $bar->stacked()->render() . "\n";
        }

        return Div::tag()
            ->attributes($attributes)
            ->addClass(
                self::PROGRESS_STACKED,
                ...$this->cssClasses,
            )
            ->addClass($classes)
            ->content(
                "\n",
                $content,
            )
            ->encode(false)
            ->id($this->getId())
            ->render();
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
}
