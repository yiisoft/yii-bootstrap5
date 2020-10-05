<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Files\FileHelper;
use Yiisoft\Di\Container;
use Yiisoft\Widget\WidgetFactory;

use function closedir;
use function is_dir;
use function opendir;
use function readdir;
use function str_replace;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var Aliases $aliases
     */
    protected $aliases;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    protected function setUp(): void
    {
        $this->container = new Container([]);
        $this->aliases = new Aliases([
            '@root' => dirname(__DIR__, 1),
            '@public' => '@root/tests/public',
            '@basePath' => '@public/assets',
            '@baseUrl'  => '/',
            '@npm' => '@root/node_modules',
            '@view' => '@public/view',
        ]);

        WidgetFactory::initialize($this->container, []);
    }

    protected function tearDown(): void
    {
        $this->container = null;
        $this->removeAssets('@basePath');
        parent::tearDown();
    }

    /**
     * Asserting two strings equality ignoring line endings.
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return void
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
     *
     * @return void
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
}
