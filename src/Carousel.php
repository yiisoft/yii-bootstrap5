<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Widget\Exception\InvalidConfigException;

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
 *             'captionOptions' => ['class' => ['d-none', 'd-md-block']]
 *             'options' => [...],
 *         ],
 *     ]);
 * ```
 */
class Carousel extends Widget
{
    /**
     * @var array the labels for the previous and the next control buttons.
     *
     * If empty, it means the previous and the next control buttons should not be displayed.
     */
    private array $controls = [
        '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>',
        '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span>'
    ];

    /**
     * @var bool whether carousel indicators (<ol> tag with anchors to items) should be displayed or not.
     */
    private bool $showIndicators = true;

    /**
     * @var array list of slides in the carousel. Each array element represents a single slide with the following
     * structure:
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
    private array $items = [];

    /**
     * @var bool Animate slides with a fade transition instead of a slide. Defaults to `false`
     */
    private bool $crossfade = false;

    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $options = ['data-ride' => 'carousel'];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
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
            Html::endTag('div')
        ]) . "\n";
    }

    /**
     * Renders carousel indicators.
     *
     * @return string the rendering result
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
     *
     * @return string the rendering result
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
     * @param string|array $item a single item from {@see items}
     * @param int $index the item index as the first item should be set to `active`
     *
     * @return string the rendering result
     *
     * @throws InvalidConfigException if the item is invalid
     */
    public function renderItem($item, int $index): string
    {
        if (\is_string($item)) {
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
            throw new InvalidConfigException('The "content" option is required.');
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
     * @throws InvalidConfigException if {@see controls} is invalid.
     */
    public function renderControls(): ?string
    {
        if (isset($this->controls[0], $this->controls[1])) {
            return Html::a($this->controls[0], '#' . $this->options['id'], [
                    'class' => 'carousel-control-prev',
                    'data-slide' => 'prev',
                    'role' => 'button'
                ]) . "\n"
                . Html::a($this->controls[1], '#' . $this->options['id'], [
                    'class' => 'carousel-control-next',
                    'data-slide' => 'next',
                    'role' => 'button'
                ]);
        }

        if ($this->controls === false) {
            return '';
        }

        throw new InvalidConfigException(
            'The "controls" property must be either false or an array of two elements.'
        );
    }

    /**
     * {@see $controls}
     *
     * @param array $value
     *
     * @return Carousel
     */
    public function controls(array $value): Carousel
    {
        $this->controls = $value;

        return $this;
    }

    /**
     * {@see $crossfade}
     *
     * @param bool $value
     *
     * @return Carousel
     */
    public function crossfade(bool $value): Carousel
    {
        $this->crossfade = $value;

        return $this;
    }

    /**
     * {@see $items}
     *
     * @param array $value
     *
     * @return Carousel
     */
    public function items(array $value): Carousel
    {
        $this->items = $value;

        return $this;
    }

    /**
     * {@see $options}
     *
     * @param array $value
     *
     * @return Carousel
     */
    public function options(array $value): Carousel
    {
        $this->options = $value;

        return $this;
    }

    /**
     * {@see $showIndicator}
     *
     * @param bool $value
     *
     * @return Carousel
     */
    public function showIndicators(bool $value): Carousel
    {
        $this->showIndicators = $value;

        return $this;
    }
}
