<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Widget\Widget as YiiWidget;

abstract class Widget extends YiiWidget
{
    public const THEME_DARK = 'dark';
    public const THEME_LIGHT = 'light';

    private ?string $id = null;
    private bool $autoGenerate = true;
    private string $autoIdPrefix = 'w';
    private static int $counter = 0;
    protected ?string $theme = null;

    /**
     * Returns the ID of the widget.
     *
     * $param string|null $suffix
     *
     * @return string|null ID of the widget.
     */
    public function getId(?string $suffix = null): ?string
    {
        if ($this->autoGenerate && $this->id === null) {
            $this->id = $this->autoIdPrefix . static::$counter++ . $suffix;
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
     * Counter used to generate {@see id} for widgets.
     */
    public static function counter(int $value): void
    {
        self::$counter = $value;
    }

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @return static
     * {@see getId()}
     */
    public function autoIdPrefix(string $value): static
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;

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
