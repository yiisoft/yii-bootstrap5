<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Accordion;
use Yiisoft\Yii\Bootstrap5\AccordionItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Accordion` widget
 *
 * @group accordion
 */
final class AccordionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @link https://getbootstrap.com/docs/5.3/components/accordion/#example
     */
    public function testAddItem(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML_WRAP
<div id="accordion" class="accordion">
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordion-1" aria-expanded="true" aria-controls="accordion-1">
Accordion Item #1
</button>
</h2>
<div id="accordion-1" class="accordion-collapse collapse show" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-2" aria-expanded="false" aria-controls="accordion-2">
Accordion Item #2
</button>
</h2>
<div id="accordion-2" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-3" aria-expanded="false" aria-controls="accordion-3">
Accordion Item #3
</button>
</h2>
<div id="accordion-3" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
</div>
HTML_WRAP

            ,
            Accordion::widget()
                ->addItem(
                    'Accordion Item #1',
                    '<strong>This is the first item\'s accordion body.</strong>' .
                    ' It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-1'
                )
                ->addItem(
                    'Accordion Item #2',
                    '<strong>This is the second item\'s accordion body.</strong>' .
                    ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-2'
                )
                ->addItem(
                    'Accordion Item #3',
                    '<strong>This is the third item\'s accordion body.</strong>' .
                    ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-3'
                )
                ->id('accordion')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/accordion/#flush
     */
    public function testFlush(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML_WRAP
<div id="accordion" class="accordion accordion-flush">
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-1" aria-expanded="false" aria-controls="accordion-1">
Accordion Item #1
</button>
</h2>
<div id="accordion-1" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-2" aria-expanded="false" aria-controls="accordion-2">
Accordion Item #2
</button>
</h2>
<div id="accordion-2" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-3" aria-expanded="false" aria-controls="accordion-3">
Accordion Item #3
</button>
</h2>
<div id="accordion-3" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
</div>
HTML_WRAP

            ,
            Accordion::widget()
                ->addItem(
                    'Accordion Item #1',
                    '<strong>This is the first item\'s accordion body.</strong>' .
                    ' It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-1'
                )
                ->addItem(
                    'Accordion Item #2',
                    '<strong>This is the second item\'s accordion body.</strong>' .
                    ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-2'
                )
                ->addItem(
                    'Accordion Item #3',
                    '<strong>This is the third item\'s accordion body.</strong>' .
                    ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                    ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                    ' You can modify any of this with custom CSS or overriding our default variables. ' .
                    ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                    'accordion-3'
                )
                ->flush()
                ->id('accordion')
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $accordion = Accordion::widget();

        $this->assertNotSame($accordion, $accordion->addItem('', ''));
        $this->assertNotSame($accordion, $accordion->flush());
        $this->assertNotSame($accordion, $accordion->items(new AccordionItem('', '')));
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/accordion/#example
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML_WRAP
<div id="accordion" class="accordion">
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordion-1" aria-expanded="true" aria-controls="accordion-1">
Accordion Item #1
</button>
</h2>
<div id="accordion-1" class="accordion-collapse collapse show" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-2" aria-expanded="false" aria-controls="accordion-2">
Accordion Item #2
</button>
</h2>
<div id="accordion-2" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
<div class="accordion-item">
<h2 class="accordion-header">
<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-3" aria-expanded="false" aria-controls="accordion-3">
Accordion Item #3
</button>
</h2>
<div id="accordion-3" class="accordion-collapse collapse" data-bs-parent="#accordion">
<div class="accordion-body">
<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.  These classes control the overall appearance, as well as the showing and hiding via CSS transitions.  You can modify any of this with custom CSS or overriding our default variables.  It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
</div>
</div>
</div>
</div>
HTML_WRAP
,
            Accordion::widget()
                ->items(
                    new AccordionItem(
                        'Accordion Item #1',
                        '<strong>This is the first item\'s accordion body.</strong>' .
                        ' It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                        ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                        ' You can modify any of this with custom CSS or overriding our default variables. ' .
                        ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                        'accordion-1'
                    ),
                    new AccordionItem(
                        'Accordion Item #2',
                        '<strong>This is the second item\'s accordion body.</strong>' .
                        ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                        ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                        ' You can modify any of this with custom CSS or overriding our default variables. ' .
                        ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                        'accordion-2'
                    ),
                    new AccordionItem(
                        'Accordion Item #3',
                        '<strong>This is the third item\'s accordion body.</strong>' .
                        ' It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. ' .
                        ' These classes control the overall appearance, as well as the showing and hiding via CSS transitions. ' .
                        ' You can modify any of this with custom CSS or overriding our default variables. ' .
                        ' It\'s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.',
                        'accordion-3'
                    ),
                )
                ->id('accordion')
                ->render(),
        );
    }
}
