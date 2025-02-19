<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Assets;

use Yiisoft\Assets\AssetManager;
use Yiisoft\Assets\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap CSS files via CDN.
 *
 * BootstrapAsset.
 *
 * @psalm-import-type CssFile from AssetManager
 * @psalm-import-type JsFile from AssetManager
 */
final class BootstrapCdnAsset extends AssetBundle
{
    public bool $cdn = true;

    /**
     * @psalm-var array<array-key, string|CssFile>
     */
    public array $css = [
        [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css',
            'integrity' => 'sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1',
            'crossorigin' => 'anonymous',
        ],
    ];

    /**
     * @psalm-var array<array-key, string|JsFile>
     */
    public array $js = [
        [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js',
            'integrity' => 'sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW',
            'crossorigin' => 'anonymous',
        ],
    ];
}
