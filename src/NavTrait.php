<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;

trait NavTrait
{
    private ?Size $vertical = null;

    abstract public function type(MenuType $type): static;

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#tabs
     */
    public function tabs(): static
    {
        return $this->type(MenuType::Tabs);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#pills
     */
    public function pills(): static
    {
        return $this->type(MenuType::Pills);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#underline
     */
    public function underline(): static
    {
        return $this->type(MenuType::Underline);
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/navs-tabs/#vertical
     */
    public function vertical(?Size $vertical): static
    {
        $new = clone $this;
        $new->vertical = $vertical;

        return $new;
    }
}
