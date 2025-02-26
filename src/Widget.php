<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget as YiiWidget;

abstract class Widget extends YiiWidget
{
    /**
     * @psalm-suppress MissingClassConstType Remove suppress after fix https://github.com/vimeo/psalm/issues/11024
     */
    final public const THEME_DARK = 'dark';

    /**
     * @psalm-suppress MissingClassConstType Remove suppress after fix https://github.com/vimeo/psalm/issues/11024
     */
    final public const THEME_LIGHT = 'light';

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
    public function id(string $id): static
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @return static
     *
     * @see getId()
     */
    public function autoIdPrefix(string $prefix): static
    {
        $new = clone $this;
        $new->autoIdPrefix = $prefix;

        return $new;
    }

    public function withTheme(?string $theme): static
    {
        $new = clone $this;
        $new->theme = $theme;

        return $new;
    }

    public function withDarkTheme(): static
    {
        return $this->withTheme(self::THEME_DARK);
    }

    public function withLightTheme(): static
    {
        return $this->withTheme(self::THEME_LIGHT);
    }
}
