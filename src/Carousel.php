<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\H5;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Span;

use function array_filter;
use function array_merge;
use function implode;

/**
 * Carousel renders a carousel bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Carousel::widget()
 *     ->id('carouselExample')
 *     ->items(
 *         new CarouselItem(
 *             Img::tag()->alt('First slide')->src('image-1.jpg'),
 *             active: true,
 *         ),
 *         new CarouselItem(
 *             Img::tag()->alt('Second slide')->src('image-2.jpg'),
 *         ),
 *         new CarouselItem(
 *             Img::tag()->alt('Third slide')->src('image-3.jpg'),
 *         ),
 *     )
 *     ->render(),
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/carousel/
 */
final class Carousel extends \Yiisoft\Widget\Widget
{
    private const CLASS_CAROUSEL_CAPTION = 'carousel-caption d-none d-md-block';
    private const CLASS_CAROUSEL_CONTROL_NEXT = 'carousel-control-next';
    private const CLASS_CAROUSEL_CONTROL_NEXT_ICON = 'carousel-control-next-icon';
    private const CLASS_CAROUSEL_CONTROL_PREV = 'carousel-control-prev';
    private const CLASS_CAROUSEL_CONTROL_PREV_ICON = 'carousel-control-prev-icon';
    private const CLASS_CAROUSEL_INDICATORS = 'carousel-indicators';
    private const CLASS_CAROUSEL_INNER = 'carousel-inner';
    private const CLASS_CAROUSEL_ITEM = 'carousel-item';
    private const CLASS_IMAGE = 'd-block w-100';
    private const CLASS_SLIDE = 'slide';
    private const NAME = 'carousel';
    private array $attributes = [];
    private array $cssClass = [];
    private bool $controls = true;
    private string $controlNextLabel = 'Next';
    private string $controlPrevLabel = 'Previous';
    private bool|string $id = true;
    /** @psalm-var CarouselItem[] */
    private array $items = [];
    private bool $showIndicators = false;

    /**
     * Adds a sets of attributes for the carousel component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-carousel']`.
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
     * Adds one or more CSS classes to the existing classes of the carousel component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$value One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $carousel->addClass('custom-class', null, 'another-class');
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
     * Adds a CSS style for the carousel component.
     *
     * @param array|string $value The CSS style for the carousel component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the carousel component.
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
     * Sets the carousel to automatically cycle through the slides.
     *
     * @param bool|string $value Whether to automatically cycle through the slides or not. Default is `'carousel'`.
     * If `false` or an empty string, the carousel will not automatically cycle.
     *
     * @return self A new instance with the specified auto-playing value.
     */
    public function autoPlaying(bool|string $value = 'carousel'): self
    {
        return $this->addAttributes(['data-bs-ride' => $value === false || $value === '' ? null : $value]);
    }

    /**
     * Replaces all existing CSS classes of the carousel component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $carousel->class('custom-class', null, 'another-class');
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
     * Sets the label for the next control button.
     *
     * @param string $value The label for the next control button.
     *
     * @return self A new instance with the specified label for the next control button.
     */
    public function controlNextLabel(string $value): self
    {
        $new = clone $this;
        $new->controlNextLabel = $value;

        return $new;
    }

    /**
     * Sets the label for the previous control button.
     *
     * @param string $value The label for the previous control button.
     *
     * @return self A new instance with the specified label for the previous control button.
     */
    public function controlPrevLabel(string $value): self
    {
        $new = clone $this;
        $new->controlPrevLabel = $value;

        return $new;
    }

    /**
     * Set the carousel to crossfade slides instead of sliding.
     *
     * @param bool|null $value Whether to crossfade slides or not. Default is `true`.
     *
     * @return self A new instance with the specified crossfade value.
     */
    public function crossfade(bool|null $value = true): self
    {
        $new = clone $this;
        $new->cssClass['crossfade'] = $value === true ? 'carousel-fade' : null;

        return $new;
    }

    /**
     * Disables the touch swipe functionality of the carousel.
     *
     * @return self A new instance with the touch swipe functionality disabled.
     */
    public function disableTouchSwiping(): self
    {
        return $this->addAttributes(['data-bs-touch' => 'false']);
    }

    /**
     * Sets the ID of the carousel component.
     *
     * @param bool|string $value The ID of the alert component. If `true`, an ID will be generated automatically.
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
     * Sets the items of the carousel component.
     *
     * @param CarouselItem ...$value the items of the carousel component.
     *
     * @return self A new instance with the specified items.
     */
    public function items(CarouselItem ...$value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Whether to show indicators or not.
     *
     * @param bool $value Whether to show indicators or not. Default is `true`.
     *
     * @return self A new instance with the specified value.
     */
    public function showIndicators(bool $value = true): self
    {
        $new = clone $this;
        $new->showIndicators = $value;

        return $new;
    }

    /**
     * Whether to show the carousel controls or not.
     *
     * @param bool $value Whether to show the carousel controls or not. Default is `true`.
     *
     * @return self A new instance with the specified value.
     */
    public function withoutControls(bool $value = true): self
    {
        $new = clone $this;
        $new->controls = !$value;

        return $new;
    }

    /**
     * Run the carousel widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        /** @psalm-var non-empty-string $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.'),
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, self::CLASS_SLIDE, $classes, ...$this->cssClass]);

        return Div::tag()
            ->attributes($attributes)
            ->addContent(
                "\n",
                $this->renderItems($id),
                "\n",
                $this->controls ? $this->renderControlPrev($id) . "\n" : '',
                $this->controls ? $this->renderControlNext($id) . "\n" : '',
            )
            ->encode(false)
            ->id($id)
            ->render();
    }

    /**
     * Renders the next control button.
     *
     * @param string $id The ID of the carousel component.
     *
     * @return string The HTML representation of the element.
     */
    private function renderControlNext(string $id): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide' => 'next',
                ],
            )
            ->addClass(self::CLASS_CAROUSEL_CONTROL_NEXT)
            ->addContent(
                "\n",
                Span::tag()
                    ->addAttributes(['aria-hidden' => 'true'])
                    ->addClass(self::CLASS_CAROUSEL_CONTROL_NEXT_ICON)
                    ->render(),
                "\n",
                Span::tag()->addClass('visually-hidden')->addContent($this->controlNextLabel)->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the previous control button.
     *
     * @param string $id The ID of the carousel component.
     *
     * @return string The HTML representation of the element.
     */
    private function renderControlPrev(string $id): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide' => 'prev',
                ],
            )
            ->addClass(self::CLASS_CAROUSEL_CONTROL_PREV)
            ->addContent(
                "\n",
                Span::tag()
                    ->addAttributes(['aria-hidden' => 'true'])
                    ->addClass(self::CLASS_CAROUSEL_CONTROL_PREV_ICON)
                    ->render(),
                "\n",
                Span::tag()->addClass('visually-hidden')->addContent($this->controlPrevLabel)->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the carousel indicators.
     *
     * @param string $id The ID of the carousel component.
     *
     * @return string The HTML representation of the element.
     */
    private function renderIndicator(int $key, CarouselItem $carouselItem, string $id): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide-to' => (string) $key,
                    'aria-current' => $carouselItem->isActive() ? 'true' : null,
                    'aria-label' => 'Slide ' . (string) ($key + 1),
                ],
            )
            ->addClass($carouselItem->isActive() ? 'active' : null)
            ->encode(false)
            ->render();
    }

    /**
     * Renders the carousel items.
     *
     * @param string $id The ID of the carousel component.
     *
     * @return string The HTML representation of the element.
     */
    private function renderItems(string $id): string
    {
        $items = [];
        $indicators = [];
        $renderIndicators = '';

        foreach ($this->items as $key => $item) {
            if ($this->showIndicators) {
                $indicators[] = $this->renderIndicator($key, $item, $id);
            }

            $items[] = $this->renderItem($item);
        }

        if ($this->showIndicators) {
            $renderIndicators = Div::tag()
                ->addClass(self::CLASS_CAROUSEL_INDICATORS)
                ->addContent("\n" . implode("\n", $indicators) . "\n")
                ->encode(false)
                ->render() . "\n";
        }

        return $renderIndicators .
            Div::tag()
                ->addClass(self::CLASS_CAROUSEL_INNER)
                ->addContent("\n" . implode("\n", $items) . "\n")
                ->encode(false)
                ->render();
    }

    /**
     * Renders a carousel item.
     *
     * @param CarouselItem $carouselItem The carousel item to render.
     *
     * @return string The HTML representation of the element.
     */
    private function renderItem(CarouselItem $carouselItem): string
    {
        $content = $carouselItem->getcontent();

        if ($content instanceof Img) {
            $content = $content->addClass(self::CLASS_IMAGE);
        }

        $contentCaption = $carouselItem->getContentCaption();

        if (empty($contentCaption) !== true) {
            $captionContainerTag = Div::tag()
                ->addClass(self::CLASS_CAROUSEL_CAPTION)
                ->addContent(
                    "\n",
                    H5::tag()->addContent($contentCaption),
                    "\n",
                    P::tag()->addContent($carouselItem->getContentCaptionPlaceholder() ?? ''),
                    "\n"
                ) . "\n";
        }

        return Div::tag()
            ->addClass(
                self::CLASS_CAROUSEL_ITEM,
                $carouselItem->isActive() ? 'active' : null
            )
            ->addAttributes(['data-bs-interval' => $carouselItem->getAutoPlayingInterval()])
            ->addContent(
                "\n",
                $content,
                "\n",
                $captionContainerTag ?? '',
            )
            ->encode(false)
            ->render();
    }
}
