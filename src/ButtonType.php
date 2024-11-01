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
    case RESET_INPUT = 'reset-input';
    case SUBMIT = 'submit';
    case SUBMIT_INPUT = 'submit-input';
}
