<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Yii\Bootstrap4\Tests\Data;

/**
 * Web session class mock.
 */
class Session extends \yii\web\Session
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // blank, override, preventing shutdown function registration
    }

    public function open()
    {
        // blank, override, preventing session start
    }
}
