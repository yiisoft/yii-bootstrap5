<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function parse_url;

use const PHP_URL_PATH;

/**
 * {@see AbstractMenu::links()} for details.
 */
final class Link extends Widget
{
    private ?string $tag = null;
    private ?string $widgetClassName = null;
    private bool $active = false;
    private bool $disabled = false;
    private string|Stringable $label = '';
    private ?TabPane $pane = null;
    private ?Item $item = null;
    private ?bool $encode = null;
    private ?string $url = null;
    private array $options = [];
    private array $activeOptions = [];
    private bool $visible = true;
    private ?string $toggle = null;

    public function __clone()
    {
        if ($this->item) {
            $this->item = $this->item->link($this);
        }

        if ($this->pane) {
            $this->pane = $this->pane->link($this);
        }
    }

    public function getId(): ?string
    {
        return $this->options['id'] ?? parent::getId();
    }

    public function tag(?string $tag): self
    {
        $new = clone $this;
        $new->tag = $tag;

        return $new;
    }

    public function getTag(): string
    {
        if ($this->tag) {
            return $this->tag;
        }

        return $this->url ? 'a' : 'button';
    }

    public function widgetClassName(?string $name, bool $replace = false): self
    {
        if (!$replace && $this->widgetClassName) {
            return $this;
        }

        $new = clone $this;
        $new->widgetClassName = $name;

        return $new;
    }

    public function active(bool $active): self
    {
        $new = clone $this;
        $new->active = $active;

        return $new;
    }

    public function activate(): self
    {
        $this->active = true;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function disabled(bool $disabled): self
    {
        $new = clone $this;
        $new->disabled = $disabled;

        return $new;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function visible(bool $visible): self
    {
        $new = clone $this;
        $new->visible = $visible;

        return $new;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function label(string|Stringable $label): self
    {
        $new = clone $this;
        $new->label = $label;

        return $new;
    }

    public function getLabel(): string|Stringable
    {
        return $this->label;
    }

    public function pane(?TabPane $pane): self
    {
        $new = clone $this;
        $new->pane = $pane?->link($new);

        return $new;
    }

    public function getPane(): ?TabPane
    {
        return $this->pane;
    }

    public function item(?Item $item): self
    {
        $new = clone $this;
        $new->item = $item?->link($new);

        return $new;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function encode(?bool $encode): self
    {
        $new = clone $this;
        $new->encode = $encode;

        return $new;
    }

    public function isEncoded(): ?bool
    {
        return $this->encode;
    }

    public function url(?string $url): self
    {
        $new = clone $this;
        $new->url = $url;

        return $new;
    }

    public function getUrl(): ?string
    {
        return $this->options['href'] ?? $this->url;
    }

    public function getPath(): ?string
    {
        if ($url = $this->getUrl()) {
            return parse_url($url, PHP_URL_PATH);
        }

        return null;
    }

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    public function addOptions(array $options): self
    {
        $new = clone $this;
        $new->options = self::mergeAttributes($new->options, $options);

        return $new;
    }

    public function activeOptions(array $options): self
    {
        $new = clone $this;
        $new->activeOptions = $options;

        return $new;
    }

    public function toggle(?string $toggle): self
    {
        $new = clone $this;
        $new->toggle = $toggle;

        return $new;
    }

    private static function mergeAttributes(array $old, array $new): array
    {
        $classes = ArrayHelper::remove($new, 'class');
        $styles = ArrayHelper::remove($new, 'style');
        $old = [...$old, ...$new];

        if ($classes) {
            Html::addCssClass($old, $classes);
        }

        if ($styles) {
            Html::addCssStyle($old, $styles);
        }

        return $old;
    }

    public function render(): string
    {
        if (!$this->visible) {
            return '';
        }

        $tag = $this->getTag();
        $options = $this->options;
        $classNames = $this->widgetClassName ? ['widget' => $this->widgetClassName] : [];

        if (!isset($options['id'])) {
            $options['id'] = parent::getId();
        }

        if ($tag === 'a' && empty($options['href'])) {
            $options['href'] = $this->url;
        } elseif ($tag === 'button' && !isset($options['type'])) {
            $options['type'] = 'button';
        }

        if ($this->toggle && !isset($options['data-bs-toggle']) && !isset($options['data']['bs-toggle'])) {
            $options['data-bs-toggle'] = $this->toggle;
        }

        if ($this->pane) {
            $options['role'] = 'tab';
            $options['aria-controls'] = $this->pane->getId();
            $options['aria-selected'] = $this->active ? 'true' : 'false';

            if ($tag === 'a' && empty($options['href'])) {
                $options['href'] = '#' . $this->pane->getId();
            } else {
                $options['data-bs-target'] = '#' . $this->pane->getId();
            }
        }

        if ($this->active) {
            $classNames['active'] = 'active';

            if ($tag === 'a' && $this->getPath()) {
                $options['aria']['current'] = 'page';
            }

            $options = self::mergeAttributes($options, $this->activeOptions);
        }

        if ($this->disabled) {
            if ($this->tag === 'button') {
                $options['disabled'] = true;
            } else {
                $classNames['disabled'] = 'disabled';

                if ($tag === 'a') {
                    $options['aria']['disabled'] = 'true';
                }
            }
        }

        Html::addCssClass($options, $classNames);

        /** @psalm-var non-empty-string $tag */
        return Html::tag($tag, $this->label, $options)
                ->encode($this->encode)
                ->render();
    }
}
