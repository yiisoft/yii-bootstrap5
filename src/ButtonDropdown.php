<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Html\Html;

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

    private string $label = 'Button';
    private array $options = [];
    private array $buttonOptions = [];
    private array $dropdown = [];
    private string $direction = self::DIRECTION_DOWN;
    private bool $split = false;
    private string $tagName = 'button';
    private bool $encodeLabels = true;
    private string $dropdownClass = Dropdown::class;
    private bool $renderContainer = true;

    protected function run(): string
    {
        /** Set options id to button options id to ensure correct css selector in plugin initialisation */
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
     * @throws InvalidConfigException
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

            $this->buttonOptions['data-bs-toggle'] = 'dropdown';
            $this->buttonOptions['aria-haspopup'] = 'true';
            $this->buttonOptions['aria-expanded'] = 'false';

            Html::addCssClass($this->buttonOptions, ['toggle' => 'dropdown-toggle dropdown-toggle-split']);

            unset($buttonOptions['id']);

            $splitButton = Button::widget()
                ->label('<span class="sr-only">Toggle Dropdown</span>')
                ->encodeLabels(false)
                ->options($this->buttonOptions)
                ->render();
        } else {
            $buttonOptions = $this->buttonOptions;

            Html::addCssClass($buttonOptions, ['toggle' => 'dropdown-toggle']);

            $buttonOptions['data-bs-toggle'] = 'dropdown';
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
                ->render()
                . "\n" . $splitButton;
    }

    /**
     * Generates the dropdown menu.
     *
     * @return string the rendering result.
     */
    protected function renderDropdown(): string
    {
        $dropdownClass = $this->dropdownClass;

        return $dropdownClass::widget()
            ->items($this->dropdown['items'])
            ->render();
    }

    /**
     * The HTML attributes of the button.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function buttonOptions(array $value): self
    {
        $this->buttonOptions = $value;

        return $this;
    }

    /**
     * The drop-direction of the widget.
     *
     * Possible values are 'left', 'right', 'up', or 'down' (default)
     *
     * @param string $value
     *
     * @return $this
     */
    public function direction(string $value): self
    {
        $this->direction = $value;

        return $this;
    }

    /**
     * The configuration array for example:
     *
     * ```php
     *    [
     *        'items' => [
     *            ['label' => 'DropdownA', 'url' => '/'],
     *            ['label' => 'DropdownB', 'url' => '#'],
     *        ],
     *    ]
     * ```
     *
     * {@see Dropdown}
     *
     * @param array $value
     *
     * @return $this
     */
    public function dropdown(array $value): self
    {
        $this->dropdown = $value;

        return $this;
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     *
     * @param string $value
     *
     * @return $this
     */
    public function dropdownClass(string $value): self
    {
        $this->dropdownClass = $value;

        return $this;
    }

    /**
     * Whether the label should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * The button label.
     *
     * @param string $value
     *
     * @return $this
     */
    public function label(string $value): self
    {
        $this->label = $value;

        return $this;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * Whether to render the container using the {@see options} as HTML attributes. If set to `false`, the container
     * element enclosing the button and dropdown will NOT be rendered.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function renderContainer(bool $value): self
    {
        $this->renderContainer = $value;

        return $this;
    }

    /**
     * Whether to display a group of split-styled button group.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function split(bool $value): self
    {
        $this->split = $value;

        return $this;
    }

    /**
     * The tag to use to render the button.
     *
     * @param string $value
     *
     * @return $this
     */
    public function tagName(string $value): self
    {
        $this->tagName = $value;

        return $this;
    }
}
