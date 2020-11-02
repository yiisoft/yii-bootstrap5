<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Assets;

use Yiisoft\Assets\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * BootstrapAsset.
 *
 * @package Bootstrap5
 */
class BootstrapAsset extends AssetBundle
{
    public ?string $basePath = '@assets';

    public ?string $baseUrl = '@assetsUrl';

    public ?string $sourcePath = '@npm/bootstrap/dist';

    public array $css = [
        'css/bootstrap.css'
    ];

    public array $js = [
        'js/bootstrap.bundle.js'
    ];

    public array $publishOptions = [
        'only' => [
            'css/bootstrap.css',
            'js/bootstrap.bundle.js'
        ],
    ];
}
