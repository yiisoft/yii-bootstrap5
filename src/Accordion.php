<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

use function array_key_exists;
use function implode;

/**
 * Accordion renders an accordion bootstrap JavaScript component.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget()
 *     ->items(
 *        AccordionItem::to('Accordion Item #1', 'This is the first item\'s accordion body.'),
 *        AccordionItem::to('Accordion Item #2', 'This is the second item\'s accordion body.'),
 *        AccordionItem::to('Accordion Item #3', 'This is the third item\'s accordion body.'),
 *    )
 *    ->render(),
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/accordion/
 */
final class Accordion extends Widget
{
    private const CLASS_BODY = 'accordion-body';
    private const CLASS_COLLAPSE = 'accordion-collapse collapse';
    private const CLASS_HEADER = 'accordion-header';
    private const CLASS_ITEM = 'accordion-item';
    private const CLASS_TOGGLE = 'accordion-button';
    private const CLASS_TOGGLE_ACTIVE = 'collapsed';
    private const NAME = 'accordion';
    private bool $alwaysOpen = false;
    private array $attributes = [];
    private array $bodyAttributes = [];
    private array $collapseAttributes = [];
    private array $cssClasses = [];
    private array $headerAttributes = [];
    private string $headerTag = 'h2';
    private bool|string $id = true;
    private array $items = [];
    private array $toggleAttributes = [];
    private string|null $toggleTag = null;

    /**
     * Adds a sets of attributes to the accordion component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-alert']`.
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
     * Adds one or more CSS classes to the existing classes of the accordion component.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$values One or more CSS class names to add. Pass `null` to skip adding a class.
     * For example:
     *
     * ```php
     * $accordion->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(BackedEnum|string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$values];

        return $new;
    }

    /**
     * Adds a CSS style for the accordion component.
     *
     * @param array|string $value The CSS style for the alert component. If an array, the values will be separated by
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
     * Sets the HTML attributes for the accordion component.
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
     * Sets whether the accordion should always allow multiple items to be open simultaneously.
     *
     * @param bool $value Whether the accordion should always be open.
     *
     * @return self A new instance with the updated alwaysOpen property.
     *
     * @see https://getbootstrap.com/docs/5.3/components/accordion/#always-open
     */
    public function alwaysOpen(bool $value = true): self
    {
        $new = clone $this;
        $new->alwaysOpen = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the accordion component in the body section.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function bodyAttributes(array $values): self
    {
        $new = clone $this;
        $new->bodyAttributes = $values;

        return $new;
    }

    /**
     * Replaces all existing CSS classes of the accordion component with the provided ones.
     *
     * Multiple classes can be added by passing them as separate arguments. `null` values are filtered out
     * automatically.
     *
     * @param BackedEnum|string|null ...$values One or more CSS class names to set. Pass `null` to skip setting a class.
     * For example:
     *
     * ```php
     * $accordion->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     *
     * @return self A new instance with the specified CSS classes set.
     */
    public function class(BackedEnum|string|null ...$values): self
    {
        $new = clone $this;
        $new->cssClasses = $values;

        return $new;
    }

    /**
     * Sets the HTML attributes for the accordion component in the collapse section.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function collapseAttributes(array $values): self
    {
        $new = clone $this;
        $new->collapseAttributes = $values;

        return $new;
    }

    /**
     * Sets whether the accordion should use the flush style.
     *
     * @param bool $value Whether to apply the flush style.
     *
     * @return self A new instance with the updated flush property.
     *
     * @see https://getbootstrap.com/docs/5.3/components/accordion/#flush
     */
    public function flush(bool $value = true): self
    {
        $new = clone $this;
        $new->cssClasses['flush'] = $value ? 'accordion-flush' : null;

        return $new;
    }

    /**
     * Sets the HTML attributes for the accordion component in the header section.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the header section of the accordion component.
     *
     * @param string $value The HTML tag name for the header section of the accordion component.
     *
     * @return self A new instance with the specified header tag.
     */
    public function headerTag(string $value): self
    {
        $new = clone $this;
        $new->headerTag = $value;

        return $new;
    }

    /**
     * Sets the items of the accordion component.
     *
     * @param AccordionItem ...$values The items of the accordion component.
     *
     * @return self A new instance with the specified items.
     */
    public function items(AccordionItem ...$values): self
    {
        $new = clone $this;
        $new->items = $values;

        return $new;
    }

    /**
     * Sets the ID of the accordion component.
     *
     * @param bool|string $value The ID of the alert component. If `true`, an ID will be generated automatically.
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
     * Sets the HTML attributes for the toggle in the accordion component.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified close button attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function toggleAttributes(array $value): self
    {
        $new = clone $this;
        $new->toggleAttributes = $value;
        return $new;
    }

    /**
     * Sets the HTML tag to be used for the toggle in the accordion component.
     *
     * @param string $value The HTML tag name for the close button.
     *
     * @return self A new instance with the specified close button tag.
     */
    public function toggleTag(string $value): self
    {
        $new = clone $this;
        $new->toggleTag = $value;

        return $new;
    }

    /**
     * Run the accordion widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->items === []) {
            return '';
        }

        /** @psalm-var non-empty-string $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.'),
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClasses]);

        return Div::tag()
            ->addAttributes($attributes)
            ->addContent(
                "\n",
                $this->renderItems($id),
                "\n",
            )
            ->id($id)
            ->encode(false)
            ->render();
    }

    /**
     * Renders the body of the accordion item.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $idParent The ID of the parent element.
     * @param string $idCollapse The ID of the collapse element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $idParent The ID of the parent element.
     * @psalm-param non-empty-string $idCollapse The ID of the collapse element.
     */
    private function renderBody(AccordionItem $accordionItem, string $idParent, string $idCollapse): string
    {
        $bodyAttributes = $this->bodyAttributes;
        $classesBodyAttributes = $bodyAttributes['class'] ?? null;

        $collapseAttributes = $this->collapseAttributes;
        $classesCollapseAttributes = $collapseAttributes['class'] ?? null;

        unset($bodyAttributes['class'], $collapseAttributes['class']);

        if ($this->alwaysOpen === false) {
            $collapseAttributes['data-bs-parent'] = '#' . $idParent;
        }

        return Div::tag()
            ->addAttributes($collapseAttributes)
            ->addClass(
                self::CLASS_COLLAPSE,
                $accordionItem->isActive() ? 'show' : null,
                $classesCollapseAttributes,
            )
            ->id($idCollapse)
            ->addContent(
                "\n",
                Div::tag()
                    ->addAttributes($bodyAttributes)
                    ->addClass(self::CLASS_BODY, $classesBodyAttributes)
                    ->addContent("\n", $accordionItem->getBody(), "\n")
                    ->encode(false)
                    ->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the header of the accordion item.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $idCollapse The ID of the collapse element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $idCollapse The ID of the collapse element.
     */
    private function renderHeader(AccordionItem $accordionItem, string $idCollapse): string
    {
        $headerAttributes = $this->headerAttributes;
        $classesHeaderAttributes = $headerAttributes['class'] ?? null;

        unset($headerAttributes['class']);

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('The "headerTag" property must be a non-empty string.');
        }

        return Html::tag($this->headerTag)
            ->addAttributes($headerAttributes)
            ->addClass(self::CLASS_HEADER, $classesHeaderAttributes)
            ->addContent(
                "\n",
                $this->renderToggle($accordionItem->getHeader(), $idCollapse, $accordionItem->isActive()),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the items of the accordion component.
     *
     * @param string $idParent The ID of the parent element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $idParent The ID of the parent element.
     */
    private function renderItems(string $idParent): string
    {
        $items = [];

        foreach ($this->items as $key => $item) {
            $items[] = $this->renderItem($item, $idParent);
        }

        return implode("\n", $items);
    }

    /**
     * Renders an accordion item.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $idParent The ID of the parent element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $idParent The ID of the parent element.
     */
    private function renderItem(AccordionItem $accordionItem, string $idParent): string
    {
        /** @psalm-var non-empty-string $idCollapse */
        $idCollapse = $accordionItem->getId();

        return Div::tag()->addClass(self::CLASS_ITEM)
            ->addContent(
                "\n",
                $this->renderHeader($accordionItem, $idCollapse),
                "\n",
                $this->renderBody($accordionItem, $idParent, $idCollapse),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the toggle of the accordion item.
     *
     * @param string $header The header of the item.
     * @param string $idCollpase The ID of the collapse element.
     * @param bool $active Whether the item is active.
     *
     * @throws InvalidArgumentException if the toggle tag is an empty string.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $idCollpase The ID of the collapse element.
     */
    private function renderToggle(string $header, string $idCollpase, bool $active): string
    {
        $toggleTag = match ($this->toggleTag) {
            null => Button::button(''),
            '' => throw new InvalidArgumentException('Toggle tag cannot be empty string.'),
            default => Html::tag($this->toggleTag),
        };

        $toggleAttributes = $this->toggleAttributes;
        $toggleClasses = $toggleAttributes['class'] ?? null;

        unset($toggleAttributes['class']);

        Html::addCssClass(
            $toggleAttributes,
            [self::CLASS_TOGGLE, $active === false ? self::CLASS_TOGGLE_ACTIVE : null, $toggleClasses],
        );

        if (array_key_exists('data-bs-toggle', $toggleAttributes) === false) {
            $toggleAttributes['data-bs-toggle'] = 'collapse';
        }

        if (array_key_exists('data-bs-target', $toggleAttributes) === false) {
            $toggleAttributes['data-bs-target'] = '#' . $idCollpase;
        }

        if (array_key_exists('aria-expanded', $toggleAttributes) === false) {
            $toggleAttributes['aria-expanded'] = $active ? 'true' : 'false';
        }

        if (array_key_exists('aria-controls', $toggleAttributes) === false) {
            $toggleAttributes['aria-controls'] = $idCollpase;
        }

        return $toggleTag->addAttributes($toggleAttributes)->addContent("\n", $header, "\n")->encode(false)->render();
    }
}
