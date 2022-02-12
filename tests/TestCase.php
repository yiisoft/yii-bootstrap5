<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Widget\WidgetFactory;
use DOMDocument;

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

    private static function loadHtml(string $html): DOMDocument
    {
        $dom = new DOMDocument();
        $dom->recover = false;
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;
        $html = str_replace(["\r", "\n"], '', $html);

        if (defined('LIBXML_NOBLANKS')) {
            $dom->loadHtml($html, LIBXML_NOBLANKS);
        } else {
            $dom->loadHtml($html);
        }

        return $dom;
    }

    /**
     * Test two strings as HTML content
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return void
     */
    protected function assertEqualsHTML(string $expected, string $actual, string $message = ''): void
    {
        libxml_use_internal_errors(true);
        $expectedDOM = self::loadHtml($expected);
        $actualDOM = self::loadHtml($actual);
        $actualBody = $actualDOM->getElementsByTagName('body')->item(0);
        $expectedBody = $expectedDOM->getElementsByTagName('body')->item(0);

        $expected = $expectedDOM->saveHTML($expectedBody);
        $actual = $actualDOM->saveHTML($actualBody);

        libxml_clear_errors();

        $this->assertEquals($expectedBody->childNodes->count(), $actualBody->childNodes->count());
        $this->assertEquals($expected, $actual, $message);
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
}
