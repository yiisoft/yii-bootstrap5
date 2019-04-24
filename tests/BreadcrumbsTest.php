<?php
/**
 * @package yii-bootstrap4
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace Yiisoft\Yii\Bootstrap4\Tests;

use Yiisoft\Yii\Bootstrap4\Breadcrumbs;

/**
 * @group bootstrap4
 */
class BreadcrumbsTest extends TestCase
{
    public function testRender()
    {
        Breadcrumbs::$counter = 0;
        $out = Breadcrumbs::widget([
            'homeLink' => ['label' => 'Home', 'url' => '#'],
            'links' => [
                ['label' => 'Library', 'url' => '#'],
                ['label' => 'Data']
            ]
        ]);

        $expected = <<<HTML
<nav aria-label="breadcrumb"><ol id="w0" class="breadcrumb"><li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item"><a href="#">Library</a></li>
<li class="breadcrumb-item active" aria-current="page">Data</li>
</ol></nav>
HTML;


        $this->assertEqualsWithoutLE($expected, $out);
    }
}
