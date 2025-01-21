<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Types for the Bootstrap5 {@see \Yiisoft\Yii\Button} component.
 */
enum ButtonType: string
{
    /**
     * Link button - Renders as `<a>` element.
     */
    case LINK = 'link';
    /**
     * Reset button - Renders as `<button type="reset">`.
     */
    case RESET = 'reset';
    /**
     * Reset input - Renders as `<input type="reset">`.
     */
    case RESET_INPUT = 'reset-input';
    /**
     * Submit button - Renders as `<button type="submit">`.
     */
    case SUBMIT = 'submit';
    /**
     * Submit input - Renders as `<input type="submit">`.
     */
    case SUBMIT_INPUT = 'submit-input';
}
