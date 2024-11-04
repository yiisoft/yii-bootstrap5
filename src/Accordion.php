<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;

/**
 * Accordion renders an accordion bootstrap JavaScript component.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget()
 *     ->addItem('Accordion Item #1', '<strong>This is the first item\'s accordion body.</strong>')
 *     ->addItem('Accordion Item #2', '<strong>This is the second item\'s accordion body.</strong>')
 *     ->addItem('Accordion Item #3', '<strong>This is the third item\'s accordion body.</strong>')
 *     ->render(),
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/accordion/
 */
final class Accordion extends \Yiisoft\Widget\Widget
{
    private const CLASS_BODY = 'accordion-body';
    private const CLASS_COLLAPSE = 'accordion-collapse collapse';
    private const CLASS_HEADER = 'accordion-header';
    private const CLASS_ITEM = 'accordion-item';
    private const CLASS_TOGGLE = 'accordion-button';
    private const NAME = 'accordion';
    private array $attributes = [];
    private array $bodyAttributes = [];
    private array $collapseAttributes = [];
    private array $cssClass = [];
    private array $headerAttributes = [];
    private string $headerTag = 'h2';
    private bool|string $id = true;
    private array $items = [];

    /**
     * Adds a new item to the accordion.
     *
     * @param string $header The header of the item.
     * @param string $body The body of the item.
     * @param bool|string $id The ID of the item. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified item.
     */
    public function addItem(string $header, string $body, string|bool $id = true): self
    {
        $new = clone $this;
        $new->items[] = new AccordionItem($header, $body, $id);

        return $new;
    }

    public function flush(bool $value = true): self
    {
        $new = clone $this;
        $new->cssClass['flush'] = $value ? 'accordion-flush' : null;

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

    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        /** @psalm-var non-empty-string|null $id */
        $id = match ($this->id) {
            true => $attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.'),
            default => $this->id,
        };

        Html::addCssClass($attributes, [self::NAME, $classes, ...$this->cssClass]);

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

    private function renderBody(
        AccordionItem $accordionItem,
        string $idParent,
        string $idCollapse,
        bool $active
    ): string {
        $collapseAttributes = $this->collapseAttributes;
        $collapseAttributes['data-bs-parent'] = '#' . $idParent;

        return Div::tag()
            ->addAttributes($collapseAttributes)
            ->addClass(
                self::CLASS_COLLAPSE,
                $active ? 'show' : null,
            )
            ->id($idCollapse)
            ->addContent(
                "\n",
                Div::tag()
                    ->addAttributes($this->bodyAttributes)
                    ->addClass(self::CLASS_BODY)
                    ->addContent("\n", $accordionItem->getBody(), "\n")
                    ->encode(false)
                    ->render(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderHeader(AccordionItem $accordionItem, string $idCollapse, bool $active): string
    {
        $headerTag = Html::tag($this->headerTag)
            ->addAttributes($this->headerAttributes)
            ->addClass(self::CLASS_HEADER)
            ->addContent(
                "\n",
                $this->renderToggle($accordionItem->getHeader(), $idCollapse, $active),
                "\n",
            )
            ->encode(false);

        return $headerTag->render();
    }

    private function renderItems(string $idParent): string
    {
        $items = [];

        foreach ($this->items as $key => $item) {
            $active = $key === 0 && !isset($this->cssClass['flush']);
            $items[] = $this->renderItem($item, $idParent, $active);
        }

        return implode("\n", $items);
    }

    private function renderItem(AccordionItem $accordionItem, string $idParent, bool $active): string
    {
        $idCollapse = $accordionItem->getId();

        return Div::tag()->addClass(self::CLASS_ITEM)
            ->addContent(
                "\n",
                $this->renderHeader($accordionItem, $idCollapse, $active),
                "\n",
                $this->renderBody($accordionItem, $idParent, $idCollapse, $active),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderToggle(string $header, string $idCollpase, bool $active): string
    {
        return Button::button('')
            ->addClass(
                self::CLASS_TOGGLE,
                $active === false ? 'collapsed' : null,
            )
            ->addAttributes(
                [
                    'data-bs-toggle' => 'collapse',
                    'data-bs-target' => '#' . $idCollpase,
                    'aria-expanded' => $active ? 'true' : 'false',
                    'aria-controls' => $idCollpase,
                ]
            )
            ->addContent("\n", $header, "\n")
            ->id(null)
            ->render();
    }
}
