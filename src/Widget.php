<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

/**
 * Widget.
 */
class Widget extends \Yiisoft\Widget\Widget
{
    use BootstrapWidgetTrait;

    /**
     * @var string|null ?string $id
     */
    private ?string $id = null;

    /**
     * @var boolean $autoGenerate
     */
    private bool $autoGenerate = true;

    /**
     * @var int a counter used to generate {@see id} for widgets.
     */
    private static int $counter = 0;

    /**
     * @var string the prefix to the automatically generated widget IDs.
     *
     * {@see getId()}
     */
    private static string $autoIdPrefix = 'w';

    public function run(): string
    {
        return parent::run();
    }

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
     * @var string $value
     *
     * @return $this
     */
    public function setId(string $value): self
    {
        $this->id = $value;

        return $this;
    }

    public static function counter(int $value): void
    {
        self::$counter = $value;
    }
}
