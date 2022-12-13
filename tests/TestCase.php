<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Widget\WidgetFactory;

use function str_replace;

abstract class TestCase extends BaseTestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $this->container = new Container(ContainerConfig::create());
        $this->aliases = $this->container->get(Aliases::class);

        WidgetFactory::initialize($this->container, []);
    }

    protected function tearDown(): void
    {
        unset($this->container);

        parent::tearDown();
    }

    private static function loadHtml(string $html): string
    {
        $output = str_replace(["\r", "\n"], '', $html);
        $output = str_replace(['>', '</'], [">\n", "\n</"], $output);
        $output = str_replace("\n\n", "\n", $output);

        return trim($output);
    }

    /**
     * Test two strings as HTML content
     */
    protected function assertEqualsHTML(string $expected, string $actual, string $message = ''): void
    {
        $expected = self::loadHtml($expected);
        $actual = self::loadHtml($actual);

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Asserting two strings equality ignoring line endings.
     */
    protected function assertEqualsWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);

        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Asserting same ignoring slash.
     */
    protected function assertSameIgnoringSlash(string $expected, string $actual): void
    {
        $expected = str_replace(['/', '\\'], '/', $expected);
        $actual = str_replace(['/', '\\'], '/', $actual);

        $this->assertSame($expected, $actual);
    }
}
