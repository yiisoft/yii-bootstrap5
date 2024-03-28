<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\DropdownMenu;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;

final class DropdownHeader
{
    /**
     * @psalm-param string|array<array-key,string|null>|null $class
     * @psalm-param string|array<array-key,string|null>|null $containerClass
     */
    public function __construct(
        private readonly string|Stringable $content = '',
        private readonly ?bool $encode = null,
        private readonly string $tag = 'h5',
        private readonly string|array|null $class = null,
        private readonly array $attributes = [],
        public readonly string|array|null $containerClass = null,
        public readonly array $containerAttributes = [],
    ) {
    }

    public function render(): CustomTag
    {
        $attributes = $this->attributes;
        Html::addCssClass($attributes, $this->class);
        Html::addCssClass($attributes, 'dropdown-header');
        return Html::tag($this->tag, $this->content, $attributes)->encode($this->encode);
    }
}
