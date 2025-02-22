<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use Stringable;
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
 *     ->id('myCollapse')
 *     ->content('Collapse content')
 *     ->togglerContent('Toggle collapse')
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
    private bool $collapseContainer = true;
    private array $collapseContainerAttributes = [];
    private array $cssClasses = [];
    /** @var CollapseItem[] */
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
     * @param array|string $style The CSS style. If an array, the values will be separated by a space. If a string, it
     * will be added as is. For example, `color: red`. If the value is an array, the values will be separated by a
     * space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
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
    public function cardBodyAttributes(array $cardBodyAttributes): self
    {
        $new = clone $this;
        $new->cardBodyAttributes = $cardBodyAttributes;

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
     * @param bool $collapseContainer Whether to wrap the collapse items in a container.
     *
     * @return self A new instance with the specified container.
     *
     * Example usage:
     * ```php
     * $collapse->collapseContainer(true);
     * ```
     */
    public function collapseContainer(bool $collapseContainer): self
    {
        $new = clone $this;
        $new->collapseContainer = $collapseContainer;

        return $new;
    }

    /**
     * Sets the HTML attributes for the container of the collapse items.
     *
     * @param array collapseContainerAttributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the container of the collapse items.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $collapse->collapseContainerAttributes(['data-id' => '123']);
     * ```
     */
    public function collapseContainerAttributes(array $collapseContainerAttributes): self
    {
        $new = clone $this;
        $new->collapseContainerAttributes = $collapseContainerAttributes;

        return $new;
    }

    /**
     * Sets the items.
     *
     * @param CollapseItem ...$items The items.
     *
     * @return self A new instance with the specified items.
     *
     * Example usage:
     * ```php
     * $collapse->items(
     *     CollapseItem::widget('Item 1'),
     *     CollapseItem::widget()->content('Item 2'),
     * );
     * ```
     */
    public function items(CollapseItem ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the HTML attributes for the container of the toggler.
     *
     * @param array collapseContainerAttributes Attribute values indexed by attribute names.
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
    public function togglerContainerAttributes(array $togglerContainerAttributes): self
    {
        $new = clone $this;
        $new->togglerContainerAttributes = $togglerContainerAttributes;

        return $new;
    }

    public function render(): string
    {
        if ($this->items === []) {
            return '';
        }

        return Html::tag($this->togglerContainerTag)
            ->addAttributes($this->togglerContainerAttributes)
            ->addContent("\n", $this->renderCollapseItems())
            ->encode(false)
            ->render() .
            "\n" . $this->renderCollapse();
    }

    private function renderCollapse(): string
    {
        $collapseContent = count($this->items) > 1
            ? implode("\n", $this->renderCollapseContentMultiple())
            : $this->renderCollapseContent();

        return $this->collapseContainer
            ? Div::tag()
                ->addAttributes($this->collapseContainerAttributes)
                ->addContent()
                ->addContent("\n", $collapseContent, "\n")
                ->encode(false)
                ->render()
            : $collapseContent;
    }

    private function renderCollapseContent(): Stringable
    {
        $content = '';

        foreach ($this->items as $item) {
            $content = $item->getContent();
            $id = $item->getId();
        }

        return Div::tag()
            ->addAttributes($this->attributes)
            ->addClass(self::NAME, ...$this->cssClasses)
            ->addContent(
                "\n",
                Div::tag()
                    ->addAttributes($this->cardBodyAttributes)
                    ->addClass(self::CARD, self::CARD_BODY)
                    ->addContent(
                        "\n",
                        $content,
                        "\n",
                    ),
                "\n",
            )
            ->id($id);
    }

    private function renderCollapseContentMultiple(): array
    {
        $content = [];

        foreach ($this->items as $item) {
            if ($item->getTogglerMultiple() === false && $item->getContent() !== '') {
                $content[] = Div::tag()
                    ->addClass('col')
                    ->addContent(
                        "\n",
                        Div::tag()
                            ->addClass(self::NAME, self::COLLAPSE_MULTIPLE, ...$this->cssClasses)
                            ->addContent(
                                "\n",
                                Div::tag()
                                    ->addAttributes($this->cardBodyAttributes)
                                    ->addClass(self::CARD, self::CARD_BODY)
                                    ->addContent(
                                        "\n",
                                        $item->getContent(),
                                        "\n",
                                    ),
                                "\n",
                            )
                            ->id($item->getId()),
                        "\n",
                    );
            }
        }

        return $content;
    }

    public function renderCollapseItems(): string
    {
        $items = '';

        foreach ($this->items as $item) {
            $items .= $item->renderToggler();
        }

        return $items;
    }
}
