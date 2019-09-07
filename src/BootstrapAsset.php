<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Asset\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * BootstrapAsset.
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap/dist';

    public $css = [
        'css/bootstrap.css',
    ];
}
