<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Html\Html;

use function implode;
use function is_array;

/**
 * ButtonToolbar Combines sets of button groups into button toolbars for more complex components.
 * Use utility classes as needed to space out groups, buttons, and more.
 *
 * For example,
 *
 * ```php
 * // a button toolbar with items configuration
 * echo ButtonToolbar::widget()
 *     ->buttonGroups([
 *         [
 *             'buttons' => [
 *                 ['label' => '1', 'class' => ['btn-secondary']],
 *                 ['label' => '2', 'class' => ['btn-secondary']],
 *                 ['label' => '3', 'class' => ['btn-secondary']],
 *                 ['label' => '4', 'class' => ['btn-secondary']]
 *             ],
 *              'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '5', 'class' => ['btn-secondary']],
 *                 ['label' => '6', 'class' => ['btn-secondary']],
 *                 ['label' => '7', 'class' => ['btn-secondary']]
 *             ],
 *             'class' => ['mr-2']
 *         ],
 *         [
 *             'buttons' => [
 *                 ['label' => '8', 'class' => ['btn-secondary']]
 *             ]
 *         ]
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
final class ButtonToolbar extends Widget
{
    private bool $encodeTags = false;
    private array $buttonGroups = [];
    private array $options = [];

    protected function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button-toolbar";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'btn-toolbar']);

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'toolbar';
        }

        if ($this->encodeTags === false) {
            $this->options['encode'] = false;
        }

        return Html::div($this->renderButtonGroups(), $this->options);
    }

    /**
     * List of buttons groups. Each array element represents a single group which can be specified as a string or an
     * array of the following structure:
     *
     * - buttons: array list of buttons. Either as array or string representation
     * - options: array optional, the HTML attributes of the button group.
     * - encodeLabels: bool whether to HTML-encode the button labels.
     *
     * @param array $value
     *
     * @return $this
     */
    public function buttonGroups(array $value): self
    {
        $new = clone $this;
        $new->buttonGroups = $value;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
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
     * Generates the button groups that compound the toolbar as specified on {@see buttonGroups}.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    private function renderButtonGroups(): string
    {
        $buttonGroups = [];

        foreach ($this->buttonGroups as $group) {
            if (is_array($group)) {
                if (!isset($group['buttons'])) {
                    continue;
                }

                $options = ArrayHelper::getValue($group, 'options', []);
                $buttonGroups[] = ButtonGroup::widget()
                    ->buttons($group['buttons'])
                    ->options($options)
                    ->render();
            } else {
                $buttonGroups[] = $group;
            }
        }

        return implode("\n", $buttonGroups);
    }
}
