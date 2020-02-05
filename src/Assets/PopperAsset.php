<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4\Assets;

use Yiisoft\Assets\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * PopperAsset.
 *
 * @package Bootstrap4
 */
class PopperAsset extends AssetBundle
{
    public ?string $basePath = '@basePath';

    public ?string $baseUrl = '@web';

    public ?string $sourcePath = '@npm/popper.js/dist';

    public array $js = [
        'umd/popper.js',
    ];

    public array $publishOptions = [
        'only' => [
            'umd/popper.js'
        ],
    ];
}
