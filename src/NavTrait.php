<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Yii\Bootstrap5\Enum\MenuType;
use Yiisoft\Yii\Bootstrap5\Enum\Size;

trait NavTrait
{
    private ?Size $vertical = null;

    abstract public function type(MenuType $type): static;

    public function tabs(): static
    {
        return $this->type(MenuType::Tabs);
    }

    public function pills(): static
    {
        return $this->type(MenuType::Pills);
    }

    public function underline(): static
    {
        return $this->type(MenuType::Underline);
    }

    public function vertical(?Size $vertical): static
    {
        $new = clone $this;
        $new->vertical = $vertical;

        return $new;
    }
}
