<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

/**
 * Is an enumeration of toggle types.
 */
enum ToggleType: string
{
    case TYPE_DISMISING = 'dismising';

    public function buildAttibutes(): array
    {
        return match ($this) {
            self::TYPE_DISMISING => [
                'type' => 'button',
                'class' => 'btn-close',
                'data-bs-dismiss' => 'alert',
                'aria-label' => 'Close',
            ],
            default => [],
        };
    }
}
