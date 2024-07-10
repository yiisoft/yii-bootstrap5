<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

/**
 * ProgressStack renders a bootstrap progress bar component.
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

    public function withBars(Progress ...$bars): self
    {
        $new = clone $this;
        $new->bars = $bars;

        return $new;
    }

    public function withOptions(array $options): self
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

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($options, ['progress-stacked']);

        return Html::tag($tag)
                ->content(...$this->bars)
                ->attributes($options)
                ->encode(false)
                ->render();
    }
}
