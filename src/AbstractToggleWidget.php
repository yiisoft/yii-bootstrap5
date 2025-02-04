<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

abstract class AbstractToggleWidget extends Widget
{
    protected array $toggleOptions = [];
    protected string|Stringable $toggleLabel = '';
    protected bool $renderToggle = true;

    abstract protected function toggleComponent(): string;

    public function withToggleOptions(array $options): static
    {
        $new = clone $this;
        $new->toggleOptions = $options;

        return $new;
    }

    public function withToggleLabel(string|Stringable $label): static
    {
        $new = clone $this;
        $new->toggleLabel = $label;

        return $new;
    }

    public function withToggle(bool $value): static
    {
        if ($this->renderToggle === $value) {
            return $this;
        }

        $new = clone $this;
        $new->renderToggle = $value;

        return $new;
    }

    protected function prepareToggleOptions(): array
    {
        $options = $this->toggleOptions;
        $tagName = ArrayHelper::remove($options, 'tag', 'button');
        $encode = ArrayHelper::remove($options, 'encode', true);
        $options['data-bs-toggle'] = $this->toggleComponent();

        if (!isset($options['aria-controls']) && !isset($options['aria']['controls'])) {
            $options['aria-controls'] = $this->getId();
        }

        if ($tagName !== 'button') {
            $options['role'] = 'button';
        } elseif (!isset($options['type'])) {
            $options['type'] = 'button';
        }

        if ($tagName === 'a' && !isset($options['href'])) {
            $options['href'] = '#' . $this->getId();
        } elseif (!isset($options['data-bs-target']) && !isset($options['data']['bs-target'])) {
            $options['data-bs-target'] = '#' . $this->getId();
        }

        return [$tagName, $options, $encode];
    }

    public function renderToggle(): Tag
    {
        [$tagName, $options, $encode] = $this->prepareToggleOptions();

        return Html::tag($tagName, $this->toggleLabel, $options)
            ->encode($encode);
    }
}
