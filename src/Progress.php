<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use LogicException;
use RuntimeException;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function round;
use function sprintf;

use const PHP_ROUND_HALF_UP;

/**
 * Progress renders a bootstrap progress bar component.
 *
 * For example,
 *
 * ```php
 * // default with label
 * echo Progress::widget()
 *     ->percent(60)
 *     ->label('test');
 *
 * // styled
 * echo Progress::widget()
 *     ->percent(65)
 *     ->barOptions([
 *          'class' => 'bg-danger'
 *     ]);
 *
 * // striped
 * echo Progress::widget()
 *     ->striped()
 *     ->percent(70)
 *     ->barOptions([
 *         'class' => 'bg-warning'
 *     ]);
 *
 * // striped animated
 * echo Progress::widget()
 *     ->percent(70)
 *     ->animated()
 *     ->barOptions([
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
    private bool $inStack = false;

    public function render(): string
    {
        if ($this->percent === null) {
            throw new RuntimeException('The "percent" option is required.');
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        $options['role'] = 'progressbar';

        if ($this->label !== '') {
            $options['aria']['label'] = $this->label;
        }

        $options['aria']['valuenow'] = $this->percent;
        $options['aria']['valuemin'] = $this->min;
        $options['aria']['valuemax'] = $this->max;

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, 'progress');

        if ($this->inStack) {
            Html::addCssStyle($options, ['width' => $this->percent . '%'], true);
        }

        return Html::tag($tag, $this->renderBar(), $options)
                ->encode(false)
                ->render();
    }

    /**
     * The HTML attributes of the bar.
     *
     * {@see Html::renderTagAttributes() for details on how attributes are being rendered}
     */
    public function barOptions(array $value): self
    {
        $new = clone $this;
        $new->barOptions = $value;

        return $new;
    }

    public function label(string $value): self
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
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * The amount of progress as a percentage.
     */
    public function percent(int|float $percent): self
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

    /**
     * @param float|int $value
     * @param float|int $max
     * @psalm-param int<0, max>|null $precision
     * @psalm-param int<0, max> $mode
     *
     * @return self
     */
    public function calculatedPercent(
        int|float $value,
        int|float $max,
        ?int $precision = null,
        int $mode = PHP_ROUND_HALF_UP
    ): self {
        $percent = $value / $max * 100;

        if ($precision !== null) {
            $percent = round($percent, $precision, $mode);
        }

        return $this->percent($percent);
    }

    public function min(int|float $min): self
    {
        $new = clone $this;
        $new->min = $min;

        return $new;
    }

    public function max(int|float $max): self
    {
        $new = clone $this;
        $new->max = $max;

        return $new;
    }

    public function content(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    public function striped(bool $striped = true): self
    {
        $new = clone $this;
        $new->striped = $striped;

        return $new;
    }

    public function animated(bool $animated = true): self
    {
        $new = clone $this;
        $new->animated = $animated;

        if ($new->animated) {
            $new->striped = true;
        }

        return $new;
    }

    public function inStack(bool $inStack = true): self
    {
        $new = clone $this;
        $new->inStack = $inStack;

        return $new;
    }

    /**
     * Generates a bar.
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

        Html::addCssClass($options, $classNames);

        if (!$this->inStack) {
            Html::addCssStyle($options, ['width' => $this->percent . '%'], true);
        }

        return Html::tag($tag, $this->content, $options)
                ->encode($encode)
                ->render();
    }
}
