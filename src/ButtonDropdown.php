<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
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
 *     ->items([
*             ['label' => 'DropdownA', 'url' => '/'],
*             ['label' => 'DropdownB', 'url' => '#'],
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
    private ?array $labelOptions = null;
    private array $options = [];
    private array $buttonOptions = [];
    private array|string|Stringable $items = [];
    private string $direction = self::DIRECTION_DOWN;
    private bool $split = false;
    /** @psalm-var non-empty-string */
    private string $tagName = 'button';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    /** @psalm-var class-string|Dropdown */
    private string|Dropdown $dropdownClass = Dropdown::class;
    private bool $renderContainer = true;

    public function getId(?string $suffix = '-button-dropdown'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    public function render(): string
    {
        if (empty($this->items)) {
            return '';
        }

        if ($this->renderContainer) {
            $options = $this->options;
            $options['id'] = $this->getId();

            /** @psalm-suppress InvalidArgument */
            Html::addCssClass($options, ['widget' => 'drop' . $this->direction, 'btn-group']);

            if ($this->theme) {
                $options['data-bs-theme'] = $this->theme;
            }

            $tag = ArrayHelper::remove($options, 'tag', 'div');
            return Html::tag($tag, $this->renderButton() . "\n" . $this->renderDropdown(), $options)
                ->encode($this->encodeTags)
                ->render();
        }

        return $this->renderButton() . "\n" . $this->renderDropdown();
    }

    /**
     * The HTML attributes of the button.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     *            ['label' => 'DropdownA', 'url' => '/'],
     *            ['label' => 'DropdownB', 'url' => '#'],
     *    ]
     * ```
     *
     * {@see Dropdown}
     */
    public function items(array|string|Stringable $value): self
    {
        $new = clone $this;
        $new->items = $value;

        return $new;
    }

    /**
     * Name of a class to use for rendering dropdowns withing this widget. Defaults to {@see Dropdown}.
     *
     * @psalm-param class-string $value
     */
    public function dropdownClass(string|Dropdown $value): self
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

    public function withLabelOptions(?array $options): self
    {
        $new = clone $this;
        $new->labelOptions = $options;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
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

    private function prepareButtonOptions(bool $toggle): array
    {
        $options = $this->buttonOptions;
        $classNames = ['button' => 'btn'];

        if ($toggle) {
            $options['data-bs-toggle'] = 'dropdown';
            $options['aria-haspopup'] = 'true';
            $options['aria-expanded'] = 'false';
            $classNames['toggle'] = 'dropdown-toggle';
        }

        Html::addCssClass($options, $classNames);

        if ($this->tagName !== 'button') {
            $options['role'] = 'button';

            if ($this->tagName === 'a' && !isset($options['href'])) {
                $options['href'] = '#';
            }
        }

        return $options;
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
        $splitButton = $this->renderSplitButton();
        $options = $this->prepareButtonOptions($splitButton === null);
        $button = Button::widget()
            ->options($options)
            ->label($this->renderLabel())
            ->withTheme($this->renderContainer ? null : $this->theme)
            ->tagName($this->tagName);

        if ($this->encodeLabels === false) {
            $button = $button->withoutEncodeLabels();
        }

        return $button->render() . "\n" . $splitButton;
    }

    private function renderSplitButton(): ?string
    {
        if ($this->split === false) {
            return null;
        }

        $options = $this->prepareButtonOptions(true);
        Html::addCssClass($options, 'dropdown-toggle-split');

        return Button::widget()
            ->options($options)
            ->label('<span class="visually-hidden">Toggle Dropdown</span>')
            ->tagName($this->tagName)
            ->withoutEncodeLabels()
            ->withTheme($this->renderContainer ? null : $this->theme)
            ->render();
    }

    private function renderLabel(): string
    {
        if ($this->labelOptions === null) {
            return $this->encodeLabels ? Html::encode($this->label) : $this->label;
        }

        $options = $this->labelOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeLabels);

        return Html::tag($tag, $this->label, $options)
            ->encode($encode)
            ->render();
    }

    /**
     * Generates the dropdown menu.
     *
     * @return string
     * @throws InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     */
    private function renderDropdown(): string
    {
        if (is_string($this->dropdownClass)) {
            $dropdownClass = $this->dropdownClass;
            /** @var Dropdown $dropdownClass */
            $dropdown = $dropdownClass::widget()->items($this->items);
        } else {
            $dropdown = $this->dropdownClass->items($this->items);
        }

        if ($this->theme && !$this->renderContainer) {
            $dropdown = $dropdown->withTheme($this->theme);
        }

        if ($this->encodeLabels === false) {
            $dropdown = $dropdown->withoutEncodeLabels();
        }

        return $dropdown->render();
    }
}
