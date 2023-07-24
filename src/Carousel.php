<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function count;
use function implode;
use function is_string;

/**
 * Carousel renders a carousel bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Carousel::widget()
 *     ->items([
 *         // the item contains only the image
 *         '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-01.jpg"/>',
 *         // equivalent to the above
 *         ['content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-02.jpg"/>'],
 *         // the item contains both the image and the caption
 *         [
 *             'content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-03.jpg"/>',
 *             'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
 *             'captionOptions' => ['class' => ['d-none', 'd-md-block']],
 *             'options' => [...],
 *         ],
 *     ]);
 * ```
 */
final class Carousel extends Widget
{
    private array $controls = [
        '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span>',
        '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span>',
    ];
    private bool $encodeTags = false;
    private bool $showIndicators = true;
    private array $items = [];
    private bool $crossfade = false;
    private array $options = ['data-bs-ride' => 'carousel'];

    public function render(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-carousel";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'carousel', 'slide']);

        if ($this->crossfade) {
            Html::addCssClass($this->options, ['crossfade' => 'carousel-fade']);
        }

        return Html::div(
            $this->renderIndicators() . $this->renderItems() . $this->renderControls(),
            $this->options
        )
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * The labels for the previous and the next control buttons.
     *
     * If null, it means the previous and the next control buttons should not be displayed.
     */
    public function controls(array $value): self
    {
        $new = clone $this;
        $new->controls = $value;

        return $new;
    }

    /**
     * Animate slides with a fade transition instead of a slide. Defaults to `false`.
     */
    public function withCrossfade(): self
    {
        $new = clone $this;
        $new->crossfade = true;

        return $new;
    }

    /**
     * List of slides in the carousel. Each array element represents a single slide with the following structure:
     *
     * ```php
     * [
     *     // required, slide content (HTML), such as an image tag
     *     'content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-01.jpg"/>',
     *     // optional, the caption (HTML) of the slide
     *     'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
     *     // optional the HTML attributes of the slide container
     *     'options' => [],
     * ]
     * ```
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Whether carousel indicators (<ol> tag with anchors to items) should be displayed or not.
     */
    public function withoutShowIndicators(): self
    {
        $new = clone $this;
        $new->showIndicators = false;

        return $new;
    }

    /**
     * Renders carousel indicators.
     */
    private function renderIndicators(): string
    {
        if ($this->showIndicators === false) {
            return '';
        }

        $indicators = [];

        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $options = ['data-bs-target' => '#' . $this->options['id'], 'data-bs-slide-to' => $i];
            if ($i === 0) {
                /** @psalm-suppress InvalidArgument */
                Html::addCssClass($options, ['active' => 'active']);
            }
            $indicators[] = Html::tag('li', '', $options);
        }

        $indicatorOptions = ['class' => ['carousel-indicators']];

        return Html::tag('ol', implode("\n", $indicators), $indicatorOptions)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Renders carousel items as specified on {@see items}.
     */
    private function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $i => $iValue) {
            $items[] = $this->renderItem($iValue, $i);
        }

        $itemOptions = ['class' => 'carousel-inner'];

        return Html::div(implode("\n", $items), $itemOptions)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Renders a single carousel item
     *
     * @param array|string $item a single item from {@see items}
     * @param int $index the item index as the first item should be set to `active`
     *
     * @throws JsonException|RuntimeException if the item is invalid.
     *
     * @return string the rendering result.
     */
    private function renderItem(array|string $item, int $index): string
    {
        if (is_string($item)) {
            $content = $item;
            $caption = null;
            $options = [];
        } elseif (isset($item['content'])) {
            $content = $item['content'];
            $caption = ArrayHelper::getValue($item, 'caption');

            if ($caption !== null) {
                $captionOptions = ArrayHelper::remove($item, 'captionOptions', []);
                Html::addCssClass($captionOptions, ['captionOptions' => 'carousel-caption']);

                $caption = Html::div($caption, $captionOptions)
                    ->encode($this->encodeTags)
                    ->render();
            }

            $options = ArrayHelper::getValue($item, 'options', []);
        } else {
            throw new RuntimeException('The "content" option is required.');
        }

        Html::addCssClass($options, ['widget' => 'carousel-item']);

        if ($index === 0) {
            Html::addCssClass($options, ['active' => 'active']);
        }

        return Html::div($content . "\n" . $caption, $options)
            ->encode($this->encodeTags)
            ->render();
    }

    /**
     * Renders previous and next control buttons.
     *
     * @throws JsonException|RuntimeException if {@see controls} is invalid.
     */
    private function renderControls(): string
    {
        $controlsOptions0 = [
            'class' => 'carousel-control-prev',
            'data-bs-slide' => 'prev',
            'role' => 'button',
        ];

        $controlsOptions1 = [
            'class' => 'carousel-control-next',
            'data-bs-slide' => 'next',
            'role' => 'button',
        ];

        if (isset($this->controls[0], $this->controls[1])) {
            return Html::a($this->controls[0], '#' . $this->options['id'], $controlsOptions0)->encode($this->encodeTags) . "\n" .
                Html::a($this->controls[1], '#' . $this->options['id'], $controlsOptions1)->encode($this->encodeTags);
        }

        if ($this->controls === []) {
            return '';
        }

        throw new RuntimeException(
            'The "controls" property must be either null or an array of two elements.'
        );
    }
}
