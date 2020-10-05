<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

abstract class Widget extends \Yiisoft\Widget\Widget
{
    use BootstrapWidgetTrait;

    private string $id;
    private bool $autoGenerate = true;
    private static int $counter = 0;
    private static string $autoIdPrefix = 'w';

    /**
     * Returns the Id of the widget.
     *
     * @return string Id of the widget.
     */
    public function getId(): string
    {
        if ($this->autoGenerate) {
            $this->id = self::$autoIdPrefix . static::$counter++;
        }

        return $this->id;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setId(string $value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * Counter used to generate {@see id} for widgets.
     *
     * @param int $value
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
     * {@see getId()}
     */
    public static function autoIdPrefix(string $value): void
    {
        self::$autoIdPrefix = $value;
    }
}
