<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Utility;

/**
 * Item alignment utilities.
 *
 * @see https://getbootstrap.com/docs/5.3/utilities/flex/#align-items
 */
enum AlignItems: string
{
    /**
     * Align items at the baseline.
     */
    case BASELINE = 'align-items-baseline';
    /**
     * Align items at the baseline for lg.
     */
    case BASELINE_LG = 'align-items-lg-baseline';
    /**
     * Align items at the baseline for md.
     */
    case BASELINE_MD = 'align-items-md-baseline';
    /**
     * Align items at the baseline for xl.
     */
    case BASELINE_XL = 'align-items-xl-baseline';
    /**
     * Align items at the baseline for sm.
     */
    case BASELINE_SM = 'align-items-sm-baseline';
    /**
     * Align items at the baseline for xxl.
     */
    case BASELINE_XXL = 'align-items-xxl-baseline';
    /**
     * Align items at the center.
     */
    case CENTER = 'align-items-center';
    /**
     * Align items at the center for lg.
     */
    case CENTER_LG = 'align-items-lg-center';
    /**
     * Align items at the center for md.
     */
    case CENTER_MD = 'align-items-md-center';
    /**
     * Align items at the center for sm.
     */
    case CENTER_SM = 'align-items-sm-center';
    /**
     * Align items at the center for xl.
     */
    case CENTER_XL = 'align-items-xl-center';
    /**
     * Align items at the center for xxl.
     */
    case CENTER_XXL = 'align-items-xxl-center';
    /**
     * Align items at the end.
     */
    case END = 'align-items-end';
    /**
     * Align items at the end for lg.
     */
    case END_LG = 'align-items-lg-end';
    /**
     * Align items at the end for md.
     */
    case END_MD = 'align-items-md-end';
    /**
     * Align items at the end for sm.
     */
    case END_SM = 'align-items-sm-end';
    /**
     * Align items at the end for xl.
     */
    case END_XL = 'align-items-xl-end';
    /**
     * Align items at the end for xxl.
     */
    case END_XXL = 'align-items-xxl-end';
    /**
     * Align items at the start.
     */
    case START = 'align-items-start';
    /**
     * Align items at the start for lg.
     */
    case START_LG = 'align-items-lg-start';
    /**
     * Align items at the start for md.
     */
    case START_MD = 'align-items-md-start';
    /**
     * Align items at the start for sm.
     */
    case START_SM = 'align-items-sm-start';
    /**
     * Align items at the start for xl.
     */
    case START_XL = 'align-items-xl-start';
    /**
     * Align items at the start for xxl.
     */
    case START_XXL = 'align-items-xxl-start';
    /**
     * Align items at the stretch.
     */
    case STRETCH = 'align-items-stretch';
    /**
     * Align items at the stretch for lg.
     */
    case STRETCH_LG = 'align-items-lg-stretch';
    /**
     * Align items at the stretch for md.
     */
    case STRETCH_MD = 'align-items-md-stretch';
    /**
     * Align items at the stretch for sm.
     */
    case STRETCH_SM = 'align-items-sm-stretch';
    /**
     * Align items at the stretch for xl.
     */
    case STRETCH_XL = 'align-items-xl-stretch';
    /**
     * Align items at the stretch for xxl.
     */
    case STRETCH_XXL = 'align-items-xxl-stretch';
}
