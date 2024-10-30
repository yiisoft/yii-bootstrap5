<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Types for the button component.
 */
enum ButtonType: string
{
    case LINK = 'link';
    case INPUT_RESET = 'input-reset';
    case INPUT_SUBMIT = 'input-submit';
    case RESET = 'reset';
    case SUBMIT = 'submit';
}
