<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use LogicException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;
use Yiisoft\Yii\Bootstrap5\Utility\Sizing;

/**
 * Progress renders a bootstrap progress bar component.
 *
 * For example,
 *
 * ```php
 * echo Progress::widget()->percent(60)->render();
 *
 * //
 *
 * echo Progress::widget()
 *     ->backgroundColor(BackgroundColor::SUCCESS)
 *     ->percent(60)
 *     ->variant(ProgressVariant::ANIMATED_STRIPED)
 *     ->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/progress/
 */
final class Progress extends Widget
{
    private const NAME = 'progress';
    private const PROGRESS_BAR = 'progress-bar';
    private array $attributes = [];
    private array $barAttributes = [];
    private array $barClasses = [];
    private array $cssClasses = [];
    private string $content = '';
    private bool|string $id = true;
    private int|float $max = 100;
    private int|float $min = 0;
    private int|float $percent = 0;
    private bool $sizing = false;
    private bool $stacked = false;

    /**
     * Adds a set of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $progress->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes for the bar.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add to the bar. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to the bar.
     *
     * Example usage:
     * ```php
     * $progress->addBarClass('bg-success', null, 'progress-bar-striped');
     * ```
     */
    public function addBarClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->barClasses = [...$this->barClasses, ...$class];

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
     * $progress->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $progress->addCssStyle('color: red');
     *
     * // or
     * $progress->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the ARIA label.
     *
     * @param string $label The ARIA label.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     *
     * Example usage:
     * ```php
     * $progress->ariaLabel('breadcrumb');
     * ```
     */
    public function ariaLabel(string $label): self
    {
        return $this->attribute('aria-label', $label);
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
     * $progress->attribute('data-id', '123');
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
     * $progress->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the background color of the bar.
     *
     * @param BackgroundColor $color The background color class to apply to the bar.
     *
     * @return self A new instance with the specified background color applied.
     *
     * @link https://getbootstrap.com/docs/5.3/components/progress/#backgrounds
     *
     * Example usage:
     * ```php
     * $progress->backgroundColor(BackgroundColor::SUCCESS);
     * ```
     */
    public function backgroundColor(BackgroundColor $color): self
    {
        return $this->addBarClass($color);
    }

    /**
     * Sets the HTML attributes for the bar.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the bar.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $progress->barAttributes(['data-id' => '123']);
     * ```
     */
    public function barAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->barAttributes = $attributes;

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
     * $progress->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the content.
     *
     * @param string $content The content to be displayed in the bar.
     *
     * @return self A new instance with the specified content.
     *
     * Example usage:
     * ```php
     * $progress->content('Loading...');
     * ```
     */
    public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;

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
     * $progress->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the maximum value.
     *
     * @param float|int $max The maximum value. This value is used to calculate the progress percentage.
     *
     * @return self A new instance with the specified maximum value.
     *
     * Example usage:
     * ```php
     * $progress->max(200);
     * ```
     */
    public function max(int|float $max): self
    {
        $new = clone $this;
        $new->max = $max;

        return $new;
    }

    /**
     * Sets the minimum value.
     *
     * @param float|int $min The minimum value. This value is used to calculate the progress percentage.
     *
     * @return self A new instance with the specified minimum value.
     *
     * Example usage:
     * ```php
     * $progress->min(50);
     * ```
     */
    public function min(int|float $min): self
    {
        $new = clone $this;
        $new->min = $min;

        return $new;
    }

    /**
     * Sets the percentage value for the bar.
     *
     * @param float|int $percent The percentage value. Must be greater than or equal to 0.
     *
     * @throws LogicException When percentage value is less than 0.
     *
     * @return self A new instance with the specified percentage value.
     *
     * Example usage:
     * ```php
     * $progress->percent(60);
     * ```
     */
    public function percent(int|float $percent): self
    {
        if ($percent < 0) {
            throw new LogicException(
                sprintf('"$percent" must be positive. %d given', $percent)
            );
        }

        $new = clone $this;
        $new->percent = $percent;

        return $new;
    }

    /**
     * Sets the sizing variant.
     *
     * @param Sizing $size The sizing variant to apply. This affects the width class of the bar.
     *
     * @return self A new instance with the specified sizing variant.
     *
     * Example usage:
     * ```php
     * $progress->sizing(Sizing::WIDTH_75);
     * ```
     */
    public function sizing(Sizing $size): self
    {
        $new = clone $this;
        $new->sizing = true;

        return $new->addBarClass($size);
    }

    /**
     * Sets the bar to be stacked.
     *
     * @return self A new instance with the bar stacked.
     *
     * Example usage:
     * ```php
     * $progress->stacked();
     * ```
     */
    public function stacked(): self
    {
        $new = clone $this;
        $new->stacked = true;

        return $new;
    }

    /**
     * Sets the variant.
     *
     * @param ProgressVariant $variant The variant to apply to the progress bar.
     *
     * @return self A new instance with the specified variant.
     *
     * Example usage:
     * ```php
     * $progress->variant(ProgressVariant::ANIMATED_STRIPED);
     * ```
     */
    public function variant(ProgressVariant $variant): self
    {
        return $this->addBarClass($variant);
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

        unset($attributes['class']);

        if ($this->stacked === true) {
            $attributes['style'] = 'width: ' . $this->percent . '%';
        }

        return Div::tag()
            ->attributes($attributes)
            ->addClass(
                self::NAME,
                ...$this->cssClasses,
            )
            ->addClass($classes)
            ->attribute('role', 'progressbar')
            ->attribute('aria-valuenow', $this->percent)
            ->attribute('aria-valuemin', $this->min)
            ->attribute('aria-valuemax', $this->max)
            ->content(
                "\n",
                $this->renderBar(),
                "\n",
            )
            ->id($this->getId())
            ->encode(false)
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

    /**
     * Renders the bar.
     *
     * @return string The HTML representation of the element.
     */
    private function renderBar(): string
    {
        $barAttributes = $this->barAttributes;
        $barClasses = $barAttributes['class'] ?? null;

        unset($barAttributes['class']);

        if ($this->stacked === false && $this->sizing === false) {
            $barAttributes['style'] = 'width: ' . $this->percent . '%';
        }

        $renderBar = Div::tag()
            ->attributes($barAttributes)
            ->addClass(self::PROGRESS_BAR, ...$this->barClasses)
            ->addClass($barClasses)
            ->encode(false);

        if ($this->content !== '') {
            $renderBar = $renderBar->content("\n", $this->content, "\n");
        }

        return $renderBar->render();
    }
}
