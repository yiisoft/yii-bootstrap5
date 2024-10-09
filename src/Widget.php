<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget as YiiWidget;
use Yiisoft\Yii\Bootstrap5\Enum\Theme;

use function is_object;

abstract class Widget extends YiiWidget
{
    private ?string $id = null;
    private bool $autoGenerate = true;
    private string $autoIdPrefix = 'bp5w';
    protected ?string $theme = null;

    /**
     * Returns the ID of the widget.
     *
     * @return string|null ID of the widget.
     */
    public function getId(): ?string
    {
        if ($this->autoGenerate && $this->id === null) {
            $this->id = Html::generateId($this->autoIdPrefix);
        }

        return $this->id;
    }

    /**
     * Set the ID of the widget.
     *
     * @return static
     */
    public function id(string $value): static
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @return static
     *
     * @see getId()
     */
    public function autoIdPrefix(string $value): static
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;

        return $new;
    }

    public function withTheme(string|Theme|null $theme): static
    {
        $new = clone $this;
        $new->theme = is_object($theme) ? $theme->value : $theme;

        return $new;
    }

    public function withDarkTheme(): static
    {
        return $this->withTheme(Theme::Dark);
    }

    public function withLightTheme(): static
    {
        return $this->withTheme(Theme::Light);
    }
}
