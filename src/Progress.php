<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;
use function implode;
use function rtrim;
use function trim;

/**
 * Progress renders a bootstrap progress bar component.
 *
 * For example,
 *
 * ```php
 * // default with label
 * echo Progress::widget()
 *     ->percent('60')
 *     ->label('test');
 *
 * // styled
 * echo Progress::widget()
 *     ->bars([
 *         ['percent' => '65', 'options' => ['class' => 'bg-danger']]
 *     ]);
 *
 * // striped
 * echo Progress::widget()
 *     ->bars([
 *         ['percent' => '70', 'options' => ['class' => 'bg-warning progress-bar-striped']]
 *     ]);
 *
 * // striped animated
 * echo Progress::widget()
 *     ->percent('70')
 *     ->barOptions(['class' => 'bg-success progress-bar-animated progress-bar-striped']);
 *
 * // stacked bars
 * echo Progress::widget()
 *     bars => ([
 *         ['percent' => '30', 'options' => ['class' => 'bg-danger']],
 *         ['percent' => '30', 'label' => 'test', 'options' => ['class' => 'bg-success']],
 *         ['percent' => '35', 'options' => ['class' => 'bg-warning']],
 *     ]);
 * ```
 */
final class Progress extends Widget
{
    private string $label = '';
    private string $percent = '';
    private array $bars = [];
    private array $options = [];
    private array $barOptions = [];
    private bool $encodeTags = false;

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-progress";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'progress']);

        return $this->renderProgress();
    }

    /**
     * Set of bars that are stacked together to form a single progress bar.
     *
     * Each bar is an array of the following structure:
     *
     * ```php
     * [
     *     // required, the amount of progress as a percentage.
     *     'percent' => '30',
     *     // optional, the label to be displayed on the bar
     *     'label' => '30%',
     *     // optional, array, additional HTML attributes for the bar tag
     *     'options' => [],
     * ]
     * ```
     *
     * @param array $value
     *
     * @return self
     */
    public function bars(array $value): self
    {
        $new = clone $this;
        $new->bars = $value;

        return $new;
    }

    /**
     * The HTML attributes of the bar. This property will only be considered if {@see bars} is empty.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see Html::renderTagAttributes() for details on how attributes are being rendered}
     */
    public function barOptions(array $value): self
    {
        $new = clone $this;
        $new->barOptions = $value;

        return $new;
    }

    /**
     * The button label.
     *
     * @param string $value
     *
     * @return self
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
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
     *
     * @param string $value
     *
     * @return self
     */
    public function percent(string $value): self
    {
        $new = clone $this;
        $new->percent = $value;

        return $new;
    }

    /**
     * Renders the progress.
     *
     * @throws JsonException|RuntimeException if the "percent" option is not set in a stacked progress bar.
     *
     * @return string the rendering result.
     */
    private function renderProgress(): string
    {
        if (empty($this->bars)) {
            $this->bars = [
                ['label' => $this->label, 'percent' => $this->percent, 'options' => $this->barOptions],
            ];
        }

        $bars = [];

        foreach ($this->bars as $bar) {
            $label = ArrayHelper::getValue($bar, 'label', '');
            if (!isset($bar['percent'])) {
                throw new RuntimeException('The "percent" option is required.');
            }
            $options = ArrayHelper::getValue($bar, 'options', []);
            $bars[] = $this->renderBar($bar['percent'], $label, $options);
        }

        return Html::div(implode("\n", $bars), $this->options)
            ->encode($this->encodeTags)
            ->render();
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
    private function renderBar(string $percent, string $label = '', array $options = []): string
    {
        $valuePercent = (float)trim(rtrim($percent, '%'));

        $options = array_merge($options, [
            'role' => 'progressbar',
            'aria-valuenow' => $percent,
            'aria-valuemin' => 0,
            'aria-valuemax' => 100,
        ]);

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, ['widget' => 'progress-bar']);
        Html::addCssStyle($options, ['width' => $valuePercent . '%'], true);

        return Html::div($label, $options)->render();
    }
}
