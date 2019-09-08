<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Json\Json;
use Yiisoft\View\WebView;

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
    /**
     * @var array the options for the underlying Bootstrap JS plugin.
     *
     * Please refer to the corresponding Bootstrap plugin Web page for possible options.
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows how to use the "Modal" plugin and the
     * supported options (e.g. "remote").
     */
    public $clientOptions = [];

    /**
     * @var array the event handlers for the underlying Bootstrap JS plugin.
     *
     * Please refer to the corresponding Bootstrap plugin Web page for possible events.
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows how to use the "Modal" plugin and the
     * supported events (e.g. "shown").
     */
    public $clientEvents = [];

    /**
     * Initializes the widget.
     *
     * This method will register the bootstrap asset bundle. If you override this method,  make sure you call the parent
     * implementation first.
     */
    public function init(): void
    {
        parent::init();
    }

    /**
     * Registers a specific Bootstrap plugin and the related events.
     *
     * @param string $name the name of the Bootstrap plugin
     *
     * @return void
     */
    protected function registerPlugin(string $name, array $options = []): void
    {
        $view = $this->getView();

        BootstrapPluginAsset::register($view);

        $id = $options['id'];

        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }

    /**
     * Registers JS event handlers that are listed in {@see clientEvents}.
     */
    protected function registerClientEvents(): void
    {
        if (!empty($this->clientEvents)) {
            $id = $this->options['id'];
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }

    /**
     * @return \Yiisoft\View\WebView the WebView object that can be used to render views or view files.
     * {@see \Yiisoft\Widget\Widget::getView()}
     */
    abstract public function getView(): WebView;
}
