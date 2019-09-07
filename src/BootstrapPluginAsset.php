<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Asset\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap javascript files.
 *
 * BootstrapPluginAsset.
 */
class BootstrapPluginAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap/dist';

    public $js = [
        'js/bootstrap.bundle.js',
    ];

    public $depends = [
        \Yiisoft\Yii\JQuery\JqueryAsset::class,
        \Yiisoft\Yii\Bootstrap4\BootstrapAsset::class,
    ];
}
