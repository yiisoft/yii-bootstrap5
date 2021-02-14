<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Html\Html;

use function implode;
use function is_array;

/**
 * ButtonGroup renders a button group bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group with items configuration
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         ['label' => 'A'],
 *         ['label' => 'B'],
 *         ['label' => 'C', 'visible' => false],
 *     ]);
 *
 * // button group with an item as a string
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         Button::widget()->label('A'),
 *         ['label' => 'B'],
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
final class ButtonGroup extends Widget
{
    private array $buttons = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button-group";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn-group']);

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'group';
        }

        if ($this->encodeTags === false) {
            $this->options['encode'] = false;
        }

        return Html::div($this->renderButtons(), $this->options);
    }

    /**
     * List of buttons. Each array element represents a single button which can be specified as a string or an array of
     * the following structure:
     *
     * - label: string, required, the button label.
     * - options: array, optional, the HTML attributes of the button.
     * - visible: bool, optional, whether this button is visible. Defaults to true.
     *
     * @param array $value
     *
     * @return $this
     */
    public function buttons(array $value): self
    {
        $new = clone $this;
        $new->buttons = $value;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return $this
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

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
     * Generates the buttons that compound the group as specified on {@see buttons}.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    private function renderButtons(): string
    {
        $buttons = [];

        foreach ($this->buttons as $button) {
            if (is_array($button)) {
                $visible = ArrayHelper::remove($button, 'visible', true);

                if ($visible === false) {
                    continue;
                }

                if (!isset($button['encodeLabel'])) {
                    $button['encodeLabel'] = $this->encodeLabels;
                }

                if (!isset($button['options']['type'])) {
                    ArrayHelper::setValueByPath($button, 'options.type', 'button');
                }

                $buttonWidget = Button::widget()->label($button['label'])->options($button['options']);

                if ($button['encodeLabel'] === false) {
                    $buttonWidget = $buttonWidget->withoutEncodeLabels();
                }

                $buttons[] = $buttonWidget->render();
            } else {
                $buttons[] = $button;
            }
        }

        return implode("\n", $buttons);
    }
}
