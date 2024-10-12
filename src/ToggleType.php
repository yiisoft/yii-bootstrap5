<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Is an enumeration of toggle types.
 */
enum ToggleType: string
{
    case TYPE_DISMISS = 'dismising';

    public function attributes(): array
    {
        return match ($this) {
            self::TYPE_DISMISS => [
                'type' => 'button',
                'class' => 'btn-close',
                'data-bs-dismiss' => 'alert',
                'aria-label' => 'Close',
            ],
            default => [],
        };
    }
}
