<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Collapse;
use Yiisoft\Yii\Bootstrap5\CollapseItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

final class CollapseTest extends TestCase
{
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
                        togglerContent: 'Link with href',
                        togglerAsLink: true,
                        id: 'collapseExample',
                    ),
                    CollapseItem::to(
                        togglerContent: 'Button with data-bs-target',
                        id: 'collapseExample',
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
                ->collapseContainerAttributes(['style' => 'min-height: 120px;'])
                ->items(
                    CollapseItem::to(
                        'This is some placeholder content for a horizontal collapse. ' .
                        'It\'s hidden by default and shown when triggered.',
                        togglerContent: 'Toggle width collapse',
                        id: 'collapseExample',
                    ),
                )
                ->render(),
        );
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
                ->collapseContainerAttributes(['class' => 'row'])
                ->items(
                    CollapseItem::to(
                        'Some placeholder content for the first collapse component of this multi-collapse example. ' .
                        'This panel is hidden by default but revealed when the user activates the relevant trigger.',
                        togglerContent: 'Toggle first element',
                        togglerAsLink: true,
                        id: 'multiCollapseExample1',
                    ),
                    CollapseItem::to(
                        'Some placeholder content for the second collapse component of this multi-collapse example. ' .
                        'This panel is hidden by default but revealed when the user activates the relevant trigger.',
                        togglerContent: 'Toggle second element',
                        id: 'multiCollapseExample2',
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

    public function testRender()
    {
        $this->assertEmpty(Collapse::widget()->render());
    }
}
