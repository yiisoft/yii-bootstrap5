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
class Carousel extends Widget
{
    private ?array $controls = [
        '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>',
        '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>',
    ];

    private bool $showIndicators = true;
    private array $items = [];
    private bool $crossfade = false;
    private array $options = ['data-ride' => 'carousel'];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-carousel";
        }

        Html::addCssClass($this->options, ['widget' => 'carousel', 'slide']);

        if ($this->crossfade) {
            Html::addCssClass($this->options, 'carousel-fade');
        }

        $this->registerPlugin('carousel', $this->options);

        return implode("\n", [
            Html::beginTag('div', $this->options),
            $this->renderIndicators(),
            $this->renderItems(),
            $this->renderControls(),
            Html::endTag('div'),
        ]) . "\n";
    }

    /**
     * Renders carousel indicators.
     */
    public function renderIndicators(): string
    {
        if ($this->showIndicators === false) {
            return '';
        }

        $indicators = [];

        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $options = ['data-target' => '#' . $this->options['id'], 'data-slide-to' => $i];
            if ($i === 0) {
                Html::addCssClass($options, 'active');
            }
            $indicators[] = Html::tag('li', '', $options);
        }

        return Html::tag('ol', implode("\n", $indicators), ['class' => ['carousel-indicators']]);
    }

    /**
     * Renders carousel items as specified on {@see items}.
     */
    public function renderItems(): string
    {
        $items = [];

        foreach ($this->items as $i => $iValue) {
            $items[] = $this->renderItem($iValue, $i);
        }

        return Html::tag('div', implode("\n", $items), ['class' => 'carousel-inner']);
    }

    /**
     * Renders a single carousel item
     *
     * @param array|string $item a single item from {@see items}
     * @param int $index the item index as the first item should be set to `active`
     *
     * @throws RuntimeException|JsonException if the item is invalid.
     *
     * @return string the rendering result.
     */
    public function renderItem($item, int $index): string
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
                Html::addCssClass($captionOptions, ['widget' => 'carousel-caption']);

                $caption = Html::tag('div', $caption, $captionOptions);
            }

            $options = ArrayHelper::getValue($item, 'options', []);
        } else {
            throw new RuntimeException('The "content" option is required.');
        }

        Html::addCssClass($options, ['widget' => 'carousel-item']);

        if ($index === 0) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('div', $content . "\n" . $caption, $options);
    }

    /**
     * Renders previous and next control buttons.
     *
     * @throws RuntimeException|JsonException if {@see controls} is invalid.
     *
     * @return string
     */
    public function renderControls(): string
    {
        if (isset($this->controls[0], $this->controls[1])) {
            return Html::a($this->controls[0], '#' . $this->options['id'], [
                'class' => 'carousel-control-prev',
                'data-slide' => 'prev',
                'role' => 'button',
            ]) . "\n"
                . Html::a($this->controls[1], '#' . $this->options['id'], [
                    'class' => 'carousel-control-next',
                    'data-slide' => 'next',
                    'role' => 'button',
                ]);
        }

        if ($this->controls === null) {
            return '';
        }

        throw new RuntimeException(
            'The "controls" property must be either null or an array of two elements.'
        );
    }

    /**
     * The labels for the previous and the next control buttons.
     *
     * If null, it means the previous and the next control buttons should not be displayed.
     *
     * @param array|null $value
     *
     * @return $this
     */
    public function controls(?array $value): self
    {
        $this->controls = $value;

        return $this;
    }

    /**
     * Animate slides with a fade transition instead of a slide. Defaults to `false`.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function crossfade(bool $value): self
    {
        $this->crossfade = $value;

        return $this;
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
     *
     * @param array $value
     *
     * @return $this
     */
    public function items(array $value): self
    {
        $this->items = $value;

        return $this;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * Whether carousel indicators (<ol> tag with anchors to items) should be displayed or not.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function showIndicators(bool $value): self
    {
        $this->showIndicators = $value;

        return $this;
    }
}
