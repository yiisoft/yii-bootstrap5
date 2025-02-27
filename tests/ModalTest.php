<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\P;
use Yiisoft\Yii\Bootstrap5\Modal;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;

#[Group('modal')]
final class ModalTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" data-id="123" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->addAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testAddClass(): void
    {
        $modal = Modal::widget()->addClass('test-class', null, BackgroundColor::PRIMARY)->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal test-class bg-primary" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal test-class bg-primary test-class-1 test-class-2" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $modal = Modal::widget()->addCssStyle('color: red;')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" style="color: red;" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" style="color: red; font-weight: bold;" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $modal = Modal::widget()->addCssStyle('color: red;')->id(false);

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" style="color: red;" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" style="color: red;" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            $modal->addCssStyle('color: blue;', false)->render(),
        );
    }

    public function testAttribute(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" data-id="123" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->attribute('data-id', '123')->id(false)->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal test-class" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->attributes(['class' => 'test-class'])->id(false)->render(),
        );
    }

    public function testBody(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Body content
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->body('Body content')->id(false)->render(),
        );
    }

    public function testBodyAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-id="123">
            Body content
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->body('Body content')->bodyAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal custom-class another-class bg-primary" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()
                ->addClass('test-class')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->id(false)
                ->render(),
        );
    }

    public function testCloseButtonAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-id="123" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->closeButtonAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testCloseButtonLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Close label</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->closeButtonLabel('Close label')->id(false)->render(),
        );
    }

    public function testContentAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content" data-id="123">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->contentAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testDialogAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog" data-id="123">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->dialogAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testFooter(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            Footer content
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->footer('Footer content')->id(false)->render(),
        );
    }

    public function testFooterAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer" data-id="123">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->footerAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" data-id="123">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->headerAttributes(['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->id('test-id')->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->id('')->render(),
        );
    }

    public function testIdWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->id(false)->render(),
        );
    }

    public function testImmutability(): void
    {
        $modal = Modal::widget();

        $this->assertNotSame($modal, $modal->addAttributes([]));
        $this->assertNotSame($modal, $modal->addClass(''));
        $this->assertNotSame($modal, $modal->addCssStyle(''));
        $this->assertNotSame($modal, $modal->attribute('', ''));
        $this->assertNotSame($modal, $modal->attributes([]));
        $this->assertNotSame($modal, $modal->body());
        $this->assertNotSame($modal, $modal->bodyAttributes([]));
        $this->assertNotSame($modal, $modal->class(''));
        $this->assertNotSame($modal, $modal->closeButtonAttributes([]));
        $this->assertNotSame($modal, $modal->closeButtonLabel(''));
        $this->assertNotSame($modal, $modal->contentAttributes([]));
        $this->assertNotSame($modal, $modal->dialogAttributes([]));
        $this->assertNotSame($modal, $modal->headerAttributes([]));
        $this->assertNotSame($modal, $modal->id(''));
        $this->assertNotSame($modal, $modal->footer(''));
        $this->assertNotSame($modal, $modal->footerAttributes([]));
        $this->assertNotSame($modal, $modal->title(''));
    }

    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="modal" class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H5 class="modal-title">Modal title</H5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save changes</button>
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()
                ->body(P::tag()->content('Modal body text goes here.'))
                ->footer(
                    Button::tag()
                        ->addClass('btn btn-secondary')
                        ->attribute('data-bs-dismiss', 'modal')
                        ->content('Close'),
                    Button::tag()
                        ->addClass('btn btn-primary')
                        ->content('Save changes'),
                )
                ->id('modal')
                ->title('Modal title')
                ->render(),
        );
    }

    public function testTitle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H5 class="modal-title">Title content</H5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->title('Title content')->id(false)->render(),
        );
    }

    public function testTitleWithCustomTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H1 class="modal-title" data-id="123">Title content</H1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->title('Title content', 'H1', ['data-id' => '123'])->id(false)->render(),
        );
    }

    public function testTitleWithStringable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="modal" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <p>Title content</p>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
            </div>
            </div>
            </div>
            HTML,
            Modal::widget()->title(P::tag()->content('Title content'))->id(false)->render(),
        );
    }
}
