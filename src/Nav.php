<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Yii\Bootstrap5\Enum\MenuType;

/**
 * @psalm-suppress MethodSignatureMismatch
 */
final class Nav extends AbstractMenu
{
    use NavTrait;

    protected MenuType $type = MenuType::Nav;

    protected function prepareNav(): Tag
    {
        $tag = parent::prepareNav();

        if ($this->vertical) {
            return $tag->addClass($this->vertical->formatClassName('flex', 'column'));
        }

        return $tag;
    }
}
