<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Span;
use Yiisoft\Widget\Widget;

use function array_filter;
use function count;
use function implode;

/**
 * Carousel renders a carousel bootstrap JavaScript component.
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
final class Carousel extends Widget
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
    private array $cssClasses = [];
    private bool $controls = true;
    private string $captionTagName = 'h5';
    private string $captionPlaceholderTagName = 'p';
    private string $controlNextLabel = 'Next';
    private string $controlPreviousLabel = 'Previous';
    private bool|string $id = true;
    /** @psalm-var CarouselItem[] */
    private array $items = [];
    private bool $showIndicators = false;

    /**
     * Adds a set of attributes for the carousel component.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-carousel']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the carousel component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
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
    public function addClass(string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style for the carousel component.
     *
     * @param array|string $style The CSS style for the carousel component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, `color: red`. If the value is an array, the values
     * will be separated by a space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as
     * `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the carousel component.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets whether and how the carousel should automatically cycle through slides.
     *
     * Bootstrap supports three modes of autoplaying for carousels:
     * - `carousel': Starts cycling when the page loads (recommended).
     * - `true`: Like `carousel`, but waits until the first manual interaction before cycling.
     * - `false` or empty string: Disables autoplaying completely.
     *
     * When autoplaying is enabled, cycling can be paused by hovering over the carousel, focusing on it, or clicking
     * on carousel controls/indicators.
     *
     * Example:
     * ```php
     * // Start cycling immediately
     * $carousel->autoPlaying('carousel')
     *
     * // Start cycling after first manual interaction
     * $carousel->autoPlaying(true)
     *
     * // Disable auto cycling
     * $carousel->autoPlaying(false)
     * ```
     *
     * @return self A new instance with the specified autoplaying value.
     *
     * @see https://getbootstrap.com/docs/5.3/components/carousel/#autoplaying-carousels
     */
    public function autoPlaying(bool|string $mode = 'carousel'): self
    {
        $dataBsRide = match ($mode) {
            '', 'false', false => null,
            'true' => 'true',
            true => 'true',
            default => 'carousel',
        };

        return $this->addAttributes(['data-bs-ride' => $dataBsRide]);
    }

    /**
     * Replaces all existing CSS classes of the carousel component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $carousel->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the tag name for the content caption.
     *
     * @param string $tag The tag name for the content caption.
     *
     * @return self A new instance with the specified tag name for the content caption.
     */
    public function captionTagName(string $tag): self
    {
        $new = clone $this;
        $new->captionTagName = $tag;

        return $new;
    }

    /**
     * Sets the tag name for the content caption placeholder.
     *
     * @param string $tag The tag name for the content caption placeholder.
     *
     * @return self A new instance with the specified tag name for the content caption placeholder.
     */
    public function captionPlaceholderTagName(string $tag): self
    {
        $new = clone $this;
        $new->captionPlaceholderTagName = $tag;

        return $new;
    }

    /**
     * Sets the label for the next control button.
     *
     * @param string $label The label for the next control button.
     *
     * @return self A new instance with the specified label for the next control button.
     */
    public function controlNextLabel(string $label): self
    {
        $new = clone $this;
        $new->controlNextLabel = $label;

        return $new;
    }

    /**
     * Sets the label for the previous control button.
     *
     * @param string $label The label for the previous control button.
     *
     * @return self A new instance with the specified label for the previous control button.
     */
    public function controlPreviousLabel(string $label): self
    {
        $new = clone $this;
        $new->controlPreviousLabel = $label;

        return $new;
    }

    /**
     * Whether to show the carousel controls or not.
     *
     * @param bool $enabled Whether to show the carousel controls or not. Default is `true`.
     *
     * @return self A new instance with the specified value.
     */
    public function controls(bool $enabled = true): self
    {
        $new = clone $this;
        $new->controls = !$enabled;

        return $new;
    }

    /**
     * Set the carousel to crossfade slides instead of sliding.
     *
     * @param bool $enabled Whether to crossfade slides or not. Default is `true`.
     *
     * @return self A new instance with the specified crossfade value.
     */
    public function crossfade(bool $enabled = true): self
    {
        $new = clone $this;
        $new->cssClasses['crossfade'] = $enabled ? 'carousel-fade' : null;

        return $new;
    }

    /**
     * Toggles the touch swipe functionality of the carousel.
     *
     * @param bool $enabled Whether to enable the touch swipe functionality or not. Default is `true`.
     *
     * @return self A new instance with the touch swipe functionality disabled.
     */
    public function touchSwiping(bool $enabled = true): self
    {
        return $this->addAttributes(['data-bs-touch' => $enabled ? null : 'false']);
    }

    /**
     * Sets the ID of the carousel component.
     *
     * @param bool|string $id The ID of the alert component. If `true`, an ID will be generated automatically.
     *
     *@throws InvalidArgumentException if the ID is an empty string or `false`.
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the items of the carousel component.
     *
     * @param CarouselItem ...$items Items of the carousel component.
     *
     * @return self A new instance with the specified items.
     */
    public function items(CarouselItem ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Whether to show indicators or not.
     *
     * @param bool $enabled Whether to show indicators or not. Default is `true`.
     *
     * @return self A new instance with the specified value.
     */
    public function showIndicators(bool $enabled = true): self
    {
        $new = clone $this;
        $new->showIndicators = $enabled;

        return $new;
    }

    /**
     * Sets the theme for the carousel component.
     *
     * @param string $theme The theme for the carousel component.
     *
     * @return self A new instance with the specified theme.
     */
    public function theme(string $theme): self
    {
        return $this->addAttributes(['data-bs-theme' => $theme === '' ? null : $theme]);
    }

    /**
     * Run the carousel widget.
     *
     * @throws InvalidArgumentException if the "id" property is an empty string or `false`.
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

        Html::addCssClass($attributes, [self::NAME, self::CLASS_SLIDE, $classes, ...$this->cssClasses]);

        return Div::tag()
            ->attributes($attributes)
            ->addContent(
                "\n",
                $this->renderItems($id),
                "\n",
                $this->controls ? $this->renderControlPrevious($id) . "\n" : '',
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
    private function renderControlPrevious(string $id): string
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
                Span::tag()->addClass('visually-hidden')->addContent($this->controlPreviousLabel)->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the carousel indicators.
     *
     * @param int $key The key of the carousel item.
     * @param CarouselItem $carouselItem The carousel item to render.
     * @param string $id The ID of the carousel component.
     * @param bool $active Whether the carousel item is active or not.
     *
     * @return string The HTML representation of the element.
     */
    private function renderIndicator(int $key, CarouselItem $carouselItem, string $id, bool $active): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide-to' => (string) $key,
                    'aria-current' => $carouselItem->isActive() || $active ? 'true' : null,
                    'aria-label' => 'Slide ' . ($key + 1),
                ],
            )
            ->addClass($carouselItem->isActive() || $active ? 'active' : null)
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

        $activeItems = array_filter($this->items, static fn (CarouselItem $item): bool => $item->isActive());

        if (count($activeItems) > 1) {
            throw new InvalidArgumentException('Only one carousel item can be active at a time.');
        }

        foreach ($this->items as $key => $item) {
            $active = $activeItems === [] && $key === 0;

            if ($this->showIndicators) {
                $indicators[] = $this->renderIndicator($key, $item, $id, $active);
            }

            $items[] = $this->renderItem($item, $active);
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
     * @param bool $active Whether the carousel item is active or not.
     *
     * @return string The HTML representation of the element.
     */
    private function renderItem(CarouselItem $carouselItem, bool $active): string
    {
        $content = $carouselItem->getContent();

        if ($content instanceof Img) {
            $content = $content->addClass(self::CLASS_IMAGE);
        }

        $caption = $carouselItem->getCaption();

        if ($caption !== null && $caption !== '') {
            if ($this->captionTagName === '' || $this->captionPlaceholderTagName === '') {
                throw new InvalidArgumentException(
                    'The "captionTagName" and "captionPlaceholderTagName" properties cannot be empty.'
                );
            }

            $captionContainerTag = Div::tag()
                ->addClass(self::CLASS_CAROUSEL_CAPTION)
                ->addContent(
                    "\n",
                    html::tag($this->captionTagName)
                        ->addAttributes($carouselItem->getCaptionAttributes())
                        ->addContent($caption),
                    "\n",
                    html::tag($this->captionPlaceholderTagName)
                        ->addAttributes($carouselItem->getCaptionPlaceholderAttributes())
                        ->addContent($carouselItem->getcaptionPlaceholder() ?? ''),
                    "\n"
                ) . "\n";
        }

        return Div::tag()
            ->addClass(
                self::CLASS_CAROUSEL_ITEM,
                $carouselItem->isActive() || $active ? 'active' : null
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
