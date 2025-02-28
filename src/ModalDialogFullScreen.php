<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

/**
 * Modal dialog fullscreen.
 *
 * @see https://getbootstrap.com/docs/5.3/components/modal/#fullscreen-modal
 */
enum ModalDialogFullscreenSize: string
{
    /**
     * The full screen variant.
     */
    case FULLSCREEN = 'modal-fullscreen';
    /**
     * The full screen sm down variant.
     */
    case FULLSCREEN_SM_DOWN = 'modal-fullscreen-sm-down';
    /**
     * The full screen md down variant.
     */
    case FULLSCREEN_MD_DOWN = 'modal-fullscreen-md-down';
    /**
     * The full screen lg down variant.
     */
    case FULLSCREEN_LG_DOWN = 'modal-fullscreen-lg-down';
    /**
     * The full screen xl down variant.
     */
    case FULLSCREEN_XL_DOWN = 'modal-fullscreen-xl-down';
    /**
     * The full screen xxl down variant.
     */
    case FULLSCREEN_XXL_DOWN = 'modal-fullscreen-xxl-down';
}
