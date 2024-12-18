<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Li;

/**
 * Represents a Bootstrap Nav link.
 */
final class NavLink
{
    private const NAV_LINK_ACTIVE_CLASS = 'active';
    private const NAV_LINK_DISABLED_CLASS = 'disabled';
    private const NAV_LINK_CLASS = 'nav-link';
    private const NAV_ITEM_CLASS = 'nav-item';
    /** @psalm-suppress PropertyNotSetInConstructor */
    private Li $content;

    public function __construct()
    {
    }

    public static function create(
        string|Stringable $label = '',
        string|null $url = null,
        bool $active = false,
        bool $disabled = false,
        array $attributes = [],
    ): self {
        $navlink = new self();

        if ($active === true && $disabled === true) {
            throw new InvalidArgumentException('The link cannot be active and disabled at the same time.');
        }

        Html::addCssClass($attributes, [self::NAV_LINK_CLASS]);

        if ($active === true) {
            Html::addCssClass($attributes, [self::NAV_LINK_ACTIVE_CLASS]);

            $attributes['aria-current'] = 'page';
        }

        if ($disabled === true) {
            Html::addCssClass($attributes, [self::NAV_LINK_DISABLED_CLASS]);

            $attributes['aria-disabled'] = 'true';
        }

        $navlink->content = Li::tag()
            ->addClass(self::NAV_ITEM_CLASS)
            ->addContent(
                "\n",
                A::tag()->addAttributes($attributes)->addContent($label)->href($url),
                "\n",
            );

        return $navlink;
    }

    /**
     * @return Li Returns the encoded label content.
     */
    public function getContent(): Li
    {
        return $this->content;
    }
}
