<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Types for the button component.
 */
enum ButtonType: string
{
    case LINK = 'link';
    case RESET = 'reset';
    case SUBMIT = 'submit';
}
