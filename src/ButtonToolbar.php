<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

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
class ButtonToolbar extends Widget
{
    /**
     * @var array list of buttons groups. Each array element represents a single group which can be specified as a
     * string or an array of the following structure:
     *
     * - buttons: array list of buttons. Either as array or string representation
     * - options: array optional, the HTML attributes of the button group.
     * - encodeLabels: bool whether to HTML-encode the button labels.
     */
    private array $buttonGroups = [];

    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $options = [];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button-toolbar";
        }

        Html::addCssClass($this->options, ['widget' => 'btn-toolbar']);

        if (!isset($this->options['role'])) {
            $this->options['role'] = 'toolbar';
        }

        return Html::tag('div', $this->renderButtonGroups(), $this->options);
    }

    /**
     * Generates the button groups that compound the toolbar as specified on {@see buttonGroups}.
     *
     * @return string the rendering result.
     */
    protected function renderButtonGroups(): string
    {
        $buttonGroups = [];

        foreach ($this->buttonGroups as $group) {
            if (\is_array($group)) {

                if (!isset($group['buttons'])) {
                    continue;
                }

                $buttonGroups[] = ButtonGroup::widget()
                    ->buttons($group['buttons'])
                    ->options($group['options'])
                    ->run();
            } else {
                $buttonGroups[] = $group;
            }
        }

        return implode("\n", $buttonGroups);
    }

    /**
     * {@see $buttonGroups}
     *
     * @param array $value
     *
     * @return ButtonToolbar
     */
    public function buttonGroups(array $value): ButtonToolbar
    {
        $this->buttonGroups = $value;

        return $this;
    }

    /**
     * {@see $options}
     *
     * @param array $value
     *
     * @return ButtonToolbar
     */
    public function options(array $value): ButtonToolbar
    {
        $this->options = $value;

        return $this;
    }
}
