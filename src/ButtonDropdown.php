<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;

/**
 * ButtonDropdown renders a group or split button dropdown bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdown::widget()
 *     ->label('Action')
 *     ->dropdown'([
 *         'items' => [
 *             ['label' => 'DropdownA', 'url' => '/'],
 *             ['label' => 'DropdownB', 'url' => '#'],
 *         ],
 *     ]);
 * ```
 */
class ButtonDropdown extends Widget
{
    /**
     * The css class part of dropdown
     */
    public const DIRECTION_DOWN = 'down';

    /**
     * The css class part of dropleft
     */
    public const DIRECTION_LEFT = 'left';

    /**
     * The css class part of dropright
     */
    public const DIRECTION_RIGHT = 'right';

    /**
     * The css class part of dropup
     */
    public const DIRECTION_UP = 'up';

    /**
     * @var string the button label
     */
    private string $label = 'Button';

    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $options = [];

    /**
     * @var array the HTML attributes of the button.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private array $buttonOptions = [];

    /**
     * @var array the configuration array for {@see Dropdown}.
     */
    private array $dropdown = [];

    /**
     * @var string the drop-direction of the widget
     *
     * Possible values are 'left', 'right', 'up', or 'down' (default)
     */
    private string $direction = self::DIRECTION_DOWN;

    /**
     * @var bool whether to display a group of split-styled button group.
     */
    private bool $split = false;

    /**
     * @var string the tag to use to render the button
     */
    private string $tagName = 'button';

    /**
     * @var bool whether the label should be HTML-encoded.
     */
    private bool $encodeLabels = true;

    /**
     * @var string name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     */
    private string $dropdownClass = Dropdown::class;

    /**
     * @var bool whether to render the container using the {@see options} as HTML attributes. If set to `false`, the
     * container element enclosing the button and dropdown will NOT be rendered.
     */
    private bool $renderContainer = true;

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function run(): string
    {
        /* Set options id to button options id to ensure correct css selector in plugin initialisation */
        if (empty($this->options['id'])) {
            $id = $this->getId();

            $this->options['id'] = "{$id}-button-dropdown";
            $this->buttonOptions['id'] = "{$id}-button";
        }

        $html = $this->renderButton() . "\n" . $this->renderDropdown();

        if ($this->renderContainer) {
            Html::addCssClass($this->options, ['widget' => 'drop' . $this->direction, 'btn-group']);

            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'div');
            $html = Html::tag($tag, $html, $options);
        }

        $this->registerPlugin('dropdown', $this->options);

        return $html;
    }

    /**
     * Generates the button dropdown.
     *
     * @return string the rendering result.
     */
    protected function renderButton(): string
    {
        Html::addCssClass($this->buttonOptions, ['widget' => 'btn']);

        $label = $this->label;

        if ($this->encodeLabels) {
            $label = Html::encode($label);
        }

        if ($this->split) {
            $buttonOptions = $this->buttonOptions;

            $this->buttonOptions['data-toggle'] = 'dropdown';
            $this->buttonOptions['aria-haspopup'] = 'true';
            $this->buttonOptions['aria-expanded'] = 'false';

            Html::addCssClass($this->buttonOptions, ['toggle' => 'dropdown-toggle dropdown-toggle-split']);

            unset($buttonOptions['id']);

            $splitButton = Button::widget()
                ->label('<span class="sr-only">Toggle Dropdown</span>')
                ->encodeLabels(false)
                ->options($this->buttonOptions)
                ->run();
        } else {
            $buttonOptions = $this->buttonOptions;

            Html::addCssClass($buttonOptions, ['toggle' => 'dropdown-toggle']);

            $buttonOptions['data-toggle'] = 'dropdown';
            $buttonOptions['aria-haspopup'] = 'true';
            $buttonOptions['aria-expanded'] = 'false';
            $splitButton = '';
        }

        if (!isset($buttonOptions['href']) && ($this->tagName === 'a')) {
            $buttonOptions['href'] = '#';
            $buttonOptions['role'] = 'button';
        }

        return Button::widget()
                ->tagName($this->tagName)
                ->label($label)
                ->options($buttonOptions)
                ->encodeLabels(false)
                ->run()
                . "\n" . $splitButton;
    }

    /**
     * Generates the dropdown menu.
     *
     * @return string the rendering result.
     */
    protected function renderDropdown(): string
    {
        $config = $this->dropdown;

        /** @var Widget $dropdownClass */
        $dropdownClass = $this->dropdownClass;

        return $dropdownClass::widget()
            ->items($this->dropdown['items'])
            ->run();
    }

    /**
     * {@see $buttonOptions}
     *
     * @param array $value
     *
     * @return ButtonDropdown
     */
    public function buttonOptions(array $value): ButtonDropdown
    {
        $this->buttonOptions = $value;

        return $this;
    }

    /**
     * {@see $direction}
     *
     * @param string $value
     *
     * @return ButtonDropdown
     */
    public function direction(string $value): ButtonDropdown
    {
        $this->direction = $value;

        return $this;
    }

    /**
     * {@see $dropdown}
     *
     * @param array $value
     *
     * @return ButtonDropdown
     */
    public function dropdown(array $value): ButtonDropdown
    {
        $this->dropdown = $value;

        return $this;
    }

    /**
     * {@see $dropdownClass}
     *
     * @param string $value
     *
     * @return ButtonDropdown
     */
    public function dropdownClass(string $value): ButtonDropdown
    {
        $this->dropdownClass = $value;

        return $this;
    }

    /**
     * {@see $encodeLabel}
     *
     * @param bool $value
     *
     * @return ButtonDropdown
     */
    public function encodeLabels(bool $value): ButtonDropdown
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * {@see $label}
     *
     * @param string $value
     *
     * @return ButtonDropdown
     */
    public function label(string $value): ButtonDropdown
    {
        $this->label = $value;

        return $this;
    }

    /**
     * {@see $options}
     *
     * @param array $value
     *
     * @return ButtonDropdown
     */
    public function options(array $value): ButtonDropdown
    {
        $this->options = $value;

        return $this;
    }

    /**
     * {@see $renderContainer}
     *
     * @param bool $value
     *
     * @return ButtonDropdown
     */
    public function renderContainer(bool $value): ButtonDropdown
    {
        $this->renderContainer = $value;

        return $this;
    }

    /**
     * {@see $split}
     *
     * @param bool $value
     *
     * @return ButtonDropdown
     */
    public function split(bool $value): ButtonDropdown
    {
        $this->split = $value;

        return $this;
    }

    /**
     * {@see $tagName}
     *
     * @param string $value
     *
     * @return ButtonDropdown
     */
    public function tagName(string $value): ButtonDropdown
    {
        $this->tagName = $value;

        return $this;
    }
}
