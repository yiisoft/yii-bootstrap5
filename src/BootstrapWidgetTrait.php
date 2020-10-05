<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Yii\Bootstrap5\Assets\BootstrapAsset;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Json\Json;

use function implode;

/**
 * BootstrapWidgetTrait is the trait, which provides basic for all bootstrap widgets features.
 *
 * Note: class, which uses this trait must declare public field named `options` with the array default value:
 *
 * ```php
 * class MyWidget extends \Yiisoft\Widget\Widget
 * {
 *     use BootstrapWidgetTrait;
 * }
 * ```
 *
 * This field is not present in the trait in order to avoid possible PHP Fatal error on definition conflict.
 */
trait BootstrapWidgetTrait
{
    private ?AssetManager $assetManager = null;
    private array $clientOptions = [];
    private array $clientEvents = [];
    private bool $enableClientOptions = false;
    private ?object $webView = null;

    /**
     * Registers a specific Bootstrap plugin and the related events.
     *
     * @param string $name the name of the Bootstrap plugin
     * @param array $options
     *
     * @throws JsonException
     *
     * @return void
     */
    protected function registerPlugin(string $name, array $options = []): void
    {
        $id = $options['id'];

        if ($this->assetManager !== null) {
            $this->assetManager->register([
                BootstrapAsset::class
            ]);
        }

        if ($this->enableClientOptions !== false) {
            $optionsString = Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($optionsString);";

            if ($this->webView !== null) {
                $this->webView->registerJs($js);
            }
        }

        $this->registerClientEvents($id);
    }

    /**
     * Registers JS event handlers that are listed in {@see clientEvents}.
     *
     * @param string $id
     */
    protected function registerClientEvents(string $id): void
    {
        if ($this->clientEvents) {
            $js = [];

            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }

            if ($this->webView !== null) {
                $this->webView->registerJs(implode("\n", $js));
            }
        }
    }

    public function assetManager(AssetManager $value): self
    {
        $this->assetManager = $value;

        return $this;
    }

    /**
     * The event handlers for the underlying Bootstrap JS plugin.
     *
     * Please refer to the corresponding Bootstrap plugin Web page for possible events.
     *
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows how to use the "Modal" plugin and the
     * supported events (e.g. "shown").
     *
     * @param array $value
     *
     * @return $this
     */
    public function clientEvents(array $value): self
    {
        $this->clientEvents = $value;

        return $this;
    }

    /**
     * The options for the underlying Bootstrap JS plugin.
     *
     * Please refer to the corresponding Bootstrap plugin Web page for possible options.
     *
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows how to use the "Modal" plugin and the
     * supported options (e.g. "remote").
     *
     * @param array $value
     *
     * @return $this
     */
    public function clientOptions(array $value): self
    {
        $this->clientOptions = $value;

        return $this;
    }

    public function getClientOptions(): array
    {
        return $this->clientOptions;
    }

    /**
     * Enable/Disable script Bootstrap JS plugin.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function enableClientOptions(bool $value): self
    {
        $this->enableClientOptions = $value;

        return $this;
    }

    public function getEnableClientOptions(): bool
    {
        return $this->enableClientOptions;
    }

    public function webView(object $value): self
    {
        $this->webView = $value;

        return $this;
    }
}
