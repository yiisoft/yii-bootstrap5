<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Html\Html;

/**
 * TabPane renders content for each tab.
 *
 * {@see Link::pane()} for details.
 * {@see Tabs::renderTabContent()} for details.
 *
 * @psalm-suppress MissingConstructor
 */
final class TabPane extends Widget
{
    private Link $link;
    private string|Stringable $content = '';

    /**
     * @psalm-var non-empty-string $tag
     */
    private string $tag = 'div';
    private array $options = [];
    private bool $fade = false;
    private ?bool $encode = null;

    public function content(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = $content;

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

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#fade-effect
     */
    public function fade(bool $fade): self
    {
        $new = clone $this;
        $new->fade = $fade;

        return $new;
    }

    public function encode(?bool $encode): self
    {
        $new = clone $this;
        $new->encode = $encode;

        return $new;
    }

    public function link(Link $link): self
    {
        $new = clone $this;
        $new->link = $link;

        return $new;
    }

    public function render(): string
    {
        $options = $this->options;
        $linkId = $this->link->getId();
        $classNames = ['widget' => 'tab-pane'];

        if (!isset($options['id'])) {
            $options['id'] = $this->getId();
        }

        if (!isset($options['tabindex'])) {
            $options['tabindex'] = 0;
        }

        if ($linkId && !isset($options['aria-labelledby']) && !isset($options['aria']['labelledby'])) {
            $options['aria-labelledby'] = $linkId;
        }

        if (!isset($options['role'])) {
            $options['role'] = 'tabpanel';
        }

        if ($this->fade) {
            $classNames[] = 'fade';
        }

        if ($this->link->isActive()) {
            $classNames[] = 'active';

            if ($this->fade) {
                $classNames[] = 'show';
            }
        }

        Html::addCssClass($options, $classNames);

        return Html::tag($this->tag, $this->content, $options)
                ->encode($this->encode)
                ->render();
    }
}
