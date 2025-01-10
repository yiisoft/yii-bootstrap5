<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Hr;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Span;

/**
 * DropdownItem renders a single dropdown item.
 *
 * For example,
 *
 * ```php
 * DropdownItem::link('Dropdown link', '#');
 * DropdownItem::divider();
 * DropdownItem::header('Dropdown header');
 * DropdownItem::text('Dropdown text');
 * DropdownItem::listContent('<a href="#">Dropdown list content</a>');
 * ```
 */
final class DropdownItem
{
    private const DROPDOWN_DIVIDER_CLASS = 'dropdown-divider';
    private const DROPDOWN_ITEM_ACTIVE_CLASS = 'active';
    private const DROPDOWN_ITEM_CLASS = 'dropdown-item';
    private const DROPDOWN_ITEM_DISABLED_CLASS = 'disabled';
    private const DROPDOWN_ITEM_HEADER_CLASS = 'dropdown-header';
    private const DROPDOWN_ITEM_TEXT_CLASS = 'dropdown-item-text';
    private string|Stringable $content = '';
    /** @psalm-suppress PropertyNotSetInConstructor */
    private Li $liContent;
    private string|null $url = null;

    private function __construct()
    {
    }

    /**
     * Create a new dropdown item with a divider.
     *
     * @param array $attributes The HTML attributes of the list.
     * @param array $dividerAttributes The HTML attributes of the divider.
     *
     * @return self A new instance with the dropdown item with a divider.
     */
    public static function divider(array $attributes = [], array $dividerAttributes = []): self
    {
        $dropdownItem = new self();

        $classesDivider = $dividerAttributes['class'] ?? null;

        unset($dividerAttributes['class']);

        $dropdownItem->liContent = Li::tag()
            ->addAttributes($attributes)
            ->addContent(
                "\n",
                Hr::tag()->addAttributes($dividerAttributes)->addClass(self::DROPDOWN_DIVIDER_CLASS, $classesDivider),
                "\n"
            );

        return $dropdownItem;
    }

    /**
     * Create a new dropdown item with a header.
     *
     * @param string|Stringable $content The content of the header.
     * @param array $attributes The HTML attributes of the list.
     * @param string $headerTag The tag of the header.
     * @param array $headerAttributes The HTML attributes of the header.
     *
     * @return self A new instance with the dropdown item with a header.
     */
    public static function header(
        string|Stringable $content = '',
        array $attributes = [],
        string $headerTag = 'h6',
        array $headerAttributes = []
    ): self {
        $dropdownItem = new self();

        if ($headerTag === '') {
            throw new InvalidArgumentException('The header tag cannot be empty.');
        }

        $classesHeader = $headerAttributes['class'] ?? null;

        unset($headerAttributes['class']);

        $dropdownItem->liContent = Li::tag()
            ->addAttributes($attributes)
            ->addContent(
                "\n",
                Html::tag($headerTag, $content)
                    ->addAttributes($headerAttributes)
                    ->addClass(self::DROPDOWN_ITEM_HEADER_CLASS, $classesHeader),
                "\n",
            );

        return $dropdownItem;
    }

    /**
     * Create a new dropdown item with a link.
     *
     * @param string|Stringable $content The content of the link.
     * @param string $url The URL of the link.
     * @param bool $active Whether the dropdown item is active.
     * @param bool $disabled Whether the dropdown item is disabled.
     * @param array $attributes The HTML attributes of the the list.
     * @param array $linkAttributes The HTML attributes of the link.
     * @param bool $button Whether the dropdown item is a button.
     *
     * @return self A new instance with the dropdown item with a link.
     */
    public static function link(
        string|Stringable $content = '',
        string $url = '',
        bool $active = false,
        bool $disabled = false,
        array $attributes = [],
        array $linkAttributes = [],
        bool $button = false
    ): self {
        $dropdownItem = new self();

        if ($active && $disabled) {
            throw new InvalidArgumentException('The dropdown item cannot be active and disabled at the same time.');
        }

        $classesLink = $linkAttributes['class'] ?? null;

        unset($linkAttributes['class']);

        Html::addCssClass($linkAttributes, self::DROPDOWN_ITEM_CLASS);

        if ($active) {
            Html::addCssClass($linkAttributes, self::DROPDOWN_ITEM_ACTIVE_CLASS);
            $linkAttributes['aria-current'] = 'true';
        }

        if ($disabled) {
            Html::addCssClass($linkAttributes, self::DROPDOWN_ITEM_DISABLED_CLASS);
            $linkAttributes['aria-disabled'] = 'true';
        }

        $liContent = match ($button) {
            true => Button::button('')->addAttributes($linkAttributes)->addContent($content)->addClass($classesLink),
            default => A::tag()->addAttributes($linkAttributes)->addClass($classesLink)->content($content)->url($url),
        };

        $dropdownItem->content = $content;
        $dropdownItem->liContent = Li::tag()->addAttributes($attributes)->addContent("\n", $liContent, "\n");
        $dropdownItem->url = $url;

        return $dropdownItem;
    }

    /**
     * Create a new dropdown item with custom list content.
     *
     * @param string|Stringable $content The content of the list.
     * @param array $attributes The HTML attributes of the list.
     *
     * @return self A new instance with the dropdown item with a list.
     */
    public static function listContent(string|Stringable $content = '', array $attributes = []): self
    {
        $dropdownItem = new self();

        $dropdownItem->liContent = Li::tag()->addAttributes($attributes)->addContent($content)->encode(false);

        return $dropdownItem;
    }

    /**
     * Create a new drodown item with text content.
     *
     * @param string|Stringable $content The text content.
     * @param array $attributes The HTML attributes of the list.
     * @param array $textAttributes The HTML attributes of the text.
     *
     * @return self A new instance with the dropdown item with text content.
     */
    public static function text(
        string|Stringable $content = '',
        array $attributes = [],
        array $textAttributes = []
    ): self {
        $dropdownItem = new self();

        $classesText = $textAttributes['class'] ?? null;

        unset($textAttributes['class']);

        $dropdownItem->liContent = Li::tag()
            ->addAttributes($attributes)
            ->addContent(
                "\n",
                Span::tag()
                    ->addAttributes($textAttributes)
                    ->addClass(self::DROPDOWN_ITEM_TEXT_CLASS, $classesText)
                    ->addContent($content),
                "\n"
            );

        return $dropdownItem;
    }

    /**
     * @return string|Stringable Returns the dropdown item content.
     */
    public function getContent(): string|Stringable
    {
        return $this->content;
    }

    /**
     * @return Li Returns the dropdown item <li> content.
     */
    public function getLiContent(): Li
    {
        return $this->liContent;
    }

    /**
     * @return string|null Returns the URL of the dropdown item.
     */
    public function getUrl(): string|null
    {
        return $this->url;
    }
}
