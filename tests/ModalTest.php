<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\P;
use Yiisoft\Yii\Bootstrap5\Modal;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Yii\Bootstrap5\Utility\BackgroundColor;
use Yiisoft\Yii\Bootstrap5\Utility\Responsive;

#[Group('modal')]
final class ModalTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" data-id="123" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->addAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testAddClass(): void
    {
        $modal = Modal::widget()->addClass('test-class', null, BackgroundColor::PRIMARY)->id('modal')->triggerButton();

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal test-class bg-primary fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal test-class bg-primary fade test-class-1 test-class-2" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
        $modal = Modal::widget()->addCssStyle('color: red;')->id('modal')->triggerButton();

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" style="color: red;" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" style="color: red; font-weight: bold;" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
        $modal = Modal::widget()->addCssStyle('color: red;')->id('modal')->triggerButton();

        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" style="color: red;" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" style="color: red;" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" data-id="123" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->attribute('data-id', '123')->id('modal')->triggerButton()->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade test-class" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->attributes(['class' => 'test-class'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testBody(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->body('Body content')->id('modal')->triggerButton()->render(),
        );
    }

    public function testBodyAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()
                ->body('Body content')
                ->bodyAttributes(['data-id' => '123'])
                ->id('modal')
                ->triggerButton()->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal custom-class another-class bg-primary fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
                ->id('modal')
                ->triggerButton()
                ->render(),
        );
    }

    public function testCloseButtonAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->closeButtonAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testCloseButtonLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->closeButtonLabel('Close label')->id('modal')->triggerButton()->render(),
        );
    }

    public function testContentAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->contentAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testDialogAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->dialogAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testFooter(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->footer('Footer content')->id('modal')->triggerButton()->render(),
        );
    }

    public function testFooterAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->footerAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testHeaderAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->headerAttributes(['data-id' => '123'])->id('modal')->triggerButton()->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#test-id">Launch modal</button>
            <div id="test-id" class="modal fade" aria-labelledby="test-idLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->id('test-id')->triggerButton()->render(),
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

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#modal-components
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch demo modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H5 id="modalLabel" class="modal-title">Modal title</H5>
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
                ->triggerButton('Launch demo modal')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#accessibility
     */
    public function testResponsiveWithSM(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smallModal">Small modal</button>
            <div id="smallModal" class="modal fade" aria-labelledby="smallModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
            <H5 id="smallModalLabel" class="modal-title">Modal title</H5>
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
                ->id('smallModal')
                ->responsive(Responsive::SM)
                ->title('Modal title')
                ->triggerButton('Small modal')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#accessibility
     */
    public function testResponsiveWithLG(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Large modal</button>
            <div id="largeModal" class="modal fade" aria-labelledby="largeModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <H5 id="largeModalLabel" class="modal-title">Modal title</H5>
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
                ->id('largeModal')
                ->responsive(Responsive::LG)
                ->title('Modal title')
                ->triggerButton('Large modal')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#accessibility
     */
    public function testResponsiveWithXL(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#extraLargeModal">Extra large modal</button>
            <div id="extraLargeModal" class="modal fade" aria-labelledby="extraLargeModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
            <H5 id="extraLargeModalLabel" class="modal-title">Modal title</H5>
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
                ->id('extraLargeModal')
                ->responsive(Responsive::XL)
                ->title('Modal title')
                ->triggerButton('Extra large modal')
                ->render(),
        );
    }

    public function testThrowExceptionForIdWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Modal::widget()->id('')->triggerButton()->render();
    }

    public function testThrowExceptionForIdWithFalseValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Modal::widget()->id(false)->triggerButton()->render();
    }

    public function testThrowExceptionForTitleTagWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The tag for the title cannot be an empty string.');

        Modal::widget()->id(false)->title('Title content', '')->render();
    }

    public function testTitle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#model">Launch modal</button>
            <div id="model" class="modal fade" aria-labelledby="modelLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H5 id="modelLabel" class="modal-title">Title content</H5>
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
            Modal::widget()->id('model')->title('Title content')->triggerButton()->render(),
        );
    }

    public function testTitleWithCustomTag(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H1 id="modalLabel" class="modal-title" data-id="123">Title content</H1>
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
            Modal::widget()->id('modal')->title('Title content', 'H1', ['data-id' => '123'])->triggerButton()->render(),
        );
    }

    public function testTitleWithStringable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Launch modal</button>
            <div id="modal" class="modal fade" aria-labelledby="modalLabel" aria-hidden="true" tabindex="-1">
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
            Modal::widget()->id('modal')->title(P::tag()->content('Title content'))->triggerButton()->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#live-demo
     */
    public function testTriggerButton(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Launch demo modal</button>
            <div id="exampleModal" class="modal fade" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H1 id="exampleModalLabel" class="modal-title fs-5">Modal title</H1>
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
                ->id('exampleModal')
                ->title('Modal title', 'H1', ['class' => 'fs-5'])
                ->triggerButton('Launch demo modal')
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/modal/#static-backdrop
     */
    public function testTriggerButtonWithStaticBackdrop(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Launch demo modal</button>
            <div id="staticBackdrop" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <H1 id="staticBackdropLabel" class="modal-title fs-5">Modal title</H1>
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
                ->id('staticBackdrop')
                ->title('Modal title', 'H1', ['class' => 'fs-5'])
                ->triggerButton('Launch demo modal', true)
                ->render(),
        );
    }
}
