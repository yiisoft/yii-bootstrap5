<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()
 *     options([
 *         'class' => 'alert-info',
 *     ])
 *     ->body('Say hello...');
 * ```
 */
class Alert extends Widget
{
    /**
     * @var string the body content in the alert component. Alert widget will also be treated as the body content, and
     *             will be rendered before this.
     */
    private $body;

    /**
     * @var array the options for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If this is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Alert documentation](http://getbootstrap.com/components/#alerts)
     * for the supported HTML attributes.
     */
    private $closeButton = [];

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private $options = [];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function getContent(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-alert";
        }

        $this->initOptions();

        echo Html::beginTag('div', $this->options) . "\n";

        $this->registerPlugin('alert', $this->options);

        echo "\n" . $this->renderBodyEnd();

        return "\n" . Html::endTag('div');
    }

    /**
     * Renders the alert body and the close button (if any).
     *
     * @return string the rendering result
     */
    protected function renderBodyEnd(): string
    {
        return $this->body . "\n" .  $this->renderCloseButton() . "\n";
    }

    /**
     * Renders the close button.
     *
     * @return string the rendering result
     */
    protected function renderCloseButton(): string
    {
        if ((!empty($this->closeButton))) {
            $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
            $label = ArrayHelper::remove($this->closeButton, 'label', Html::tag('span', '&times;', [
                'aria-hidden' => 'true'
            ]));

            if ($tag === 'button' && !isset($this->closeButton['type'])) {
                $this->closeButton['type'] = 'button';
            }

            return Html::tag($tag, $label, $this->closeButton);
        } else {
            return null;
        }
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     *
     * @return void
     */
    protected function initOptions(): void
    {
        Html::addCssClass($this->options, ['widget' => 'alert']);

        if (empty($this->closeButton)) {
            $this->closeButton = [
                'data-dismiss' => 'alert',
                'class' => ['widget' => 'close'],
            ];

            Html::addCssClass($this->options, ['alert-dismissible']);
        }

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'alert';
        }
    }

    public function __toString(): string
    {
        return $this->run();
    }

    /**
     * {@see body}
     *
     * @param array $body
     *
     * @return $this
     */
    public function body(string $value): self
    {
        $this->body = $value;

        return $this;
    }

    /**
     * {@see closeButton}
     *
     * @param array $closeButton
     *
     * @return $this
     */
    public function closeButton(string $value): self
    {
        $this->closeButton = $value;

        return $this;
    }

    /**
     * {@see options}
     *
     * @param array $options
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }
}
