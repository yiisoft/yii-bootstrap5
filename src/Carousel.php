<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;

use function implode;

/**
 * Carousel renders a carousel bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/carousel/
 */
final class Carousel extends \Yiisoft\Widget\Widget
{
    private const CLASS_IMAGE = 'd-block w-100';
    private const CLASS_SLIDE = 'slide';
    private const NAME = 'carousel';
    private array $attributes = [];
    private array $cssClass = [];
    private bool|string $id = true;
    private array $items = [];

    /**
     * Set the carousel to crossfade slides instead of sliding.
     *
     * @param bool|null $value Whether to crossfade slides or not.
     *
     * @return self A new instance with the specified crossfade value.
     */
    public function crossfade(bool|null $value): self
    {
        $new = clone $this;
        $new->cssClass['crossfade'] = $value === true ? 'carousel-fade' : null;

        return $new;
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

    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, self::CLASS_SLIDE, $classes, ...$this->cssClass]);

        return Div::tag()
            ->attributes($attributes)
            ->addContent(
                "\n",
                $this->renderItems(),
                "\n",
                $this->renderControlPrev($id),
                "\n",
                $this->renderControlNext($id),
                "\n",
            )
            ->encode(false)
            ->id($id)
            ->render();
    }

    private function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item);
        }

        return Div::tag()
            ->addClass('carousel-inner')
            ->addContent("\n" . implode("\n", $items) . "\n")
            ->encode(false)
            ->render();
    }

    private function renderItem(CarouselItem $carouselItem): string
    {
        $image = $carouselItem->getImage()->addClass(self::CLASS_IMAGE);

        return Div::tag()
            ->addClass(
                'carousel-item',
                $carouselItem->isActive() ? 'active' : null
            )
            ->addContent("\n", $image, "\n")
            ->encode(false)
            ->render();
    }

    private function renderControlPrev(string $id): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide' => 'prev',
                ],
            )
            ->addClass('carousel-control-prev')
            ->addContent(
                "\n",
                Span::tag()->addAttributes(['aria-hidden' => 'true'])->addClass('carousel-control-prev-icon')->render(),
                "\n",
                Span::tag()->addClass('visually-hidden')->addContent('Previous')->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderControlNext(string $id): string
    {
        return Button::button('')
            ->addAttributes(
                [
                    'data-bs-target' => '#' . $id,
                    'data-bs-slide' => 'next',
                ],
            )
            ->addClass('carousel-control-next')
            ->addContent(
                "\n",
                Span::tag()->addAttributes(['aria-hidden' => 'true'])->addClass('carousel-control-next-icon')->render(),
                "\n",
                Span::tag()->addClass('visually-hidden')->addContent('Next')->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }
}
