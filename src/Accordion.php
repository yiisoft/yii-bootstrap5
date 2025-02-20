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
    private array $togglerAttributes = [];
    private string|null $togglerTag = null;

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $accordion->addAttributes(['id' => 'my-accordion']);
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
     * $accordion->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $accordion->addCssStyle('color: red');
     *
     * // or
     * $accordion->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
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
     * $accordion->attribute('id', 'my-id');
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
     * $accordion->attributes(['id' => 'my-accordion']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets whether should always allow multiple items to be open simultaneously.
     *
     * @param bool $enabled Whether should always be open.
     *
     * @return self A new instance with the updated alwaysOpen property.
     *
     * @see https://getbootstrap.com/docs/5.3/components/accordion/#always-open
     *
     * Example usage:
     * ```php
     * $accordion->alwaysOpen();
     * ```
     */
    public function alwaysOpen(bool $enabled = true): self
    {
        $new = clone $this;
        $new->alwaysOpen = $enabled;

        return $new;
    }

    /**
     * Sets the HTML attributes for the body section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the body section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $accordion->bodyAttributes(['id' => 'my-accordion-body']);
     * ```
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
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $accordion->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the HTML attributes for the collapse section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the collapse section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $accordion->collapseAttributes(['id' => 'my-accordion-collapse']);
     * ```
     */
    public function collapseAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->collapseAttributes = $attributes;

        return $new;
    }

    /**
     * Sets whether should use the flush style.
     *
     * @param bool $enabled Whether to apply the flush style.
     *
     * @return self A new instance with the updated CSS class for the flush style.
     *
     * @see https://getbootstrap.com/docs/5.3/components/accordion/#flush
     *
     * Example usage:
     * ```php
     * $accordion->flush();
     * ```
     */
    public function flush(bool $enabled = true): self
    {
        $new = clone $this;
        $new->cssClasses['flush'] = $enabled ? 'accordion-flush' : null;

        return $new;
    }

    /**
     * Sets the HTML attributes for the header section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the header section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $accordion->headerAttributes(['id' => 'my-accordion-header']);
     * ```
     */
    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the header section.
     *
     * @param string $tag The HTML tag name for the header section.
     *
     * @return self A new instance with the specified header tag.
     *
     * Example usage:
     * ```php
     * $accordion->headerTag('h3');
     * ```
     */
    public function headerTag(string $tag): self
    {
        $new = clone $this;
        $new->headerTag = $tag;

        return $new;
    }

    /**
     * Sets the items.
     *
     * @param AccordionItem ...$items The items.
     *
     * @return self A new instance with the specified items.
     *
     * Example usage:
     * ```php
     * $accordion->items(
     *     AccordionItem::to('Accordion Item #1', 'This is the first item\'s accordion body.'),
     *     AccordionItem::to('Accordion Item #2', 'This is the second item\'s accordion body.'),
     *     AccordionItem::to('Accordion Item #3', 'This is the third item\'s accordion body.'),
     * );
     * ```
     */
    public function items(AccordionItem ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
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
     * Sets the HTML attributes for the toggler.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the toggler.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $accordion->toggleAttributes(['id' => 'my-accordion-toggler']);
     * ```
     */
    public function togglerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the toggler.
     *
     * @param string $tag The HTML tag name for the toggler.
     *
     * @throws InvalidArgumentException if the tag is an empty string.
     *
     * @return self A new instance with the specified toggler tag.
     *
     * Example usage:
     * ```php
     * $accordion->toggleTag('button');
     * ```
     */
    public function togglerTag(string $tag): self
    {
        $new = clone $this;
        $new->togglerTag = $tag;

        return $new;
    }

    /**
     * Run the widget.
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

        $id = $this->getId();

        return Div::tag()
            ->addAttributes($attributes)
            ->addClass(self::NAME, $classes, ...$this->cssClasses)
            ->addContent("\n", $this->renderItems($id), "\n")
            ->id($id)
            ->encode(false)
            ->render();
    }

    /**
     * Generates the ID.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return string The generated ID.
     *
     * @psalm-return non-empty-string The generated ID.
     */
    private function getId(): string
    {
        return match ($this->id) {
            true => $this->attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" must be specified.'),
            default => $this->id,
        };
    }

    /**
     * Renders the body.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $parentId The ID of the parent element.
     * @param string $collapseId The ID of the collapse element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $parentId The ID of the parent element.
     * @psalm-param non-empty-string $collapseId The ID of the collapse element.
     */
    private function renderBody(AccordionItem $accordionItem, string $parentId, string $collapseId): string
    {
        $bodyAttributes = $this->bodyAttributes;
        $classesBodyAttributes = $bodyAttributes['class'] ?? null;

        $collapseAttributes = $this->collapseAttributes;
        $classesCollapseAttributes = $collapseAttributes['class'] ?? null;

        unset($bodyAttributes['class'], $collapseAttributes['class']);

        return Div::tag()
            ->attribute('data-bs-parent', $this->alwaysOpen ? null : '#' . $parentId)
            ->addAttributes($collapseAttributes)
            ->addClass(self::CLASS_COLLAPSE, $accordionItem->isActive() ? 'show' : null, $classesCollapseAttributes)
            ->id($collapseId)
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
     * Renders the header.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $collapseId The ID of the collapse element.
     *
     * @throws InvalidArgumentException If the header tag is an empty string.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $collapseId The ID of the collapse element.
     */
    private function renderHeader(AccordionItem $accordionItem, string $collapseId): string
    {
        $headerAttributes = $this->headerAttributes;
        $classesHeaderAttributes = $headerAttributes['class'] ?? null;

        unset($headerAttributes['class']);

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('Header tag cannot be empty string.');
        }

        return Html::tag($this->headerTag)
            ->addAttributes($headerAttributes)
            ->addClass(self::CLASS_HEADER, $classesHeaderAttributes)
            ->addContent(
                "\n",
                $this->renderToggle($accordionItem->getHeader(), $collapseId, $accordionItem->isActive()),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the items.
     *
     * @param string $parentId The ID of the parent element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $parentId The ID of the parent element.
     */
    private function renderItems(string $parentId): string
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $this->renderItem($item, $parentId);
        }

        return implode("\n", $items);
    }

    /**
     * Renders an accordion item.
     *
     * @param AccordionItem $accordionItem The accordion item.
     * @param string $parentId The ID of the parent element.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $parentId The ID of the parent element.
     */
    private function renderItem(AccordionItem $accordionItem, string $parentId): string
    {
        /** @psalm-var non-empty-string $collapseId */
        $collapseId = $accordionItem->getId();

        return Div::tag()->addClass(self::CLASS_ITEM)
            ->addContent(
                "\n",
                $this->renderHeader($accordionItem, $collapseId),
                "\n",
                $this->renderBody($accordionItem, $parentId, $collapseId),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the toggler.
     *
     * @param string $header The header of the item.
     * @param string $collapseId The ID of the collapse element.
     * @param bool $active Whether the item is active.
     *
     * @throws InvalidArgumentException If the toggler tag is an empty string.
     *
     * @return string The HTML representation of the element.
     *
     * @psalm-param non-empty-string $collapseId The ID of the collapse element.
     */
    private function renderToggle(string $header, string $collapseId, bool $active): string
    {
        $togglerTag = match ($this->togglerTag) {
            null => Button::button(''),
            '' => throw new InvalidArgumentException('Toggler tag cannot be empty string.'),
            default => Html::tag($this->togglerTag),
        };

        $togglerAttributes = $this->togglerAttributes;
        $togglerClasses = $togglerAttributes['class'] ?? null;

        unset($togglerAttributes['class']);

        $togglerTag = $togglerTag
            ->addAttributes($togglerAttributes)
            ->addClass(self::CLASS_TOGGLE, $active === false ? self::CLASS_TOGGLE_ACTIVE : null, $togglerClasses)
            ->addContent("\n", $header, "\n")
            ->encode(false);

        if (array_key_exists('data-bs-toggle', $togglerAttributes) === false) {
            $togglerTag = $togglerTag->attribute('data-bs-toggle', 'collapse');
        }

        if (array_key_exists('data-bs-target', $togglerAttributes) === false) {
            $togglerTag = $togglerTag->attribute('data-bs-target', '#' . $collapseId);
        }

        if (array_key_exists('aria-expanded', $togglerAttributes) === false) {
            $togglerTag = $togglerTag->attribute('aria-expanded', $active ? 'true' : 'false');
        }

        if (array_key_exists('aria-controls', $togglerAttributes) === false) {
            $togglerTag = $togglerTag->attribute('aria-controls', $collapseId);
        }

        return $togglerTag->render();
    }
}
