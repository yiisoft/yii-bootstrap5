<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px" alt="Yii">
    </a>
    <a href="https://getbootstrap.com/" target="_blank">
        <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" height="100px" alt="Bootstrap">
    </a>
    <h1 align="center">Yii Framework Twitter Bootstrap 5 Extension</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii-bootstrap5/v/stable.png)](https://packagist.org/packages/yiisoft/yii-bootstrap5)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii-bootstrap5/downloads.png)](https://packagist.org/packages/yiisoft/yii-bootstrap5)
[![Build status](https://github.com/yiisoft/yii-bootstrap5/workflows/build/badge.svg)](https://github.com/yiisoft/yii-bootstrap5/actions?query=workflow%3Abuild)
[![Code coverage](https://codecov.io/gh/yiisoft/yii-bootstrap5/graph/badge.svg?token=S8ISXCPS2A)](https://codecov.io/gh/yiisoft/yii-bootstrap5)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fyii-bootstrap5%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/yii-bootstrap5/master)
[![static analysis](https://github.com/yiisoft/yii-bootstrap5/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/yii-bootstrap5/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/yii-bootstrap5/coverage.svg)](https://shepherd.dev/github/yiisoft/yii-bootstrap5)

This [Yii Framework] extension encapsulates [Twitter Bootstrap 5] components
and plugins in terms of Yii widgets, and thus makes using Bootstrap components/plugins
in Yii applications extremely easy.

## Requirements

- PHP 8.1 or higher.

## Installation

The package could be installed with [Composer](https://getcomposer.org):

```shell
composer require yiisoft/yii-bootstrap5
```

## Install assets

There are several ways to install the assets, they are:

1. Using the [AssetPackagist](https://asset-packagist.org/) package manager.

    Add to composer.json the following:
    
    ```json
    {
        "require": {
            "npm-asset/bootstrap": "^5.3",
            "oomphinc/composer-installers-extender": "^2.0"
        },
        "extra": {
            "installer-types": [
                "npm-asset"
            ],
            "installer-paths": {
                "./node_modules/{$name}": [
                    "type:npm-asset"
                ]
            }
        },
        "repositories": [
            {
                "type": "composer",
                "url": "https://asset-packagist.org"
            }
        ]
    }
    ```
    
    Once the changes are made, you can install the assets using the following command:
    
    ```shell
    composer update
    ```

2. Using the [npm-asset](https://www.npmjs.com/) package manager.

    Run the following command at the root directory of your application.
    
    ```shell
    npm i bootstrap@5.3.1
    ```

## General usage

For example, the following single line of code in a view file would render a Bootstrap Progress plugin:

```php
<?= Yiisoft\Yii\Bootstrap5\Progress::widget()
    ->percent('60')
    ->label('test') ?>
```

## Documentation

- [Twitter Bootstrap 5.3](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- Guide: [English](docs/guide/en/README.md), [中国人](docs/guide/zh-CN/README.md), [日本語](docs/guide/ja/README.md), [Português - Brasil](docs/guide/pt-BR/README.md), [Español](docs/guide/es/README.md), [Русский](docs/guide/ru/README.md), [українська](docs/guide/ukr/README.md)
- [Internals](docs/internals.md)

If you need help or have a question, the [Yii Forum](https://forum.yiiframework.com/c/yii-3-0/63) is a good place for that.
You may also check out other [Yii Community Resources](https://www.yiiframework.com/community).

## License

The Yii Framework Twitter Bootstrap 5 Extension is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)

[Yii Framework]: https://www.yiiframework.com/
[Twitter Bootstrap 5]: https://getbootstrap.com/docs/5.3/getting-started/introduction/
