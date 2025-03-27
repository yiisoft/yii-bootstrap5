<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Assets;

use Yiisoft\Assets\AssetManager;
use Yiisoft\Assets\AssetBundle;
use Yiisoft\Files\PathMatcher\PathMatcher;

/**
 * Asset bundle for the Bootstrap files.
 *
 * @psalm-import-type CssFile from AssetManager
 * @psalm-import-type JsFile from AssetManager
 */
final class BootstrapAsset extends AssetBundle
{
    public ?string $basePath = '@assets';

    public ?string $baseUrl = '@assetsUrl';

    public ?string $sourcePath = '@npm/bootstrap/dist';

    /**
     * @psalm-var array<array-key, string|CssFile>
     */
    public array $css = [
        'css/bootstrap.css',
    ];

    /**
     * @psalm-var array<array-key, string|JsFile>
     */
    public array $js = [
        'js/bootstrap.bundle.js',
    ];

    public function __construct()
    {
        $pathMatcher = new PathMatcher();

        $this->publishOptions = [
            'filter' => $pathMatcher->only(
                '**css/bootstrap.css',
                '**css/bootstrap.css.map',
                '**js/bootstrap.bundle.js',
                '**js/bootstrap.bundle.js.map',
            ),
        ];
    }
}
