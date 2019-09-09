<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

/**
 * Widget.
 */
class Widget extends \Yiisoft\Widget\Widget
{
    use BootstrapWidgetTrait;

    /**
     * @var string $id
     */
    private $id;

    /**
     * @var boolean $autoGenerate
     */
    private $autoGenerate = true;

    /**
     * @var int a counter used to generate {@see id} for widgets.
     */
    private static $counter = 0;

    /**
     * @var string the prefix to the automatically generated widget IDs.
     *
     * {@see getId()}
     */
    private static $autoIdPrefix = 'w';

    /**
     * Returns the ID of the widget.
     *
     * @param bool $autoGenerate whether to generate an ID if it is not set previously
     *
     * @return string ID of the widget.
     */
    public function getId(): string
    {
        if ($this->autoGenerate && $this->id === null) {
            $this->id = self::$autoIdPrefix . self::$counter++;
        }

        return $this->id;
    }

    public static function counter(int $value): void
    {
        self::$counter = $value;
    }
}
