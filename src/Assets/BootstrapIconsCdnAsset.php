<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Assets;

use Yiisoft\Assets\AssetBundle;

final class BootstrapIconsCdnAsset extends AssetBundle
{
    public bool $cdn = true;

    public array $css = [
        [
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css',
        ],
    ];
}
