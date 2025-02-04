<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_map;

/**
 * `ProgressStack` renders a bootstrap progress bar component.
 *
 * @see https://getbootstrap.com/docs/5.3/components/progress/#multiple-bars
 */
final class ProgressStack extends Widget
{
    /**
     * @var Progress[]
     */
    private array $bars = [];

    private array $options = [];

    public function bars(Progress ...$bars): self
    {
        $new = clone $this;
        $new->bars = array_map(static fn (Progress $bar): Progress => $bar->inStack(true), $bars);

        return $new;
    }

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    public function render(): string
    {
        if ($this->bars === []) {
            return '';
        }

        $options = $this->options;

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');

        Html::addCssClass($options, 'progress-stacked');

        return Html::tag($tag)
                ->content(...$this->bars)
                ->attributes($options)
                ->encode(false)
                ->render();
    }
}
