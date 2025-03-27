<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Nav;
use Yiisoft\Widget\Widget;

use function implode;
use function sprintf;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Breadcrumbs::widget()
 *     ->links(
 *         BreadcrumbLink::to('Home', '#'),
 *         BreadcrumbLink::to('Library', '#'),
 *         BreadcrumbLink::to('Data', active: true),
 *     )
 *     ->listId(false)
 *     ->render();
 * ```
 *
 * @see https://getbootstrap.com/docs/5.3/components/breadcrumb/
 */
final class Breadcrumbs extends Widget
{
    private const LIST_NAME = 'breadcrumb';
    private const ITEM_NAME = 'breadcrumb-item';
    private array $attributes = [];
    private array $cssClasses = [];
    private string $itemActiveClass = 'active';
    private array $itemAttributes = [];
    private array $linkAttributes = [];
    private array $links = [];
    private array $listAttributes = [];
    private bool|string $listId = true;
    private string $listTagName = 'ol';

    /**
     * Adds a sets of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $breadcrumb->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$new->attributes, ...$attributes];

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
     * $breadcrumb->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
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
     * $breadcrumb->addCssStyle('color: red');
     *
     * // or
     * $breadcrumb->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Sets the ARIA label.
     *
     * @param string $label The ARIA label.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     *
     * Example usage:
     * ```php
     * $breadcrumb->ariaLabel('breadcrumb');
     * ```
     */
    public function ariaLabel(string $label): self
    {
        return $this->attribute('aria-label', $label);
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
     * $breadcrumb->attribute('data-id', '123');
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
     * $breadcrumb->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

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
     * $breadcrumb->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the divider.
     *
     * @param string $content The divider.
     *
     * @throws InvalidArgumentException If the divider is an empty string.
     *
     * @return self A new instance with the specified divider.
     *
     * Example usage:
     * ```php
     * $breadcrumb->divider('/');
     * ```
     */
    public function divider(string $content): self
    {
        if ($content === '') {
            throw new InvalidArgumentException('The "divider" cannot be empty.');
        }

        return $this->attribute('style', ['--bs-breadcrumb-divider' => sprintf("'%s'", $content)]);
    }

    /**
     * Sets the active class for the items.
     *
     * @param string $class The active class for the items.
     *
     * @return self A new instance with the specified active class for the items.
     *
     * Example usage:
     * ```php
     * $breadcrumb->itemActiveClass('active');
     * ```
     */
    public function itemActiveClass(string $class): self
    {
        $new = clone $this;
        $new->itemActiveClass = $class;

        return $new;
    }

    /**
     * Sets the HTML attributes for the items.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the items.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $breadcrumb->itemAttributes(['class' => 'my-class']);
     * ```
     */
    public function itemAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->itemAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML attributes for the link of the items.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the link of the items.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $breadcrumb->linkAttributes(['class' => 'my-class']);
     * ```
     */
    public function linkAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->linkAttributes = $attributes;

        return $new;
    }

    /**
     * List of links. If this property is empty, the widget will not render anything.
     *
     * @param BreadcrumbLink ...$links The links.
     *
     * @return self A new instance with the specified links.
     *
     * @psalm-param BreadcrumbLink[] $links The links.
     *
     * Example usage:
     * ```php
     * $breadcrumb->links(
     *     BreadcrumbLink::to('Home', '#'),
     *     BreadcrumbLink::to('Library', '#'),
     *     BreadcrumbLink::to('Data', active: true),
     * );
     * ```
     */
    public function links(BreadcrumbLink ...$links): self
    {
        $new = clone $this;
        $new->links = $links;

        return $new;
    }

    /**
     * Sets the HTML attributes for the list of items.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the list of items.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $breadcrumb->listAttributes(['class' => 'my-class']);
     * ```
     */
    public function listAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->listAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the ID of the items list.
     *
     * @param bool|string $id The ID. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID for the list of items.
     *
     * Example usage:
     * ```php
     * $breadcrumb->listId('my-id');
     * ```
     */
    public function listId(bool|string $id): self
    {
        $new = clone $this;
        $new->listId = $id;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the list of items.
     *
     * @param string $tag The HTML tag name for the list of items.
     *
     * @throws InvalidArgumentException If the tag name is empty.
     *
     * @return self A new instance class with the specified list tag name.
     *
     * Example usage:
     * ```php
     * $breadcrumb->listTagName('ul');
     * ```
     */
    public function listTagName(string $tag): self
    {
        $new = clone $this;
        $new->listTagName = $tag;

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
        $attributes['aria-label'] ??= 'breadcrumb';

        if ($this->links === []) {
            return '';
        }

        $list = $this->renderList();

        if ($list === '') {
            return '';
        }

        return Nav::tag()
            ->addAttributes($attributes)
            ->addClass(...$this->cssClasses)
            ->content("\n", $list, "\n")
            ->encode(false)
            ->render();
    }

    /**
     * Generates the ID.
     *
     * @return string|null The generated ID.
     *
     * @psalm-return non-empty-string|null The generated ID.
     */
    private function getId(): string|null
    {
        return match ($this->listId) {
            true => $this->listAttributes['id'] ?? Html::generateId(self::LIST_NAME . '-'),
            '', false => null,
            default => $this->listId,
        };
    }

    /**
     * Renders the list of items.
     *
     * @return string The HTML representation of the element..
     */
    private function renderList(): string
    {
        $listAttributes = $this->listAttributes;
        $classes = $listAttributes['class'] ?? null;

        unset($listAttributes['class'], $listAttributes['id']);

        $items = [];
        $active = 0;

        foreach ($this->links as $link) {
            $active += (int) $link->isActive();
            $items[] = $this->renderItem($link);

            if ($active > 1) {
                throw new RuntimeException('Only one "link" can be active.');
            }
        }

        $items = implode("\n", $items);

        if ($items === '') {
            return '';
        }

        if ($this->listTagName === '') {
            throw new InvalidArgumentException('List tag cannot be empty.');
        }

        return Html::tag($this->listTagName)
            ->addAttributes($listAttributes)
            ->addClass(
                self::LIST_NAME,
                $classes,
            )
            ->content("\n", $items, "\n")
            ->id($this->getId())
            ->encode(false)
            ->render();
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param BreadcrumbLink $breadcrumbLink The breadcrumb item to render.
     *
     * @return string The HTML representation of the element.
     */
    private function renderItem(BreadcrumbLink $breadcrumbLink): string
    {
        $itemsAttributes = $this->itemAttributes;
        $classes = $itemsAttributes['class'] ?? null;

        unset($itemsAttributes['class']);

        $linkTag = $this->renderLink($breadcrumbLink);

        if ($breadcrumbLink->isActive()) {
            $itemsAttributes['aria-current'] = 'page';
        }

        return Li::tag()
            ->addAttributes($itemsAttributes)
            ->addClass(
                self::ITEM_NAME,
                $classes,
                $breadcrumbLink->isActive() ? $this->itemActiveClass : null,
            )
            ->content($linkTag)
            ->encode(false)
            ->render();
    }

    /**
     * Renders a single breadcrumb link.
     *
     * @param BreadcrumbLink $breadcrumbLink The breadcrumb link to render.
     *
     * @return string The HTML representation of the element.
     */
    private function renderLink(BreadcrumbLink $breadcrumbLink): string
    {
        $label = $breadcrumbLink->getLabel();
        $url = $breadcrumbLink->getUrl();

        return match ($url) {
            null => $label,
            default => A::tag()
                ->attributes($this->linkAttributes)
                ->addAttributes($breadcrumbLink->getAttributes())
                ->content($label)
                ->url($url)
                ->encode(false)
                ->render(),
        };
    }
}
