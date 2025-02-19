<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\DropdownItem;
use Yiisoft\Yii\Bootstrap5\Offcanvas;
use Yiisoft\Yii\Bootstrap5\OffcanvasPlacement;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;
use Yiisoft\Yii\Bootstrap5\Utility\Responsive;

#[Group('offcanvas')]
final class OffcanvasTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" data-id="123" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->addAttributes(['data-id' => '123'])
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testAddClass(): void
    {
        $offCanvas = Offcanvas::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->id('offcanvasExample')
            ->title('Offcanvas')
            ->togglerContent('Button with data-bs-target');

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start test-class bg-primary" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->begin() . Offcanvas::end(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start test-class bg-primary test-class-1 test-class-2" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->addClass('test-class-1', 'test-class-2')->begin() . Offcanvas::end(),
        );
    }

    public function testAddCssStyle(): void
    {
        $offCanvas = Offcanvas::widget()
            ->addCssStyle('color: red;')
            ->id('offcanvasExample')
            ->title('Offcanvas')
            ->togglerContent('Button with data-bs-target');

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" style="color: red;" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->begin() . Offcanvas::end(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" style="color: red; font-weight: bold;" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->addCssStyle('font-weight: bold;')->begin() . Offcanvas::end(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $offCanvas = Offcanvas::widget()
            ->addCssStyle('color: red;')
            ->id('offcanvasExample')
            ->title('Offcanvas')
            ->togglerContent('Button with data-bs-target');

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" style="color: red;" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->begin() . Offcanvas::end(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" style="color: red;" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            $offCanvas->addCssStyle('color: blue;', false)->begin() . Offcanvas::end(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start test-class" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->attributes(['class' => 'test-class'])
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testBodyAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvas" data-bs-toggle="offcanvas" data-bs-target="#offcanvas">Toggle Offcanvas</button>
            <div id="offcanvas" class="offcanvas offcanvas-start" aria-labelledby="offcanvas-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvas-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body" data-id="123">
            Content for the offcanvas goes here. You can place just about any Bootstrap component or custom elements here.
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->bodyAttributes(['data-id' => '123'])
                ->id('offcanvas')
                ->title('Offcanvas')
                ->togglerContent('Toggle Offcanvas')
                ->begin() .
                'Content for the offcanvas goes here. You can place just about any Bootstrap component or custom ' .
                'elements here.' . "\n" .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#body-scrolling
     */
    public function testBodyScrolling(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasScrolling" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling">Enable body scrolling</button>
            <div id="offcanvasScrolling" class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="offcanvasScrolling-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasScrolling-label" class="offcanvas-title">Offcanvas with body scrolling</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasScrolling')
                ->scrollable()
                ->title('Offcanvas with body scrolling')
                ->togglerContent('Enable body scrolling')
                ->begin() .
                '<p>Try scrolling the rest of the page to see this option in action.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#body-scrolling-and-backdrop
     */
    public function testBodyScrollingAndBackdrop(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasWithBothOptions" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions">Enable both scrolling &amp; backdrop</button>
            <div id="offcanvasWithBothOptions" class="offcanvas offcanvas-start" data-bs-scroll="true" aria-labelledby="offcanvasWithBothOptions-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasWithBothOptions-label" class="offcanvas-title">Backdrop with scrolling</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->backdrop()
                ->id('offcanvasWithBothOptions')
                ->scrollable()
                ->title('Backdrop with scrolling')
                ->togglerContent('Enable both scrolling & backdrop')
                ->begin() .
                '<p>Try scrolling the rest of the page to see this option in action.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start custom-class another-class bg-primary" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->addClass('test-class')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start custom-class another-class bg-primary" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header" data-id="123">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->headerAttributes(['data-id' => '123'])
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testImmutability(): void
    {
        $offcanvas = Offcanvas::widget();

        $this->assertNotSame($offcanvas, $offcanvas->addAttributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->addClass(''));
        $this->assertNotSame($offcanvas, $offcanvas->addCssStyle(''));
        $this->assertNotSame($offcanvas, $offcanvas->attributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->backdrop());
        $this->assertNotSame($offcanvas, $offcanvas->backdropStatic());
        $this->assertNotSame($offcanvas, $offcanvas->bodyAttributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->class(''));
        $this->assertNotSame($offcanvas, $offcanvas->headerAttributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->id('value'));
        $this->assertNotSame($offcanvas, $offcanvas->placement('offcanvas-top'));
        $this->assertNotSame($offcanvas, $offcanvas->responsive(Responsive::SM));
        $this->assertNotSame($offcanvas, $offcanvas->scrollable());
        $this->assertNotSame($offcanvas, $offcanvas->show());
        $this->assertNotSame($offcanvas, $offcanvas->theme('dark'));
        $this->assertNotSame($offcanvas, $offcanvas->title('value'));
        $this->assertNotSame($offcanvas, $offcanvas->titleAttributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->togglerAttributes([]));
        $this->assertNotSame($offcanvas, $offcanvas->togglerContent('value'));
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#placement
     */
    public function testPlacementWithBottom(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasBottom" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom">Toggle bottom offcanvas</button>
            <div id="offcanvasBottom" class="offcanvas offcanvas-bottom" aria-labelledby="offcanvasBottom-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasBottom-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasBottom')
                ->placement(OffcanvasPlacement::BOTTOM)
                ->title('Offcanvas')
                ->togglerContent('Toggle bottom offcanvas')
                ->begin() .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#placement
     */
    public function testPlacementWithEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasEnd" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd">Toggle end offcanvas</button>
            <div id="offcanvasEnd" class="offcanvas offcanvas-end" aria-labelledby="offcanvasEnd-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasEnd-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasEnd')
                ->placement(OffcanvasPlacement::END)
                ->title('Offcanvas')
                ->togglerContent('Toggle end offcanvas')
                ->begin() .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#placement
     */
    public function testPlacementWithStart(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasStart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasStart">Toggle start offcanvas</button>
            <div id="offcanvasStart" class="offcanvas offcanvas-start" aria-labelledby="offcanvasStart-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasStart-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasStart')
                ->placement(OffcanvasPlacement::START)
                ->title('Offcanvas')
                ->togglerContent('Toggle start offcanvas')
                ->begin() .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#placement
     */
    public function testPlacementWithTop(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasTop" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop">Toggle top offcanvas</button>
            <div id="offcanvasTop" class="offcanvas offcanvas-top" aria-labelledby="offcanvasTop-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasTop-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasTop')
                ->placement(OffcanvasPlacement::TOP)
                ->title('Offcanvas')
                ->togglerContent('Toggle top offcanvas')
                ->begin() .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#live-demo
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <div>
            Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
            </div>
            <div class="dropdown mt-3">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Dropdown button</button>
            <ul class="dropdown-menu">
            <li>
            <a class="dropdown-item" href="#">Action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Another action</a>
            </li>
            <li>
            <a class="dropdown-item" href="#">Something else here</a>
            </li>
            </ul>
            </div>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
                Div::tag()->content(
                    "\n",
                    'Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.',
                    "\n",
                ) . PHP_EOL .
                Dropdown::widget()
                    ->addClass('mt-3')
                    ->items(
                        DropdownItem::link('Action', '#'),
                        DropdownItem::link('Another action', '#'),
                        DropdownItem::link('Something else here', '#'),
                    )
                    ->render() . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#responsive
     */
    public function testResponsiveWithSM(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasResponsive" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive">Toggle offcanvas on small devices</button>
            <div id="offcanvasResponsive" class="offcanvas-sm offcanvas-end" aria-labelledby="offcanvasResponsive-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasResponsive-label" class="offcanvas-title">Offcanvas on small devices</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>On small devices this will take up the entire screen.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasResponsive')
                ->placement(OffcanvasPlacement::END)
                ->responsive(Responsive::SM)
                ->title('Offcanvas on small devices')
                ->togglerContent('Toggle offcanvas on small devices')
                ->begin() .
                '<p>On small devices this will take up the entire screen.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#responsive
     */
    public function testResponsiveWithMD(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasResponsive" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive">Toggle offcanvas on medium devices</button>
            <div id="offcanvasResponsive" class="offcanvas-md offcanvas-end" aria-labelledby="offcanvasResponsive-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasResponsive-label" class="offcanvas-title">Offcanvas on medium devices</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>On medium devices this will take up the entire screen.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasResponsive')
                ->placement(OffcanvasPlacement::END)
                ->responsive(Responsive::MD)
                ->title('Offcanvas on medium devices')
                ->togglerContent('Toggle offcanvas on medium devices')
                ->begin() .
                '<p>On medium devices this will take up the entire screen.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#responsive
     */
    public function testResponsiveWithLG(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasResponsive" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive">Toggle offcanvas on large devices</button>
            <div id="offcanvasResponsive" class="offcanvas-lg offcanvas-end" aria-labelledby="offcanvasResponsive-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasResponsive-label" class="offcanvas-title">Offcanvas on large devices</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>On large devices this will take up the entire screen.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasResponsive')
                ->placement(OffcanvasPlacement::END)
                ->responsive(Responsive::LG)
                ->title('Offcanvas on large devices')
                ->togglerContent('Toggle offcanvas on large devices')
                ->begin() .
                '<p>On large devices this will take up the entire screen.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#responsive
     */
    public function testResponsiveWithXL(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasResponsive" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive">Toggle offcanvas on extra large devices</button>
            <div id="offcanvasResponsive" class="offcanvas-xl offcanvas-end" aria-labelledby="offcanvasResponsive-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasResponsive-label" class="offcanvas-title">Offcanvas on extra large devices</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>On extra large devices this will take up the entire screen.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasResponsive')
                ->placement(OffcanvasPlacement::END)
                ->responsive(Responsive::XL)
                ->title('Offcanvas on extra large devices')
                ->togglerContent('Toggle offcanvas on extra large devices')
                ->begin() .
                '<p>On extra large devices this will take up the entire screen.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#responsive
     */
    public function testResponsiveWithXXL(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasResponsive" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive">Toggle offcanvas on extra extra large devices</button>
            <div id="offcanvasResponsive" class="offcanvas-xxl offcanvas-end" aria-labelledby="offcanvasResponsive-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasResponsive-label" class="offcanvas-title">Offcanvas on extra extra large devices</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <p>On extra extra large devices this will take up the entire screen.</p>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasResponsive')
                ->placement(OffcanvasPlacement::END)
                ->responsive(Responsive::XXL)
                ->title('Offcanvas on extra extra large devices')
                ->togglerContent('Toggle offcanvas on extra extra large devices')
                ->begin() .
                '<p>On extra extra large devices this will take up the entire screen.</p>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#offcanvas-components
     */
    public function testShow(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="offcanvas" class="offcanvas offcanvas-start show" aria-labelledby="offcanvas-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvas-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            Content for the offcanvas goes here. You can place just about any Bootstrap component or custom elements here.
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvas')
                ->show()
                ->title('Offcanvas')
                ->togglerContent('Toggle Offcanvas')
                ->begin() .
                'Content for the offcanvas goes here. You can place just about any Bootstrap component or custom ' .
                'elements here.' . "\n" .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#static-backdrop
     */
    public function testStaticBackdrop(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="staticBackdrop" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">Toggle static offcanvas</button>
            <div id="staticBackdrop" class="offcanvas offcanvas-start" data-bs-backdrop="static" aria-labelledby="staticBackdrop-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="staticBackdrop-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <div>I will not close if you click outside of me.</div>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('staticBackdrop')
                ->backdropStatic()
                ->title('Offcanvas')
                ->togglerContent('Toggle static offcanvas')
                ->begin() .
                '<div>I will not close if you click outside of me.</div>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    public function testTitle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Custom title</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasExample')
                ->title('Custom title')
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testTitleAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Button with data-bs-target</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title" data-id="123">Custom title</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasExample')
                ->title('Custom title')
                ->titleAttributes(['data-id' => '123'])
                ->togglerContent('Button with data-bs-target')
                ->begin() .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#dark-offcanvas
     */
    public function testThemeDark(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasDark" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDark">Toggle dark offcanvas</button>
            <div id="offcanvasDark" class="offcanvas offcanvas-start" data-bs-theme="dark" aria-labelledby="offcanvasDark-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasDark-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <div>Dark offcanvas content.</div>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasDark')
                ->theme('dark')
                ->title('Offcanvas')
                ->togglerContent('Toggle dark offcanvas')
                ->begin() .
                '<div>Dark offcanvas content.</div>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/offcanvas/#dark-offcanvas
     */
    public function testThemeLight(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasLight" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLight">Toggle light offcanvas</button>
            <div id="offcanvasLight" class="offcanvas offcanvas-start" data-bs-theme="light" aria-labelledby="offcanvasLight-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasLight-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            <div>Light offcanvas content.</div>
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasLight')
                ->theme('light')
                ->title('Offcanvas')
                ->togglerContent('Toggle light offcanvas')
                ->begin() .
                '<div>Light offcanvas content.</div>' . PHP_EOL .
            Offcanvas::end(),
        );
    }

    public function testThrowExceptionForIdEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Offcanvas::widget()->id('')->begin();
    }

    public function testThrowExceptionForIdFalseValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Offcanvas::widget()->id(false)->begin();
    }

    public function testTogglerContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Toggle offcanvas</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Toggle offcanvas')
                ->begin() .
            Offcanvas::end(),
        );
    }

    public function testTogglerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-id="123" aria-controls="offcanvasExample" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">Toggle offcanvas</button>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" aria-labelledby="offcanvasExample-label" tabindex="-1">
            <div class="offcanvas-header">
            <h5 id="offcanvasExample-label" class="offcanvas-title">Offcanvas</h5>
            <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
            </div>
            </div>
            HTML,
            Offcanvas::widget()
                ->id('offcanvasExample')
                ->title('Offcanvas')
                ->togglerContent('Toggle offcanvas')
                ->togglerAttributes(['data-id' => '123'])
                ->begin() .
            Offcanvas::end(),
        );
    }
}
