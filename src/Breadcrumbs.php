<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Nav;

use function array_merge;
use function implode;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * ```
 */
final class Breadcrumbs extends \Yiisoft\Widget\Widget
{
    private const LIST_NAME = 'breadcrumb';
    private const ITEM_NAME = 'breadcrumb-item';
    private array $attributes = [];
    private string $itemActiveClass = 'active';
    private array $itemAttributes = [];
    private array $linkAttributes = [];
    private array $links = [];
    private array $listAttributes = [];
    private bool|string $listId = true;
    private string $listTagName = 'ol';

    /**
     * Adds a sets of attributes to the alert component.
     *
     * @param array $values Attribute values indexed by attribute names. e.g. `['id' => 'my-alert']`.
     *
     * @return self A new instance with the specified attributes added.
     */
    public function addAttributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $values);

        return $new;
    }

    /**
     * Sets the ARIA label for the breacrump component.
     *
     * @param string $value The ARIA label for the breacrumb component.
     *
     * @return self A new instance with the specified ARIA label.
     *
     * @link https://www.w3.org/TR/wai-aria-1.1/#aria-label
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the breadcrumb component.
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
     * Set the divider for the breadcrumb component.
     *
     * @param string $value The divider for the breadcrumb component.
     *
     * @return self A new instance with the specified divider.
     */
    public function divider(string $value): self
    {
        if ($value === '') {
            throw new InvalidArgumentException('The "divider" element cannot be empty.');
        }

        $new = clone $this;
        $new->attributes['style'] = ['--bs-breadcrumb-divider' => "'$value'"];

        return $new;
    }

    /**
     * Sets the active class for the items in the breadcrumbs.
     *
     * @param string $value The active class for the items in the breadcrumbs.
     *
     * @return self A new instance with the specified active class for the items in the breadcrumbs.
     */
    public function itemActiveClass(string $value): self
    {
        $new = clone $this;
        $new->itemActiveClass = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the items in the breadcrumbs.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the items in the breadcrumbs.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function itemAttributes(array $values): self
    {
        $new = clone $this;
        $new->itemAttributes = $values;

        return $new;
    }

    /**
     * Sets the HTML attributes for the link of the items in the breadcrumbs.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the link of the items in the breadcrumbs.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function linkAttributes(array $values): self
    {
        $new = clone $this;
        $new->linkAttributes = $values;

        return $new;
    }

    /**
     * List of links to appear in the breadcrumbs. If this property is empty, the widget will not render anything.
     *
     * @param array $value The links to appear in the breadcrumbs.
     *
     * @return self A new instance with the specified links to appear in the breadcrumbs.
     *
     * @psalm-param BreadcrumbLink[] $value The links to appear in the breadcrumbs.
     */
    public function links(BreadcrumbLink ...$value): self
    {
        $new = clone $this;
        $new->links = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the list of items in the breadcrumbs.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the list of items in the breadcrumbs.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function listAttributes(array $values): self
    {
        $new = clone $this;
        $new->listAttributes = $values;

        return $new;
    }

    /**
     * Sets the ID of the list of items in the breadcrumbs.
     *
     * @param bool|string $value The ID of the breadcrumb component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID for the list of items in the breadcrumbs.
     */
    public function listId(bool|string $value): self
    {
        $new = clone $this;
        $new->listId = $value;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the list of items in the breadcrumbs.
     *
     * @param string $value The HTML tag name for the list of items in the breadcrumbs.
     *
     * @return self A new instance class with the specified list tag name.
     */
    public function listTagName(string $value): self
    {
        $new = clone $this;
        $new->listTagName = $value;

        return $new;
    }

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

        return Nav::tag()->addAttributes($attributes)->content("\n", $list, "\n")->encode(false)->render();
    }

    private function renderList(): string
    {
        $listAttributes = $this->listAttributes;
        $classes = $listAttributes['class'] ?? null;

        $listId = match ($this->listId) {
            true => $listAttributes['id'] ?? Html::generateId(self::LIST_NAME . '-'),
            '', false => null,
            default => $this->listId,
        };

        unset($listAttributes['class'], $listAttributes['id']);

        $items = [];

        foreach ($this->links as $link) {
            $items[] = $this->renderItem($link);
        }

        $items = implode("\n", $items);

        if ($items === '') {
            return '';
        }

        Html::addCssClass($listAttributes, [self::LIST_NAME, $classes]);

        if ($this->listTagName === '') {
            throw new InvalidArgumentException('Tag cannot be empty string.');
        }

        return Html::tag($this->listTagName)
            ->attributes($listAttributes)
            ->content("\n", $items, "\n")
            ->id($listId)
            ->encode(false)
            ->render();
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param BreadcrumbLink $breadcrumbLink The breadcrumb item to render.
     *
     * @return string The rendering result.
     */
    private function renderItem(BreadcrumbLink $breadcrumbLink): string
    {
        if ($breadcrumbLink->label === '') {
            throw new RuntimeException('The "label" element is required for each link.');
        }

        $itemsAttributes = $this->itemAttributes;
        $classes = $itemsAttributes['class'] ?? null;

        unset($itemsAttributes['class']);

        $link = $this->renderLink($breadcrumbLink);
        Html::addCssClass($itemsAttributes, [self::ITEM_NAME, $classes]);

        if ($breadcrumbLink->url === null) {
            $itemsAttributes['aria-current'] = 'page';

            Html::addCssClass($itemsAttributes, $this->itemActiveClass);
        }

        return Li::tag()->attributes($itemsAttributes)->content($link)->encode(false)->render();
    }

    /**
     * Renders a single breadcrumb link.
     *
     * @param BreadcrumbLink $breadcrumbLink The breadcrumb link to render.
     *
     * @return string The rendering result.
     */
    private function renderLink($breadcrumbLink): string
    {
        $label = Html::encode($breadcrumbLink->label);

        return match ($breadcrumbLink->url) {
            null => $label,
            default => A::tag()
                ->attributes($this->linkAttributes)
                ->addAttributes($breadcrumbLink->getAttributes())
                ->content($label)
                ->url($breadcrumbLink->url)
                ->encode(false)
                ->render(),
        };
    }
}
