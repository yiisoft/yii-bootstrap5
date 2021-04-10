<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use RuntimeException;
use Yiisoft\Assets\Exception\InvalidConfigException;
use Yiisoft\Yii\Bootstrap5\Assets\BootstrapAsset;
use Yiisoft\Yii\Bootstrap5\Tests\Support\StubAssetExporter;

final class AssetTest extends TestCase
{
    /**
     * @return array
     */
    public function registerDataProvider(): array
    {
        return [
            [
                'Css',
                BootstrapAsset::class,
            ],
        ];
    }

    /**
     * @dataProvider registerDataProvider
     *
     * @param string $type
     * @param string $asset
     * @param string|null $depend
     *
     * @throws InvalidConfigException
     */
    public function testAssetRegister(string $type, string $asset, ?string $depend = null): void
    {
        $publisher = $this->assetManager->getPublisher();

        $bundle = new $asset();

        if ($depend !== null) {
            $depend = new $depend();
        }

        $exporter = new StubAssetExporter();
        try {
            $this->assetManager->export($exporter);
            throw new RuntimeException('Not empty.');
        } catch (RuntimeException $e) {
            self::assertSame('Not a single asset bundle was registered.', $e->getMessage());
        }

        $this->assetManager->register([$asset]);

        if ($type === 'Css') {
            if ($depend !== null) {
                $dependUrl = $publisher->getPublishedUrl($depend->sourcePath) . '/' . $depend->css[0];
                self::assertEquals($dependUrl, $this->assetManager->getCssFiles()[$dependUrl]['url']);
            } else {
                $bundleUrl = $publisher->getPublishedUrl($bundle->sourcePath) . '/' . $bundle->css[0];
                self::assertEquals($bundleUrl, $this->assetManager->getCssFiles()[$bundleUrl]['url']);
            }
        }

        if ($type === 'Js') {
            if ($depend !== null) {
                $dependUrl = $publisher->getPublishedUrl($depend->sourcePath) . '/' . $depend->js[0];
                self::assertEquals($dependUrl, $this->assetManager->getJsFiles()[$dependUrl]['url']);
            } else {
                $bundleUrl = $publisher->getPublishedUrl($bundle->sourcePath) . '/' . $bundle->js[0];
                self::assertEquals($bundleUrl, $this->assetManager->getJsFiles()[$bundleUrl]['url']);
            }
        }
    }
}
