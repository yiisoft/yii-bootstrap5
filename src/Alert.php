<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()
 *     ->options([
 *         'class' => 'alert-info',
 *     ])
 *     ->body('Say hello...');
 * ```
 */
final class Alert extends Widget
{
    private string $body = '';
    private array $closeButton = [];
    private bool $closeButtonEnabled = true;
    private bool $encodeTags = false;
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-alert";
        }

        $this->initOptions();

        return Html::div($this->renderBodyEnd(), $this->options);
    }

    /**
     * The body content in the alert component. Alert widget will also be treated as the body content, and will be
     * rendered before this.
     *
     * @param string $value
     *
     * @return $this
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * The options for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see closeButtonEnabled} is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     *
     * Please refer to the [Alert documentation](http://getbootstrap.com/components/#alerts) for the supported HTML
     * attributes.
     *
     * @param array $value
     *
     * @return $this
     */
    public function closeButton(array $value): self
    {
        $new = clone $this;
        $new->closeButton = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @return $this
     */
    public function withoutCloseButton(): self
    {
        $new = clone $this;
        $new->closeButtonEnabled = false;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Renders the alert body and the close button (if any).
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        return $this->body . "\n" . $this->renderCloseButton() . "\n";
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    private function renderCloseButton(): ?string
    {
        if ($this->closeButtonEnabled === false) {
            return null;
        }

        $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
        $label = ArrayHelper::remove($this->closeButton, 'label', '');

        if ($tag === 'button' && !isset($this->closeButton['type'])) {
            $this->closeButton['type'] = 'button';
        }

        return Html::tag($tag, $label, $this->closeButton);
    }

    /**
     * Initializes the widget options.
     *
     * This method sets the default values for various options.
     */
    private function initOptions(): void
    {
        Html::addCssClass($this->options, ['widget' => 'alert']);

        if ($this->closeButtonEnabled !== false) {
            $this->closeButton = array_merge(
                $this->closeButton,
                [
                    'aria-label' => 'Close',
                    'data-bs-dismiss' => 'alert',
                ],
            );

            Html::addCssclass($this->closeButton, ['buttonOptions' => 'btn-close']);
            Html::addCssClass($this->options, ['alert-dismissible' => 'alert-dismissible']);
        }

        if ($this->encodeTags === false) {
            $this->closeButton['encode'] = false;
            $this->options['encode'] = false;
        }

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'alert';
        }
    }
}
