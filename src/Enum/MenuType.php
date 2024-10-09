<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

enum MenuType: string
{
    case Nav = 'nav';
    case Tabs = 'nav nav-tabs';
    case Pills = 'nav nav-pills';
    case Underline = 'nav nav-underline';
    case Dropdown = 'dropdown-menu';
    case BtnGroup = 'btn-group';
    case BtnGroupVertical = 'btn-group-vertical';
    case BtnToolbar = 'btn-toolbar';

    public function toggleComponent(): string
    {
        return match ($this) {
            self::Pills => 'pill',
            self::Dropdown => 'dropdown',
            default => 'tab',
        };
    }

    public function itemClassName(): ?string
    {
        return match ($this) {
            self::Dropdown => null,
            self::BtnGroup, self::BtnGroupVertical, self::BtnToolbar => 'btn-group',
            default => 'nav-item',
        };
    }

    public function linkClassName(): string
    {
        return match ($this) {
            self::Dropdown => 'dropdown-item',
            self::BtnGroup, self::BtnGroupVertical, self::BtnToolbar => 'btn',
            default => 'nav-link',
        };
    }
}
