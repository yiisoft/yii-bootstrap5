<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Span;

/**
 * `NavBar` renders a navbar HTML component.
 *
 * Any content enclosed between the {@see begin()} and {@see end()} calls of NavBar is treated as the content of the
 * navbar. You may use widgets such as {@see Nav} or {@see \Yiisoft\Widget\Menu} to build up such content. For example,
 *
 * ```php
 * echo NavBar::widget()
 *     ->addClass(BackgroundColor::BODY_TERTIARY)
 *     ->brandText('NavBar')
 *     ->brandUrl('#')
 *     ->id('navbarSupportedContent')
 *     ->begin();
 *     echo Nav::widget()
 *         ->items(
 *             NavLink::item('Home', '#', active: true),
 *             NavLink::item(label: 'Link', url: '#'),
 *             Dropdown::widget()
 *                  ->items(
 *                      DropdownItem::link('Action', '#'),
 *                      DropdownItem::link('Another action', '#'),
 *                      DropdownItem::divider(),
 *                      DropdownItem::link('Something else here', '#'),
 *                  ),
 *             NavLink::item('Disabled', '#', disabled: true),
 *         )
 *         ->styles(NavStyle::NAVBAR)
 *        ->render();
 * echo NavBar::end();
 * ```
 */
final class NavBar extends \Yiisoft\Widget\Widget
{
    private const NAME = 'navbar';
    private const NAVBAR_BRAND = 'navbar-brand mb-0 h1';
    private const NAVBAR_BRAND_LINK = 'navbar-brand';
    private const NAV_CONTAINER = 'collapse navbar-collapse';
    private const NAV_INNER_CONTAINER = 'container-fluid';
    private const NAV_TOGGLE = 'navbar-toggler';
    private const NAV_TOGGLE_ICON = 'navbar-toggler-icon';
    private array $attributes = [];
    private string|Stringable $brand = '';
    private array $brandAttributes = [];
    private string $brandText = '';
    private string|Stringable $brandImage = '';
    private array $brandImageAttributes = [];
    private string $brandUrl = '';
    private array $cssClass = [];
    private bool $container = false;
    private array $containerAttributes = [];
    private NavBarExpand $expand = NavBarExpand::LG;
    private bool $innerContainer = true;
    private array $innerContainerAttributes = [];
    private string $innerContainerTag = 'div';
    private bool|string $id = true;
    private string $tag = 'nav';
    private string $toggle = '';

    /**
     * Adds a set of attributes for the navbar component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-collapse']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$values];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes of the navbar component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $carousel->addClass('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = [...$this->cssClass, ...$value];

        return $new;
    }

    /**
     * Adds a CSS style for the navbar component.
     *
     * @param array|string $value The CSS style for the navbar component. If an array, the values will be separated by
     * a space. If a string, it will be added as is. For example, 'color: red;'. If the value is an array, the values
     * will be separated by a space. e.g., ['color' => 'red', 'font-weight' => 'bold'] will be rendered as
     * 'color: red; font-weight: bold;'.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $value, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $value, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes for the navbar component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Sets the brand image for the navbar component.
     *
     * @param string|Stringable|null $value The brand image for the navbar component. If `null`, the brand image will not
     * be displayed.
     *
     * @return self A new instance with the specified brand image.
     */
    public function brandImage(string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->brandImage = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the brand image of the navbar component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function brandImageAttributes(array $values): self
    {
        $new = clone $this;
        $new->brandImageAttributes = $values;

        return $new;
    }

    /**
     * Sets the brand text for the navbar component.
     *
     * @param string|Stringable|null $value The brand text for the navbar component. If `null`, the brand text will not
     * be displayed.
     *
     * @return self A new instance with the specified brand text.
     */
    public function brandText(string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->brandText = $value;

        return $new;
    }

    /**
     * Sets the brand URL for the navbar component.
     *
     * @param string|Stringable|null $value The brand URL for the navbar component. If `null`, the brand URL will not be
     * displayed.
     *
     * @return self A new instance with the specified brand URL.
     */
    public function brandUrl(string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->brandUrl = $value;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the navbar component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$value One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $carousel->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$value): self
    {
        $new = clone $this;
        $new->cssClass = $value;

        return $new;
    }

    /**
     * Sets whether the navbar contains navigation content in a container.
     *
     * @param bool $value Whether to use container for navigation content.
     * If `true` navigation content will be wrapped in a container.
     * If `false` navigation content will span full width.
     *
     * @return self A new instance with the specified container setting.
     */
    public function container(bool $value): self
    {
        $new = clone $this;
        $new->container = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the container of the navbar component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function containerAttributes(array $values): self
    {
        $new = clone $this;
        $new->containerAttributes = $values;

        return $new;
    }

    /**
     * Sets the expansion breakpoint class for the navigation bar.
     *
     * @param NavBarExpand $value The breakpoint class at which the navbar will expand.
     *
     * @return self A new instance with the specified expansion breakpoint.
     */
    public function expand(NavBarExpand $value): self
    {
        $new = clone $this;
        $new->expand = $value;

        return $new;
    }

    /**
     * Sets the ID of the navbar component.
     *
     * @param bool|string $value The ID of the alert component. If `true`, an ID will be generated automatically.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Whether to use an inner container for the navbar component.
     *
     * @param bool $value 'true' to use an inner container for the navbar component, 'false' otherwise. Defaults to
     * 'true'.
     *
     * @return self A new instance with the specified inner container setting.
     */
    public function innerContainer(bool $value): self
    {
        $new = clone $this;
        $new->innerContainer = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the inner container of the navbar component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function innerContainerAttributes(array $values): self
    {
        $new = clone $this;
        $new->innerContainerAttributes = $values;

        return $new;
    }

    public function placement(NavBarPlacement $value): self
    {
        return $this->addClass($value);
    }

    /**
     * Sets the tag name for the navbar component.
     *
     * @param string $value The tag name for the navbar component.
     *
     * @return self A new instance with the specified tag name.
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;

        return $new;
    }

    /**
     * Sets the theme for the navbar component.
     *
     * @param string $value The theme for the navbar component.
     *
     * @return self A new instance with the specified theme.
     */
    public function theme(string $value): self
    {
        return $this->addAttributes(['data-bs-theme' => $value === '' ? null : $value]);
    }

    /**
     * Begins the rendering of the navbar.
     *
     * @throws InvalidArgumentException if the tag is an empty string.
     *
     * @return string The opening HTML tags for the navbar.
     */
    public function begin(): string
    {
        parent::begin();

        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;
        $htmlBegin = '';
        $innerContainerAttributes = $this->innerContainerAttributes;
        $innerContainerClasses = $innerContainerAttributes['class'] ?? null;

        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->id,
        };

        unset($attributes['class'], $attributes['id'], $innerContainerAttributes['class']);

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag cannot be empty string.');
        }

        Html::addCssClass($attributes, [self::NAME, $this->expand, $classes, ...$this->cssClass]);

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag cannot be empty string.');
        }

        if ($this->container) {
            $htmlBegin = Html::openTag('div', $this->containerAttributes) . "\n";
        }

        $htmlBegin .= Html::openTag($this->tag, $attributes) . "\n";

        if ($this->innerContainer) {
            Html::addCssClass($innerContainerAttributes, [$innerContainerClasses ?? self::NAV_INNER_CONTAINER]);

            $htmlBegin .= Html::openTag($this->innerContainerTag, $innerContainerAttributes) . "\n";
        }

        $renderBrand = $this->renderBrand();

        if ($renderBrand !== '') {
            $htmlBegin .= $renderBrand . "\n";
        }

        $htmlBegin .= $this->renderToggle($id) . "\n";

        $htmlBegin .= Html::openTag('div', ['class' => self::NAV_CONTAINER, 'id' => $id]);

        return $htmlBegin . "\n";
    }

    /**
     * Run the navbar widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $htmlRender = '';

        if ($this->innerContainer) {
            $htmlRender .= "\n" . Html::closeTag($this->innerContainerTag) . "\n";
        }

        $htmlRender .= Html::closeTag('div') . "\n";
        $htmlRender .= Html::closeTag($this->tag);

        if ($this->container) {
            $htmlRender .= "\n" . Html::closeTag('div');
        }

        return $htmlRender;
    }

    /**
     * Renders the brand section of the navbar.
     *
     * @return string The rendered brand HTML.
     */
    private function renderBrand(): string
    {
        if ($this->brand instanceof Stringable) {
            return (string) $this->brand;
        }

        if ($this->brandImage === null && $this->brandText === null) {
            return '';
        }

        $content = '';

        if ($this->brandImage instanceof Stringable) {
            $content = "\n" . $this->brandImage . "\n";
        } elseif ($this->brandImage !== '') {
            $content = "\n" . Html::img($this->brandImage)->addAttributes($this->brandImageAttributes) . "\n";
        }

        if ($this->brandText !== '') {
            $content .= $this->brandText;
        }

        if ($this->brandUrl !== '' && $this->brandImage !== '' && $this->brandText !== '') {
            $content .= "\n";
        }

        if ($content === '') {
            return '';
        }

        $brandAttributes = $this->brandAttributes;
        $classesBrand = $brandAttributes['class'] ?? null;

        unset($brandAttributes['class']);

        $brand = match ($this->brandUrl) {
            '' => Html::span($content, $brandAttributes)
                ->addClass(self::NAVBAR_BRAND, $classesBrand)
                ->encode(false),
            default => Html::a($content, $this->brandUrl, $brandAttributes)
                ->addClass(self::NAVBAR_BRAND_LINK, $classesBrand)
                ->encode(false),
        };

        return $brand->render();
    }

    /**
     * Renders the toggle button for the navbar.
     *
     * @param string $id The ID of the collapsible element.
     *
     * @return string The rendered toggle button HTML.
     */
    private function renderToggle(string $id): string
    {
        if ($this->toggle !== '') {
            return (string) $this->toggle;
        }

        return Button::button('')
            ->addClass(self::NAV_TOGGLE)
            ->addAttributes(
                [
                    'data-bs-toggle' => 'collapse',
                    'data-bs-target' => '#' . $id,
                    'aria-controls' => $id,
                    'aria-expanded' => 'false',
                    'aria-label' => 'Toggle navigation',
                ],
            )
            ->addContent("\n", Span::tag()->addClass(self::NAV_TOGGLE_ICON), "\n")
            ->encode(false)
            ->render();
    }
}
