<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4\Assets;

use Yiisoft\Assets\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * JqueryAsset.
 *
 * @package Bootstrap4
 */
class JqueryAsset extends AssetBundle
{
    public ?string $basePath = '@basePath';

    public ?string $baseUrl = '@web';

    public ?string $sourcePath = '@npm/jquery';

    public array $js = [
        'dist/jquery.js',
    ];

    public array $publishOptions = [
        'only' => [
            'dist/jquery.js'
        ],
    ];
}
