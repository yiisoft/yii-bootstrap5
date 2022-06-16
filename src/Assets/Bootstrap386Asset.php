<?php

declare(strict_types=1);

namespace RedCatGirl\YiiBootstrap386\Assets;

use Yiisoft\Assets\AssetBundle;
use Yiisoft\Files\PathMatcher\PathMatcher;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * BootstrapAsset.
 *
 * @package Bootstrap386
 */
final class Bootstrap386Asset extends AssetBundle
{
    public ?string $basePath = '@assets';

    public ?string $baseUrl = '@assetsUrl';

    public ?string $sourcePath = '@vendor/kristopolous/bootsrap.386';

    public array $css = [
        'css/bootstrap.css',
    ];

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
