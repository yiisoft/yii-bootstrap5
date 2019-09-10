<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;
use yii\helpers\Url;

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
    const DIRECTION_DOWN = 'down';

    /**
     * The css class part of dropleft
     */
    const DIRECTION_LEFT = 'left';

    /**
     * The css class part of dropright
     */
    const DIRECTION_RIGHT = 'right';

    /**
     * The css class part of dropup
     */
    const DIRECTION_UP = 'up';

    /**
     * @var string the button label
     */
    private $label = 'Button';

    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private $options = [];

    /**
     * @var array the HTML attributes of the button.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private $buttonOptions = [];

    /**
     * @var array the configuration array for {@see Dropdown}.
     */
    private $dropdown = [];

    /**
     * @var string the drop-direction of the widget
     *
     * Possible values are 'left', 'right', 'up', or 'down' (default)
     */
    private $direction = self::DIRECTION_DOWN;

    /**
     * @var bool whether to display a group of split-styled button group.
     */
    private $split = false;

    /**
     * @var string the tag to use to render the button
     */
    private $tagName = 'button';

    /**
     * @var bool whether the label should be HTML-encoded.
     */
    private $encodeLabels = true;

    /**
     * @var string name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     */
    private $dropdownClass = Dropdown::class;

    /**
     * @var bool whether to render the container using the {@see options} as HTML attributes. If set to `false`, the
     *           container element enclosing the button and dropdown will NOT be rendered.
     */
    private $renderContainer = true;

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function getContent(): string
    {
        if (!isset($this->buttonOptions['id'])) {
            $this->buttonOptions['id'] = "{$this->getId()}-button";
        }

        // Set options id to button options id to ensure correct css selector in plugin initialisation
        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-button-dropdown";
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
                ->getContent();
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
                ->getContent()
                . "\n" . $splitButton;
    }

    /**
     * Generates the dropdown menu.
     *
     * @return Widget the rendering result.
     */
    protected function renderDropdown(): Widget
    {
        $config = $this->dropdown;

        /** @var Widget $dropdownClass */
        $dropdownClass = $this->dropdownClass;

        return $dropdownClass::widget()
            ->items($config['items']);
    }

    public function __toString(): string
    {
        return $this->run();
    }

    /**
     * {@see buttonOptions}
     *
     * @param array $buttonOptions
     *
     * @return $this
     */
    public function buttonOptions(array $value): self
    {
        $this->buttonOptions = $value;

        return $this;
    }

    /**
     * {@see direction}
     *
     * @param string $direction
     *
     * @return $this
     */
    public function direction(string $value): self
    {
        $this->direction = $value;

        return $this;
    }

    /**
     * {@see dropdown}
     *
     * @param array $dropdown
     *
     * @return $this
     */
    public function dropdown(array $value): self
    {
        $this->dropdown = $value;

        return $this;
    }

    /**
     * {@see dropdownClass}
     *
     * @param string $dropdownClass
     *
     * @return $this
     */
    public function dropdownClass(string $value): self
    {
        $this->dropdownClass = $value;

        return $this;
    }

    /**
     * {@see encodeLabel}
     *
     * @param bool $encodeLabel
     *
     * @return $this
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * {@see label}
     *
     * @param string $label
     *
     * @return $this
     */
    public function label(string $value): self
    {
        $this->label = $value;

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

    /**
     * {@see renderContainer}
     *
     * @param bool $renderContainer
     *
     * @return $this
     */
    public function renderContainer(bool $value): self
    {
        $this->renderContainer = $value;

        return $this;
    }

    /**
     * {@see split}
     *
     * @param bool $split
     *
     * @return $this
     */
    public function split(bool $value): self
    {
        $this->split = $value;

        return $this;
    }

    /**
     * {@see tagName}
     *
     * @param string $tagName
     *
     * @return $this
     */
    public function tagName(string $value): self
    {
        $this->tagName = $value;

        return $this;
    }
}
