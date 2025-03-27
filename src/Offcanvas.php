<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Bootstrap5\Utility\Responsive;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

/**
 * Offcanvas renders a Bootstrap offcanvas component.
 *
 * For example,
 * ```php
 * echo Offcanvas::widget()
 *     ->placement(OffcanvasPlacement::END)
 *     ->title('Offcanvas Title')
 *     ->togglerContent('Toggle Offcanvas')
 *     ->begin();
 *
 * // content of the offcanvas
 * echo 'Offcanvas content here';
 * echo Offcanvas::end();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#how-it-works
 */
final class Offcanvas extends Widget
{
    private const NAME = 'offcanvas';
    private const BODY_CLASS = 'offcanvas-body';
    private const CLOSE_CLASS = 'btn-close';
    private const HEADER_CLASS = 'offcanvas-header';
    private const SHOW_CLASS = 'show';
    private const TITLE_CLASS = 'offcanvas-title';
    private const TOGGLER_CLASS = 'btn btn-primary';

    private array $attributes = [];
    private bool $backdrop = false;
    private bool $backdropStatic = false;
    private array $bodyAttributes = [];
    private array $cssClasses = [];
    private array $headerAttributes = [];
    private array $titleAttributes = [];
    private array $togglerAttributes = [];
    private bool $scrollable = false;
    private bool|string $id = true;
    private OffcanvasPlacement|string $placement = OffcanvasPlacement::START;
    private string $responsive = '';
    private bool $show = false;
    private string|Stringable $title = '';
    private string|Stringable $togglerContent = '';

    /**
     * Adds a set of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-offcanvas']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
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
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style.
     *
     * @param array|string $style The CSS style. If an array is provided, the values will be separated by a space. If a
     * string is provided, it will be added as is. For example, `color: red`. If the value is an array, the values will
     * be separated by a space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as
     * `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the HTML attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets whether to use a backdrop.
     *
     * @return self A new instance with the specified backdrop setting.
     *
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#body-scrolling-and-backdrop
     */
    public function backdrop(): self
    {
        $new = clone $this;
        $new->backdrop = true;

        return $new;
    }

    /**
     * Sets whether to use a static backdrop.
     *
     * @return self A new instance with the specified static backdrop setting.
     *
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#dark-offcanvas
     */
    public function backdropStatic(): self
    {
        $new = clone $this;
        $new->backdropStatic = true;

        return $new;
    }

    /**
     * Sets the HTML attributes for the body.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified body attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function bodyAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->bodyAttributes = $attributes;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $carousel->class('custom-class', null, 'another-class');
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the HTML attributes for the header.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified header attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the placement.
     *
     * @param OffcanvasPlacement|string $placement The placement.
     *
     * @return self A new instance with the specified placement setting.
     */
    public function placement(OffcanvasPlacement|string $placement): self
    {
        $new = clone $this;
        $new->placement = $placement;

        return $new;
    }

    /**
     * Sets the responsive size.
     *
     * @param Responsive $size The responsive size.
     *
     * @return self A new instance with the specified responsive size setting.
     */
    public function responsive(Responsive $size): self
    {
        $new = clone $this;
        $new->responsive = $size->value;

        return $new;
    }

    /**
     * Sets whether it is scrollable.
     *
     * @return self A new instance with the specified scrollable setting.
     *
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#body-scrolling
     */
    public function scrollable(): self
    {
        $new = clone $this;
        $new->scrollable = true;

        return $new;
    }

    /**
     * Sets whether it is visible.
     *
     * @return self A new instance with the specified visibility setting.
     */
    public function show(): self
    {
        $new = clone $this;
        $new->show = true;

        return $new;
    }

    /**
     * Sets the theme.
     *
     * @param string $theme The theme. If an empty string, the theme will be removed.
     * Valid values are `dark` and `light`.
     *
     * @return self A new instance with the specified theme.
     *
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#dark-offcanvas
     */
    public function theme(string $theme): self
    {
        return $this->addAttributes(['data-bs-theme' => $theme === '' ? null : $theme]);
    }

    /**
     * Sets the title.
     *
     * @param string|Stringable $title The title.
     *
     * @return self A new instance with the specified title.
     */
    public function title(string|Stringable $title): self
    {
        $new = clone $this;
        $new->title = $title;

        return $new;
    }

    /**
     * Sets the HTML attributes for the title.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified title attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function titleAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->titleAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML attributes for the toggler.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified toggler attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function togglerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the content of the toggler.
     *
     * @param string|Stringable $content The content of the toggler.
     *
     * @return self A new instance with the specified toggler content.
     */
    public function togglerContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->togglerContent = $content;

        return $new;
    }

    /**
     * Begins the rendering.
     *
     * @throws InvalidArgumentException if the tag is an empty string.
     *
     * @return string The opening HTML tags for the offcanvas.
     */
    public function begin(): string
    {
        parent::begin();

        $id = $this->getId();
        $html = '';

        if ($this->togglerContent !== '' && $this->show === false) {
            $html .= $this->renderToggler($id) . "\n";
        }

        $html .= $this->renderOffcanvas($id);

        return $html;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $html = Html::closeTag('div') . "\n";
        $html .= Html::closeTag('div');

        return $html;
    }

    /**
     * Generates the ID.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return string The generated ID.
     */
    private function getId(): string
    {
        return match ($this->id) {
            true => Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" must be specified.'),
            default => $this->id,
        };
    }

    /**
     * Renders the body.
     *
     * @return string The rendering result.
     */
    private function renderBody(): string
    {
        $bodyAttributes = $this->bodyAttributes;

        Html::addCssClass($bodyAttributes, [self::BODY_CLASS]);

        return Html::openTag('div', $bodyAttributes) . "\n";
    }

    /**
     * Renders the header.
     *
     * @param string $id The ID.
     *
     * @return string The rendering result.
     */
    private function renderHeader(string $id): string
    {
        $headerAttributes = $this->headerAttributes;

        Html::addCssClass($headerAttributes, [self::HEADER_CLASS]);

        $titleAttributes = $this->titleAttributes;
        $titleAttributes['id'] = $id . '-label';

        Html::addCssClass($titleAttributes, [self::TITLE_CLASS]);

        return Div::tag()
            ->attributes($headerAttributes)
            ->content(
                "\n",
                Html::tag('h5', $this->title, $titleAttributes),
                "\n",
                Button::tag()
                    ->attributes(
                        [
                            'aria-label' => 'Close',
                            'class' => self::CLOSE_CLASS,
                            'data-bs-dismiss' => 'offcanvas',
                            'type' => 'button',
                        ],
                    ),
                "\n",
            )
            ->render();
    }

    /**
     * Renders the offcanvas component.
     *
     * @param string $id The ID.
     *
     * @return string The rendering result.
     */
    private function renderOffcanvas(string $id): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        $class = $this->responsive !== '' ? 'offcanvas-' . $this->responsive : self::NAME;

        Html::addCssClass($attributes, [$class, $this->placement, ...$this->cssClasses, $classes]);

        if ($this->scrollable) {
            $attributes['data-bs-scroll'] = 'true';

            if ($this->backdrop === false) {
                $attributes['data-bs-backdrop'] = 'false';
            }
        }

        if ($this->backdropStatic) {
            $attributes['data-bs-backdrop'] = 'static';
        }

        $attributes['aria-labelledby'] = $id . '-label';
        $attributes['id'] = $id;
        $attributes['tabindex'] = '-1';

        if ($this->show) {
            Html::addCssClass($attributes, self::SHOW_CLASS);
        }

        $html = Html::openTag('div', $attributes) . "\n";
        $html .= $this->renderHeader($id) . "\n";
        $html .= $this->renderBody();

        return $html;
    }

    /**
     * Renders the toggler.
     *
     * @param string $id The ID.
     *
     * @return string The rendering result.
     */
    private function renderToggler(string $id): string
    {
        return Button::tag()
            ->attributes($this->togglerAttributes)
            ->addAttributes(
                [
                    'aria-controls' => $id,
                    'class' => self::TOGGLER_CLASS,
                    'data-bs-toggle' => 'offcanvas',
                    'data-bs-target' => '#' . $id,
                ]
            )
            ->content($this->togglerContent)
            ->type('button')
            ->render();
    }
}
