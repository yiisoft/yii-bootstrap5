<?php
declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4\Exception;

use Throwable;

/**
 * Class InvalidConfigException.
 */
class InvalidConfigException extends \Exception
{
    /**
     * __construct.
     *
     * @param string $message
     * @param integer $code
     *
     * @param Throwable $previous
     */
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
