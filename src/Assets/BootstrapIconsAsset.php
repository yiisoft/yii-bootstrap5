<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Assets;

use Yiisoft\Assets\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap-icons css file.
 *
 * BootstrapIconsAsset.
 *
 * @package Bootstrap5
 */
final class BootstrapIconsAsset extends AssetBundle
{
    public ?string $basePath = '@assets';

    public ?string $baseUrl = '@assetsUrl';

    public ?string $sourcePath = '@npm/bootstrap-icons/font';

    public array $css = [
        'bootstrap-icons.css',
    ];
}
