<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Modal dialog full screen.
 *
 * @see https://getbootstrap.com/docs/5.3/components/modal/#fullscreen-modal
 */
enum ModalDialogFullScreen: string
{
    /**
     * The full screen variant.
     */
    case FULL_SCREEN = 'modal-fullscreen';
    /**
     * The full screen sm down variant.
     */
    case FULL_SCREEN_SM_DOWN = 'modal-fullscreen-sm-down';
    /**
     * The full screen md down variant.
     */
    case FULL_SCREEN_MD_DOWN = 'modal-fullscreen-md-down';
    /**
     * The full screen lg down variant.
     */
    case FULL_SCREEN_LG_DOWN = 'modal-fullscreen-lg-down';
    /**
     * The full screen xl down variant.
     */
    case FULL_SCREEN_XL_DOWN = 'modal-fullscreen-xl-down';
    /**
     * The full screen xxl down variant.
     */
    case FULL_SCREEN_XXL_DOWN = 'modal-fullscreen-xxl-down';
}
