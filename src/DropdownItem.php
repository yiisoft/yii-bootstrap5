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

final class DropdownItem
{
    private const DROPDOWN_DIVIDER_CLASS = 'dropdown-divider';
    private const DROPDOWN_ITEM_ACTIVE_CLASS = 'active';
    private const DROPDOWN_ITEM_CLASS = 'dropdown-item';
    private const DROPDOWN_ITEM_DISABLED_CLASS = 'disabled';
    private const DROPDOWN_ITEM_HEADER_CLASS = 'dropdown-header';
    private const DROPDOWN_ITEM_TEXT_CLASS = 'dropdown-item-text';
    /** @psalm-suppress PropertyNotSetInConstructor */
    private Li $content;

    private function __construct()
    {
    }

    public static function divider(array $attributes = [], array $dividerAttributes = []): self
    {
        $dropdownItem = new self();

        $classesDivider = $dividerAttributes['class'] ?? null;

        unset($dividerAttributes['class']);

        $dropdownItem->content = Li::tag()
            ->addAttributes($attributes)
            ->addContent(
                "\n",
                Hr::tag()->addAttributes($dividerAttributes)->addClass(self::DROPDOWN_DIVIDER_CLASS, $classesDivider),
                "\n"
            );

        return $dropdownItem;
    }

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

        $dropdownItem->content = Li::tag()
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

        $dropdownItem->content = Li::tag()->addAttributes($attributes)->addContent("\n", $liContent, "\n");

        return $dropdownItem;
    }

    public static function text(
        string|Stringable $content = '',
        array $attributes = [],
        array $textAttributes = []
    ): self {
        $dropdownItem = new self();

        $classesText = $textAttributes['class'] ?? null;

        unset($textAttributes['class']);

        $dropdownItem->content = Li::tag()
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
     * @return Li Returns the encoded label content.
     */
    public function getContent(): Li
    {
        return $this->content;
    }
}
