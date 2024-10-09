<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

/**
 * Item renders item for Tabs|Nav.
 *
 * {@see Link::item()} for details
 *
 * @psalm-suppress MissingConstructor
 */
final class Item extends Widget
{
    /**
     * @psalm-var non-empty-string $tag
     */
    private string $tag = 'li';
    private Link $link;
    private array $options = [];
    private ?string $widgetClassName = null;
    private ?string $started = null;

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    /**
     * @psalm-param non-empty-string $tag
     */
    public function tag(string $tag): self
    {
        $new = clone $this;
        $new->tag = $tag;

        return $new;
    }

    public function widgetClassName(?string $name): self
    {
        $new = clone $this;
        $new->widgetClassName = $name;

        return $new;
    }

    public function link(Link $link): self
    {
        $new = clone $this;
        $new->link = $link;

        return $new;
    }

    public function getLink(): Link
    {
        return $this->link;
    }

    public function begin(array $options = []): ?string
    {
        parent::begin();

        return $this->renderStart($options);
    }

    private function renderStart(array $options = []): ?string
    {
        if (!$this->link->isVisible()) {
            return null;
        }

        $options = ArrayHelper::merge($this->options, $options);
        $classNames = $this->widgetClassName ? ['widget' => $this->widgetClassName] : [];

        if ($this->link->getPane() && !isset($options['role'])) {
            $options['role'] = 'presentation';
        }

        Html::addCssClass($options, $classNames);

        $this->started = Html::openTag($this->tag, $options);
        $this->started .= $this->link;

        return $this->started;
    }

    public function render(): string
    {
        if ($this->started) {
            $this->started = null;

            return Html::closeTag($this->tag);
        }

        if ($started = $this->renderStart()) {
            $this->started = null;

            return $started . Html::closeTag($this->tag);
        }

        return '';
    }
}
