<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Assets\AssetLoader;
use Yiisoft\Assets\AssetLoaderInterface;
use function closedir;
use function is_dir;
use function opendir;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use function readdir;
use RuntimeException;
use function str_replace;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetConverter;
use Yiisoft\Assets\AssetConverterInterface;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Assets\AssetPublisher;

use Yiisoft\Assets\AssetPublisherInterface;
use Yiisoft\Di\Container;
use Yiisoft\Factory\Definition\Reference;
use Yiisoft\Files\FileHelper;
use Yiisoft\Widget\WidgetFactory;

abstract class TestCase extends BaseTestCase
{
    protected Aliases $aliases;
    protected AssetManager $assetManager;
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $this->container = new Container($this->config());

        $this->aliases = $this->container->get(Aliases::class);
        $this->assetManager = $this->container->get(AssetManager::class);

        WidgetFactory::initialize($this->container, []);
    }

    protected function tearDown(): void
    {
        $this->removeAssets('@assets');

        unset($this->aliases, $this->assetManager, $this->container);

        parent::tearDown();
    }

    /**
     * Asserting two strings equality ignoring line endings.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    protected function assertEqualsWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Asserting same ignoring slash.
     *
     * @param string $expected
     * @param string $actual
     */
    protected function assertSameIgnoringSlash(string $expected, string $actual): void
    {
        $expected = str_replace(['/', '\\'], '/', $expected);
        $actual = str_replace(['/', '\\'], '/', $actual);

        $this->assertSame($expected, $actual);
    }

    protected function removeAssets(string $basePath): void
    {
        $handle = opendir($dir = $this->aliases->get($basePath));
        if ($handle === false) {
            throw new RuntimeException("Unable to open directory: $dir");
        }
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..' || $file === '.gitignore') {
                continue;
            }

            $path = $dir . DIRECTORY_SEPARATOR . $file;

            if (is_dir($path)) {
                FileHelper::removeDirectory($path);
            } else {
                FileHelper::unlink($path);
            }
        }

        closedir($handle);
    }

    private function config(): array
    {
        return [
            Aliases::class => [
                'class' => Aliases::class,
                '__construct()' => [
                    [
                        '@root' => dirname(__DIR__),
                        '@public' => '@root/tests/public',
                        '@assets' => '@public/assets',
                        '@assetsUrl' => '/',
                        '@vendor' => '@root/vendor',
                        '@npm' => '@vendor/npm-asset',
                        '@view' => '@public/view',
                    ],
                ],
            ],

            LoggerInterface::class => NullLogger::class,

            AssetConverterInterface::class => AssetConverter::class,

            AssetPublisherInterface::class => AssetPublisher::class,

            AssetLoaderInterface::class => AssetLoader::class,

            AssetManager::class => [
                'class' => AssetManager::class,
                'setConverter()' => [Reference::to(AssetConverterInterface::class)],
                'setPublisher()' => [Reference::to(AssetPublisherInterface::class)],
            ],
        ];
    }
}
