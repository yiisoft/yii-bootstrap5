<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use Yiisoft\Yii\Bootstrap5\Collapse;
use Yiisoft\Yii\Bootstrap5\CollapseItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

#[Group('collapse')]
final class CollapseTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" data-id="123">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->addAttributes(['data-id' => '123'])
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $collapse = Collapse::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->items(CollapseItem::to('Collapsible', 'collapseExample'));

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse test-class bg-primary">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse test-class bg-primary test-class-1 test-class-2">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $collapse = Collapse::widget()
            ->addCssStyle('color: red;')
            ->items(CollapseItem::to('Collapsible', 'collapseExample'));

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" style="color: red;">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" style="color: red; font-weight: bold;">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $collapse = Collapse::widget()
            ->addCssStyle('color: red;')
            ->items(CollapseItem::to('Collapsible', 'collapseExample'));

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" style="color: red;">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" style="color: red;">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            $collapse->addCssStyle('color: blue;', false)->render(),
        );
    }

    public function testAttribute(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse" data-id="123">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->attribute('data-id', '123')
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="test-class">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->attributes(['class' => 'test-class'])
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse custom-class another-class bg-primary">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->addClass('test-class')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    public function testContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div style="min-height: 120px;">
            <div id="collapseExample" class="collapse">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->containerAttributes(['style' => 'min-height: 120px;'])
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    public function testContainerWithFalseValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div id="collapseExample" class="collapse">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->container(false)
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/collapse/#example
     */
    public function testExample(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p class="d-inline-flex gap-1">
            <a class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Link with href</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Button with data-bs-target</button>
            </p>
            <div>
            <div class="col">
            <div id="collapseExample" class="collapse multi-collapse">
            <div class="card card-body">
            Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
            </div>
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->items(
                    CollapseItem::to(
                        'Some placeholder content for the collapse component. ' .
                        'This panel is hidden by default but revealed when the user activates the relevant trigger.',
                        'collapseExample',
                        togglerContent: 'Link with href',
                        togglerAsLink: true,
                    ),
                    CollapseItem::to(
                        id: 'collapseExample',
                        togglerContent: 'Button with data-bs-target',
                    ),
                )
                ->togglerContainerAttributes(['class' => 'd-inline-flex gap-1'])
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/collapse/#horizontal
     */
    public function testHorizontal(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Toggle width collapse</button>
            </p>
            <div style="min-height: 120px;">
            <div id="collapseExample" class="collapse collapse-horizontal">
            <div class="card card-body" style="width: 300px;">
            This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->addClass('collapse-horizontal')
                ->cardBodyAttributes(['style' => 'width: 300px;'])
                ->containerAttributes(['style' => 'min-height: 120px;'])
                ->items(
                    CollapseItem::to(
                        'This is some placeholder content for a horizontal collapse. ' .
                        "It's hidden by default and shown when triggered.",
                        'collapseExample',
                        togglerContent: 'Toggle width collapse',
                    ),
                )
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $collapse = Collapse::widget();

        $this->assertNotSame($collapse, $collapse->addAttributes([]));
        $this->assertNotSame($collapse, $collapse->addClass(''));
        $this->assertNotSame($collapse, $collapse->addCssStyle(''));
        $this->assertNotSame($collapse, $collapse->attribute('', ''));
        $this->assertNotSame($collapse, $collapse->attributes([]));
        $this->assertNotSame($collapse, $collapse->class(''));
        $this->assertNotSame($collapse, $collapse->container(false));
        $this->assertNotSame($collapse, $collapse->containerAttributes([]));
        $this->assertNotSame($collapse, $collapse->items(CollapseItem::to()));
        $this->assertNotSame($collapse, $collapse->togglerContainerAttributes([]));
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/collapse/#multiple-toggles-and-targets
     */
    public function testMultipleTogglesAndTargets(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p>
            <a class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
            </p>
            <div class="row">
            <div class="col">
            <div id="multiCollapseExample1" class="collapse multi-collapse">
            <div class="card card-body">
            Some placeholder content for the first collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
            </div>
            </div>
            </div>
            <div class="col">
            <div id="multiCollapseExample2" class="collapse multi-collapse">
            <div class="card card-body">
            Some placeholder content for the second collapse component of this multi-collapse example. This panel is hidden by default but revealed when the user activates the relevant trigger.
            </div>
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->containerAttributes(['class' => 'row'])
                ->items(
                    CollapseItem::to(
                        'Some placeholder content for the first collapse component of this multi-collapse example. ' .
                        'This panel is hidden by default but revealed when the user activates the relevant trigger.',
                        'multiCollapseExample1',
                        togglerContent: 'Toggle first element',
                        togglerAsLink: true,
                    ),
                    CollapseItem::to(
                        'Some placeholder content for the second collapse component of this multi-collapse example. ' .
                        'This panel is hidden by default but revealed when the user activates the relevant trigger.',
                        'multiCollapseExample2',
                        togglerContent: 'Toggle second element',
                    ),
                    CollapseItem::to(
                        togglerContent: 'Toggle both elements',
                        togglerMultiple: true,
                        ariaControls: 'multiCollapseExample1 multiCollapseExample2',
                    ),
                )
                ->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertEmpty(Collapse::widget()->render());
    }

    public function testThrowExceptionForCollapseItemWithTogglerTagEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Toggler tag cannot be empty string.');

        Collapse::widget()->items(CollapseItem::to()->togglerTag(''))->render();
    }

    public function testThrowExceptionForTogglerContainerTagEmptyValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Toggler container tag cannot be empty string.');

        Collapse::widget()
            ->items(CollapseItem::to('Collapsible', 'collapseExample'))
            ->togglerContainerTag('')
            ->render();
    }

    public function testTogglerContainerAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <p class="d-inline-flex gap-1">
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </p>
            <div>
            <div id="collapseExample" class="collapse">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->togglerContainerAttributes(['class' => 'd-inline-flex gap-1'])
                ->render(),
        );
    }

    public function testTogglerContainerTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>
            </div>
            <div>
            <div id="collapseExample" class="collapse">
            <div class="card card-body">
            Collapsible
            </div>
            </div>
            </div>
            HTML,
            Collapse::widget()
                ->items(CollapseItem::to('Collapsible', 'collapseExample'))
                ->togglerContainerTag('div')
                ->render(),
        );
    }
}
