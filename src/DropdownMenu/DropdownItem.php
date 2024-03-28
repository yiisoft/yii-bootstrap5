<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\DropdownMenu;

use Stringable;
use Yiisoft\Html\Tag\Base\Tag;

final class DropdownItem
{
    public function __construct(
        public readonly string|Tag $content = '',
        public bool $render = true,
        public bool $active = false,
        public array|string|null $containerClass = null,
        public array $containerAttributes = [],
    )
    {
    }
}
