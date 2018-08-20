<?php

namespace yii\bootstrap4;

/**
 * Class Breadcrumbs
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /** {@inheritdoc} */
    public $activeItemTemplate = "<li class=\"breadcrumb-item active\">{link}</li>\n";

    /** {@inheritdoc} */
    public $itemTemplate = '<li class="breadcrumb-item">{link}</li>';
}
