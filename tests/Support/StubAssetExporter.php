<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests\Support;

use Yiisoft\Assets\AssetExporterInterface;

final class StubAssetExporter implements AssetExporterInterface
{
    private array $bundles = [];

    public function getBundles(): array
    {
        return $this->bundles;
    }

    public function export(array $assetBundles): void
    {
        $this->bundles = $assetBundles;
    }
}
