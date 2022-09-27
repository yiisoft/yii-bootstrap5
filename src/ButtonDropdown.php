<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\InvalidConfigException;
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
final class ButtonDropdown extends Widget
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
    /** @psalm-var non-empty-string */
    private string $tagName = 'button';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    /** @psalm-var class-string */
    private string $dropdownClass = Dropdown::class;
    private bool $renderContainer = true;

    protected function run(): string
    {
        if (!isset($this->dropdown['items'])) {
            return '';
        }

        /** Set options id to button options id to ensure correct css selector in plugin initialisation */
        if (empty($this->options['id'])) {
            $id = $this->getId();

            $this->options['id'] = "{$id}-button-dropdown";
            $this->buttonOptions['id'] = "{$id}-button";
        }

        $html = $this->renderButton() . "\n" . $this->renderDropdown();

        if ($this->renderContainer) {
            /** @psalm-suppress InvalidArgument */
            Html::addCssClass($this->options, ['widget' => 'drop' . $this->direction, 'btn-group']);

            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'div');
            $html = Html::tag($tag, $html, $options)
                ->encode($this->encodeTags)
                ->render();
        }

        return $html;
    }

    /**
     * The HTML attributes of the button.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     */
    public function buttonOptions(array $value): self
    {
        $new = clone $this;
        $new->buttonOptions = $value;

        return $new;
    }

    /**
     * The drop-direction of the widget.
     *
     * Possible values are 'left', 'right', 'up', or 'down' (default)
     *
     * @param string $value
     */
    public function direction(string $value): self
    {
        $new = clone $this;
        $new->direction = $value;

        return $new;
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
     */
    public function dropdown(array $value): self
    {
        $new = clone $this;
        $new->dropdown = $value;

        return $new;
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     *
     * @psalm-param class-string $value
     */
    public function dropdownClass(string $value): self
    {
        $new = clone $this;
        $new->dropdownClass = $value;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * The button label.
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Whether to render the container using the {@see options} as HTML attributes. If set to `false`, the container
     * element enclosing the button and dropdown will NOT be rendered.
     */
    public function withoutRenderContainer(): self
    {
        $new = clone $this;
        $new->renderContainer = false;

        return $new;
    }

    /**
     * Whether to display a group of split-styled button group.
     */
    public function split(): self
    {
        $new = clone $this;
        $new->split = true;

        return $new;
    }

    /**
     * The tag to use to render the button.
     *
     * @psalm-param non-empty-string $value
     */
    public function tagName(string $value): self
    {
        $new = clone $this;
        $new->tagName = $value;

        return $new;
    }

    /**
     * Generates the button dropdown.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    private function renderButton(): string
    {
        Html::addCssClass($this->buttonOptions, ['buttonOptions' => 'btn']);

        $label = $this->label;

        if ($this->encodeLabels !== false) {
            $label = Html::encode($label);
        }

        $buttonOptions = $this->buttonOptions;

        if ($this->split) {
            $this->buttonOptions['data-bs-toggle'] = 'dropdown';
            $this->buttonOptions['aria-haspopup'] = 'true';
            $this->buttonOptions['aria-expanded'] = 'false';

            Html::addCssClass($this->buttonOptions, ['toggle' => 'dropdown-toggle dropdown-toggle-split']);

            unset($buttonOptions['id']);

            $splitButton = Button::widget()
                ->label('<span class="sr-only">Toggle Dropdown</span>')
                ->options($this->buttonOptions)
                ->withoutEncodeLabels()
                ->render();
        } else {
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

        $button = Button::widget()
            ->label($label)
            ->options($buttonOptions)
            ->tagName($this->tagName);

        if ($this->encodeLabels === false) {
            $button = $button->withoutEncodeLabels();
        }

        return $button->render() . "\n" . $splitButton;
    }

    /**
     * Generates the dropdown menu.
     *
     * @return string the rendering result.
     */
    private function renderDropdown(): string
    {
        $dropdownClass = $this->dropdownClass;

        $dropdown = $dropdownClass::widget()->items($this->dropdown['items']);

        if ($this->encodeLabels === false) {
            $dropdown = $dropdown->withoutEncodeLabels();
        }

        return $dropdown->render();
    }
}
