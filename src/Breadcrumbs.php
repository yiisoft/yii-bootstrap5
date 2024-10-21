<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Nav;

use function implode;
use function strtr;

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
    private const NAME = 'breadcrumb';
    private array $attributes = [];
    private string $activeItemTemplate = "<li class=\"breadcrumb-item active\" aria-current=\"page\">{link}</li>\n";
    private string $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";
    private array $links = [];
    private array $listAttributes = [];
    private bool|string $listId = true;
    private string $listTagName = 'ol';

    /**
     * The template used to render each active item in the breadcrumbs. The token `{link}` will be replaced with the
     * actual HTML link for each active item.
     *
     * @param string $value The template to be used to render the active item.
     *
     * @return self A new instance with the specified active template.
     */
    public function activeItemTemplate(string $value): self
    {
        $new = clone $this;
        $new->activeItemTemplate = $value;

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
        $listAttributes = $this->listAttributes;

        $listId = match ($this->listId) {
            true => $listAttributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => null,
            default => $this->listId,
        };

        unset($listAttributes['id']);

        if ($this->links === []) {
            return '';
        }

        Html::addCssClass($listAttributes, [self::NAME]);

        $links = [];

        foreach ($this->links as $link) {
            $links[] = $this->renderItem($link);
        }

        $links = implode('', $links);

        if ($links === '') {
            return '';
        }

        if ($this->listTagName === '') {
            throw new InvalidArgumentException('Tag cannot be empty string.');
        }

        $items = Html::tag($this->listTagName, "\n" . $links, $listAttributes)->encode(false)->id($listId);

        return Nav::tag()->addAttributes($attributes)->content("\n", $items, "\n")->encode(false)->render();
    }

    private function renderItem(BreadcrumbLink $breadcrumbLink): string
    {
        if ($breadcrumbLink->label === '') {
            throw new RuntimeException('The "label" element is required for each link.');
        }

        $attributes = $breadcrumbLink->attributes;
        $label = Html::encode($breadcrumbLink->label);
        $link = $label;
        $template = $this->activeItemTemplate;

        if ($breadcrumbLink->url !== null) {
            $template = $this->itemTemplate;
            $link = A::tag()->addAttributes($attributes)->content($label)->url($breadcrumbLink->url)->encode(false);
        }

        return strtr($template, ['{link}' => $link]);
    }
}
