<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

use function implode;

/**
 * Collapse renders a Bootstrap collapse component.
 *
 * For example:
 *
 * ```php
 * echo Collapse::widget()
 *     ->containerAttributes(['class' => 'row'])
 *     ->items(
 *         Toggler::to(
 *             'Some placeholder content for the first collapse component of this multi-collapse example. ' .
 *             'This panel is hidden by default but revealed when the user activates the relevant trigger.',
 *             'multiCollapseExample1',
 *             togglerContent: 'Toggle first element',
 *             togglerAsLink: true,
 *         ),
 *         Toggler::to(
 *             'Some placeholder content for the second collapse component of this multi-collapse example. ' .
 *             'This panel is hidden by default but revealed when the user activates the relevant trigger.',
 *             'multiCollapseExample2',
 *             togglerContent: 'Toggle second element',
 *         ),
 *         Toggler::to(
 *             togglerContent: 'Toggle both elements',
 *             togglerMultiple: true,
 *             ariaControls: 'multiCollapseExample1 multiCollapseExample2',
 *       ),
 *     )
 *     ->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/collapse/
 */
final class Collapse extends Widget
{
    private const NAME = 'collapse';
    private const CARD = 'card';
    private const CARD_BODY = 'card-body';
    private const COLLAPSE_MULTIPLE = 'multi-collapse';
    private array $attributes = [];
    private array $cardBodyAttributes = [];
    private bool $container = true;
    private array $containerAttributes = [];
    private array $cssClasses = [];
    /** @var Toggler[] */
    private array $items = [];
    private string $togglerContainerTag = 'p';
    private array $togglerContainerAttributes = [];

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $collapse->addAttributes(['data-id' => '123']);
     * ```
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
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $collapse->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
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
     * @param array|string $style The CSS style. If it is an array, the values will be separated by a space. If it is a
     * string, it will be added as is. For example, `color: red`. If the value is an array, the values will be separated
     * by a space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as
     * `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $collapse->addCssStyle('color: red');
     *
     * // or
     * $collapse->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Adds a sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute added.
     *
     * Example usage:
     * ```php
     * $collapse->attribute('data-id', '123');
     * ```
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

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
     *
     * Example usage:
     * ```php
     * $collapse->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML attributes for the card body.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the card body.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $collapse->cardBodyAttributes(['data-id' => '123']);
     * ```
     */
    public function cardBodyAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->cardBodyAttributes = $attributes;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $collapse->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the container for the collapse items.
     *
     * @param bool $enabled Whether to wrap the collapse items in a container.
     *
     * @return self A new instance with the specified container.
     *
     * Example usage:
     * ```php
     * $collapse->container(true);
     * ```
     */
    public function container(bool $enabled): self
    {
        $new = clone $this;
        $new->container = $enabled;

        return $new;
    }

    /**
     * Sets the HTML attributes for the container of the collapse items.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the container of the collapse items.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $collapse->containerAttributes(['data-id' => '123']);
     * ```
     */
    public function containerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the items.
     *
     * @param Toggler ...$items The items.
     *
     * @return self A new instance with the specified items.
     *
     * Example usage:
     * ```php
     * $collapse->items(
     *     Toggler::widget('Item 1'),
     *     Toggler::widget()->content('Item 2'),
     * );
     * ```
     */
    public function items(Toggler ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the HTML attributes for the container of the toggler.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the container of the toggler.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $collapse->togglerContainerAttributes(['data-id' => '123']);
     * ```
     */
    public function togglerContainerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerContainerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the tag for the container of the toggler.
     *
     * @param string $tag The tag for the container of the toggler.
     *
     * @return self A new instance with the specified tag for the container of the toggler.
     *
     * Example usage:
     * ```php
     * $collapse->togglerContainerTag('div');
     * ```
     */
    public function togglerContainerTag(string $tag): self
    {
        $new = clone $this;
        $new->togglerContainerTag = $tag;

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        $collapse = [];
        $isMultiple = count($this->items) > 1;
        $toggler = [];

        foreach ($this->items as $item) {
            if ($item->getContent() !== '') {
                $collapseDiv = Div::tag()
                    ->addClass(self::NAME, ...$this->cssClasses)
                    ->addAttributes($this->attributes)
                    ->addContent(
                        "\n",
                        Div::tag()
                            ->addAttributes($this->cardBodyAttributes)
                            ->addClass(self::CARD, self::CARD_BODY)
                            ->addContent(
                                "\n",
                                $item->getContent(),
                                "\n"
                            ),
                        "\n"
                    )
                    ->id($item->getId());

                if ($isMultiple) {
                    $collapseDiv = $collapseDiv->addClass(self::COLLAPSE_MULTIPLE);

                    if ($item->getTogglerMultiple() === false) {
                        $collapse[] = Div::tag()->addClass('col')->addContent("\n", $collapseDiv, "\n");
                    }
                } else {
                    $collapse[] = $collapseDiv;
                }
            }

            $toggler[] = $item->renderToggler();
        }

        return $this->renderTogglerContainer($toggler) . "\n" . $this->renderCollapse($collapse);
    }

    /**
     * Renders the collapse.
     *
     * @param array $collapse The collapse.
     *
     * @return string The HTML representation of the element.
     */
    private function renderCollapse(array $collapse): string
    {
        $collapseContent = implode("\n", $collapse);

        return $this->container
            ? Div::tag()
                ->addAttributes($this->containerAttributes)
                ->addContent("\n", $collapseContent, "\n")
                ->encode(false)
                ->render()
            : $collapseContent;
    }

    /**
     * Renders the toggler container.
     *
     * @param array $toggler The toggler.
     *
     * @return string The HTML representation of the element.
     */
    private function renderTogglerContainer(array $toggler): string
    {
        if ($this->togglerContainerTag === '') {
            throw new InvalidArgumentException('Toggler container tag cannot be empty string.');
        }

        return Html::tag($this->togglerContainerTag)
            ->addAttributes($this->togglerContainerAttributes)
            ->addContent("\n", implode("\n", $toggler), "\n")
            ->encode(false)
            ->render();
    }
}
