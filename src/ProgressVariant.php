<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

/**
 * Variant for the progress component.
 *
 * https://getbootstrap.com/docs/5.3/components/progress/
 */
enum ProgressVariant: string
{
    /**
     * The progress bar will be animated and striped.
     */
    case ANIMATED_STRIPED = 'progress-bar-striped progress-bar-animated';
    /**
     * The progress bar will be striped.
     */
    case STRIPED = 'progress-bar-striped';
}
