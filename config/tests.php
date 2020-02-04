<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Asset\AssetConverter;
use Yiisoft\Asset\AssetManager;
use Yiisoft\EventDispatcher\Dispatcher;
use Yiisoft\EventDispatcher\Provider\Provider;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Log\Logger;
use Yiisoft\View\Theme;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

$tempDir = sys_get_temp_dir();

return [
    ContainerInterface::class => function (ContainerInterface $container) {
        return $container;
    },

    Aliases::class => [
        '@root' => dirname(__DIR__, 1),
        '@public' => '@root/tests/public',
        '@basePath' => '@public/assets',
        '@web'  => '/',
        '@converter' => '@public/assetconverter',
        '@npm' => '@root/node_modules',
        '@view' => '@public/view',
        '@testSourcePath' => '@public/assetsources'
    ],
];
