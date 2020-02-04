<?php

declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Widget\Exception\InvalidConfigException;

/**
 * Progress renders a bootstrap progress bar component.
 *
 * For example,
 *
 * ```php
 * // default with label
 * echo Progress::widget()
 *     ->percent('60')
 *     ->label(test);
 *
 * // styled
 * echo Progress::widget()
 *     ->bars([
 *         ['percent' => '65', 'options' => ['class' => 'bg-danger']]
 *     ]);
 *
 * // striped
 * echo Progress::widget()
 *     ->'bars'([
 *         ['percent' => '70', 'options' => ['class' => 'bg-warning progress-bar-striped']]
 *     ]);
 *
 * // striped animated
 * echo Progress::widget()
 *     ->percent('70')
 *     ->options'(['class' => 'bg-success progress-bar-animated progress-bar-striped']);
 *
 * // stacked bars
 * echo Progress::widget()
 *     'bars' => ([
 *         ['percent' => '30', 'options' => ['class' => 'bg-danger']],
 *         ['percent' => '30', 'label' => 'test', 'options' => ['class' => 'bg-success']],
 *         ['percent' => '35', 'options' => ['class' => 'bg-warning']],
 *     ]);
 * ```
 */
class Progress extends Widget
{
    /**
     * @var string the button label.
     */
    private string $label;

    /**
     * @var string|null the amount of progress as a percentage.
     */
    private ?string $percent = null;

    /**
     * @var array a set of bars that are stacked together to form a single progress bar.
     *
     * Each bar is an array of the following structure:
     *
     * ```php
     * [
     *     // required, the amount of progress as a percentage.
     *     'percent' => 30,
     *     // optional, the label to be displayed on the bar
     *     'label' => '30%',
     *     // optional, array, additional HTML attributes for the bar tag
     *     'options' => [],
     * ]
     * ```
     */
    private array $bars;

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $options = [];

    /**
     * @var array the HTML attributes of the bar. This property will only be considered if {@see bars} is empty
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes() for details on how attributes are being rendered}
     */
    public array $barOptions = [];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-progress";
        }

        Html::addCssClass($this->options, ['widget' => 'progress']);

        return $this->renderProgress();
    }

    /**
     * Renders the progress.
     *
     * @return string the rendering result.
     *
     * @throws InvalidConfigException if the "percent" option is not set in a stacked progress bar.
     */
    protected function renderProgress(): string
    {
        $out = Html::beginTag('div', $this->options) . "\n";

        if (empty($this->bars)) {
            $this->bars = [
                ['label' => $this->label, 'percent' => $this->percent, 'options' => $this->barOptions]
            ];
        }

        $bars = [];

        foreach ($this->bars as $bar) {
            $label = ArrayHelper::getValue($bar, 'label', '');
            if (!isset($bar['percent'])) {
                throw new InvalidConfigException("The 'percent' option is required.");
            }
            $options = ArrayHelper::getValue($bar, 'options', []);
            $bars[] = $this->renderBar($bar['percent'], $label, $options);
        }

        $out .= implode("\n", $bars) . "\n";
        $out .= Html::endTag('div');

        return $out;
    }

    /**
     * Generates a bar.
     *
     * @param string $percent the percentage of the bar
     * @param string $label , optional, the label to display at the bar
     * @param array $options the HTML attributes of the bar
     *
     * @return string the rendering result.
     */
    protected function renderBar(string $percent, string $label = '', array $options = []): string
    {
        $valuePercent = (float)trim(rtrim($percent, '%'));

        $options = \array_merge($options, [
            'role' => 'progressbar',
            'aria-valuenow' => $percent,
            'aria-valuemin' => 0,
            'aria-valuemax' => 100
        ]);

        Html::addCssClass($options, ['widget' => 'progress-bar']);
        Html::addCssStyle($options, ['width' => $valuePercent . '%'], true);

        return Html::tag('div', $label, $options);
    }

    /**
     * {@see $bars}
     *
     * @param array $value
     *
     * @return Progress
     */
    public function bars(array $value): Progress
    {
        $this->bars = $value;

        return $this;
    }

    /**
     * {@see $barOptions}
     *
     * @param array $value
     *
     * @return Progress
     */
    public function barOptions(array $value): Progress
    {
        $this->barOptions = $value;

        return $this;
    }

    /**
     * {@see $label}
     *
     * @param string $value
     *
     * @return Progress
     */
    public function label(string $value): Progress
    {
        $this->label = $value;

        return $this;
    }

    /**
     * {@see $options}
     *
     * @param array $value
     *
     * @return Progress
     */
    public function options(array $value): Progress
    {
        $this->options = $value;

        return $this;
    }

    /**
     * {@see $percent}
     *
     * @param string $value
     *
     * @return Progress
     */
    public function percent(string $value): Progress
    {
        $this->percent = $value;

        return $this;
    }
}
