<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use LogicException;
use RuntimeException;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function sprintf;

/**
 * Progress renders a bootstrap progress bar component.
 *
 * For example,
 *
 * ```php
 * // default with label
 * echo Progress::widget()
 *     ->withPercent(60)
 *     ->withLabel('test');
 *
 * // styled
 * echo Progress::widget()
 *     ->withPercent(65)
 *     ->withBarOptions([
 *          'class' => 'bg-danger'
 *     ]);
 *
 * // striped
 * echo Progress::widget()
 *     ->withStriped()
 *     ->withPercent(70)
 *     ->withBarOptions([
 *         'class' => 'bg-warning'
 *     ]);
 *
 * // striped animated
 * echo Progress::widget()
 *     ->withPercent(70)
 *     ->withAnimated()
 *     ->withBarOptions([
 *          'class' => 'bg-success'
 *     ]);
 */
final class Progress extends Widget
{
    private string $label = '';
    private string|Stringable $content = '';
    private int|float|null $percent = null;
    private int|float $min = 0;
    private int|float $max = 100;
    private array $options = [];
    private array $barOptions = [];
    private bool $striped = false;
    private bool $animated = false;

    public function render(): string
    {
        if ($this->percent === null) {
            throw new RuntimeException('The "percent" option is required.');
        }

        $options = $this->options;

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        $options['role'] = 'progressbar';

        if ($this->label) {
            $options['aria']['label'] = $this->label;
        }

        $options['aria']['valuenow'] = $this->percent;
        $options['aria']['valuemin'] = $this->min;
        $options['aria']['valuemax'] = $this->max;

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, ['progress']);

        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::tag($tag, $this->renderBar(), $options)
                ->encode(false)
                ->render();
    }

    /**
     * The HTML attributes of the bar. This property will only be considered if {@see bars} is empty.
     *
     * {@see Html::renderTagAttributes() for details on how attributes are being rendered}
     */
    public function withBarOptions(array $value): self
    {
        $new = clone $this;
        $new->barOptions = $value;

        return $new;
    }

    /**
     * The button label.
     */
    public function withLabel(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function withOptions(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * The amount of progress as a percentage.
     */
    public function withPercent(int|float $percent): self
    {
        if ($percent < 0) {
            throw new LogicException(
                sprintf('"$percent" must be greater or equals 0. %d given', $percent)
            );
        }

        $new = clone $this;
        $new->percent = $percent;

        return $new;
    }

    public function withCalculatedPercent(int|float $value, int|float $max): self
    {
        return $this->withPercent($value / $max * 100);
    }

    public function withMin(int|float $min): self
    {
        $new = clone $this;
        $new->min = $min;

        return $new;
    }

    public function withMax(int|float $max): self
    {
        $new = clone $this;
        $new->max = $max;

        return $new;
    }

    public function withContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    public function withStriped(bool $striped = true): self
    {
        $new = clone $this;
        $new->striped = $striped;

        return $new;
    }

    public function withAnimated(bool $animated = true): self
    {
        $new = clone $this;
        $new->animated = $animated;

        if ($new->animated) {
            $new->striped = true;
        }

        return $new;
    }

    /**
     * Generates a bar.
     *
     * @param string $percent the percentage of the bar
     * @param string $label , optional, the label to display at the bar
     * @param array $options the HTML attributes of the bar
     *
     * @throws JsonException
     *
     * @return string the rendering result.
     */
    private function renderBar(): string
    {
        $options = $this->barOptions;
        $encode = ArrayHelper::remove($options, 'encode');
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $classNames = ['progress-bar'];

        if ($this->striped) {
            $classNames[] = 'progress-bar-striped';
        }

        if ($this->animated) {
            $classNames[] = 'progress-bar-animated';
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, $classNames);
        Html::addCssStyle($options, ['width' => $this->percent . '%'], true);

        return Html::tag($tag, $this->content, $options)
                ->encode($encode)
                ->render();
    }
}
