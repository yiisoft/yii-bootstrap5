<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

abstract class Widget extends \Yiisoft\Widget\Widget
{
    private ?string $id = null;
    private bool $autoGenerate = true;
    private string $autoIdPrefix = 'w';
    private static int $counter = 0;

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
     * @return self
     */
    public function id(string $value): self
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
     * @param string $value
     *
     * @return self
     *
     * {@see getId()}
     */
    public function autoIdPrefix(string $value): self
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;

        return $new;
    }
}
