<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Bootstrap5\Carousel;
use Yiisoft\Bootstrap5\CarouselItem;
use Yiisoft\Bootstrap5\Tests\Support\Assert;
use Yiisoft\Bootstrap5\Utility\BackgroundColor;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\H2;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\P;

/**
 * Tests for `Carousel` widget.
 */
#[Group('carousel')]
final class CarouselTest extends TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" data-test="123">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->addAttributes(['data-test' => '123'])
                ->id('carouselExample')
                ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $carouselWidget = Carousel::widget()
            ->addClass('test-class', null, BackgroundColor::PRIMARY)
            ->id('carouselExample')
            ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')));

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide test-class bg-primary">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide test-class bg-primary test-class-1 test-class-2">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->addClass('test-class-1', 'test-class-2')->render(),
        );
    }

    public function testAddCssStyle(): void
    {
        $carouselWidget = Carousel::widget()
            ->addCssStyle(['color' => 'red'])
            ->id('carouselExample')
            ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')));

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red;">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red; font-weight: bold;">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->addCssStyle('font-weight: bold;')->render(),
        );
    }

    public function testAddCssStyleWithOverwriteFalse(): void
    {
        $carouselWidget = Carousel::widget()
            ->addCssStyle(['color' => 'red'])
            ->id('carouselExample')
            ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')));

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red;">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->render(),
        );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red;">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            $carouselWidget->addCssStyle('color: blue;', false)->render(),
        );
    }

    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide test-class">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->attributes(['class' => 'test-class'])
                ->id('carouselExample')
                ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#autoplaying-carousels
     */
    public function testAutoPlaying(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->autoPlaying()
                ->id('carouselExampleAutoplaying')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#individual-carousel-item-interval
     */
    public function testAutoPlayingWithCarouselItemInterval(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->autoPlaying()
                ->id('carouselExampleInterval')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg'), autoPlayingInterval: 10000),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg'), autoPlayingInterval: 2000),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#autoplaying-carousels
     */
    public function testAutoPlayingWithTrue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleRide" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->autoPlaying('true')
                ->id('carouselExampleRide')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#autoplaying-carousels-without-controls
     */
    public function testAutoPlayingWithoutControls(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            </div>
            HTML,
            Carousel::widget()
                ->autoPlaying()
                ->id('carouselExampleSlidesOnly')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->controls()
                ->render(),
        );
    }

    public function testCaptionAndPlaceholderWithAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleCaptionsCustomTagName" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
            <h5 class="bg-primary text-center">First slide</h5>
            <p class="bg-success">Some representative placeholder content for the first slide.</p>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
            <h5 class="bg-success text-center">Second slide</h5>
            <p class="bg-danger">Some representative placeholder content for the second slide.</p>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
            <h5 class="bg-danger text-center">Third slide</h5>
            <p class="bg-warning">Some representative placeholder content for the third slide.</p>
            </div>
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleCaptionsCustomTagName" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleCaptionsCustomTagName" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleCaptionsCustomTagName')
                ->items(
                    CarouselItem::to(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        'First slide',
                        'Some representative placeholder content for the first slide.',
                        captionAttributes: ['class' => 'bg-primary text-center'],
                        captionPlaceholderAttributes: ['class' => 'bg-success'],
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                        'Second slide',
                        'Some representative placeholder content for the second slide.',
                        captionAttributes: ['class' => 'bg-success text-center'],
                        captionPlaceholderAttributes: ['class' => 'bg-danger'],
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                        'Third slide',
                        'Some representative placeholder content for the third slide.',
                        captionAttributes: ['class' => 'bg-danger text-center'],
                        captionPlaceholderAttributes: ['class' => 'bg-warning'],
                    ),
                )
                ->render(),
        );
    }

    public function testCaptionWithCustomTagName(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleCaptionsCustomTagName" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
            <h2>First slide</h2>
            <span>Some representative placeholder content for the first slide.</span>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
            <h2>Second slide</h2>
            <span>Some representative placeholder content for the second slide.</span>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
            <h2>Third slide</h2>
            <span>Some representative placeholder content for the third slide.</span>
            </div>
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleCaptionsCustomTagName" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleCaptionsCustomTagName" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->captionTagName('h2')
                ->captionPlaceholderTagName('span')
                ->id('carouselExampleCaptionsCustomTagName')
                ->items(
                    CarouselItem::to(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        'First slide',
                        'Some representative placeholder content for the first slide.',
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                        'Second slide',
                        'Some representative placeholder content for the second slide.',
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                        'Third slide',
                        'Some representative placeholder content for the third slide.',
                    ),
                )
                ->render(),
        );
    }

    public function testCaptionTagNameEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The "captionTagName" and "captionPlaceholderTagName" properties cannot be empty.'
        );

        Carousel::widget()
            ->captionTagName('')
            ->id('carouselExample')
            ->items(
                CarouselItem::to(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                    'First slide',
                    'Some representative placeholder content for the first slide.',
                ),
            )
            ->render();
    }

    public function testCaptionPlaceholderTagNameEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The "captionTagName" and "captionPlaceholderTagName" properties cannot be empty.'
        );

        Carousel::widget()
            ->captionPlaceholderTagName('')
            ->id('carouselExample')
            ->items(
                CarouselItem::to(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                    'First slide',
                    'Some representative placeholder content for the first slide.',
                ),
            )
            ->render();
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#captions
     */
    public function testCaptions(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
            <h5>First slide</h5>
            <p>Some representative placeholder content for the first slide.</p>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
            <h5>Second slide</h5>
            <p>Some representative placeholder content for the second slide.</p>
            </div>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
            <h5>Third slide</h5>
            <p>Some representative placeholder content for the third slide.</p>
            </div>
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleCaptions')
                ->items(
                    CarouselItem::to(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        'First slide',
                        'Some representative placeholder content for the first slide.',
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                        'Second slide',
                        'Some representative placeholder content for the second slide.',
                    ),
                    CarouselItem::to(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                        'Third slide',
                        'Some representative placeholder content for the third slide.',
                    ),
                )
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide custom-class another-class bg-primary">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->addClass('test-class')
                ->class('custom-class', 'another-class', BackgroundColor::PRIMARY)
                ->id('carouselExample')
                ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
                ->render(),
        );
    }

    public function testControlNextLabelAndControlPrevLabelWithRussianLanguage(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Следующий</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->controlNextLabel('Следующий')
                ->controlPreviousLabel('Предыдущий')
                ->id('carouselExample')
                ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#crossfade
     */
    public function testCrossfade(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleFade" class="carousel slide carousel-fade">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleFade')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->crossfade()
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#disable-touch-swiping
     */
    public function testDisableTouchSwiping(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->touchSwiping(false)
                ->id('carouselExampleControlsNoTouching')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#test-id" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#test-id" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('test-id')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    public function testIdWithSetAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#test-id" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#test-id" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->attributes(['id' => 'test-id'])
                ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $carousel = Carousel::widget();

        $this->assertNotSame($carousel, $carousel->addAttributes([]));
        $this->assertNotSame($carousel, $carousel->addClass(''));
        $this->assertNotSame($carousel, $carousel->addCssStyle(''));
        $this->assertNotSame($carousel, $carousel->attribute('', ''));
        $this->assertNotSame($carousel, $carousel->attributes([]));
        $this->assertNotSame($carousel, $carousel->autoPlaying());
        $this->assertNotSame($carousel, $carousel->captionPlaceholderTagName(''));
        $this->assertNotSame($carousel, $carousel->captionTagName(''));
        $this->assertNotSame($carousel, $carousel->class(''));
        $this->assertNotSame($carousel, $carousel->controlNextLabel(''));
        $this->assertNotSame($carousel, $carousel->controlPreviousLabel(''));
        $this->assertNotSame($carousel, $carousel->controls(false));
        $this->assertNotSame($carousel, $carousel->crossfade(false));
        $this->assertNotSame($carousel, $carousel->id(''));
        $this->assertNotSame($carousel, $carousel->items(CarouselItem::to(Img::tag()->src('image-1.jpg'))));
        $this->assertNotSame($carousel, $carousel->showIndicators(false));
        $this->assertNotSame($carousel, $carousel->theme(''));
        $this->assertNotSame($carousel, $carousel->touchSwiping(false));
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#basic-examples
     */
    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExample')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->render(),
        );
    }

    public function testRenderWithEmptyItems(): void
    {
        $this->assertEmpty(Carousel::widget()->render());
    }

    public function testRenderWithItemsActiveDifferentFromFirst(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExample')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg'), active: true),
                )
                ->render(),
        );
    }

    public function testRenderWithItemsMultipleActive(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Only one carousel item can be active at a time.');

        Carousel::widget()
            ->id('carouselExample')
            ->items(
                CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg'), active: true),
                CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg'), active: true),
            )
            ->render();
    }

    public function testRenderWithOnlyTextWithString(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleOnlyText" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <div class="bg-primary text-white p-5 text-center">
            <h2>Title 1</h2>
            <p>This is the first slide with text.</p>
            </div>
            </div>
            <div class="carousel-item">
            <div class="bg-success text-white p-5 text-center">
            <h2>Title 2</h2>
            <p>This is the second slide with text.</p>
            </div>
            </div>
            <div class="carousel-item">
            <div class="bg-danger text-white p-5 text-center">
            <h2>Title 3</h2>
            <p>This is the third slide with text.</p>
            </div>
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleOnlyText" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleOnlyText" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleOnlyText')
                ->items(
                    CarouselItem::to(
                        <<<HTML
                        <div class="bg-primary text-white p-5 text-center">
                        <h2>Title 1</h2>
                        <p>This is the first slide with text.</p>
                        </div>
                        HTML,
                    ),
                    CarouselItem::to(
                        <<<HTML
                        <div class="bg-success text-white p-5 text-center">
                        <h2>Title 2</h2>
                        <p>This is the second slide with text.</p>
                        </div>
                        HTML,
                    ),
                    CarouselItem::to(
                        <<<HTML
                        <div class="bg-danger text-white p-5 text-center">
                        <h2>Title 3</h2>
                        <p>This is the third slide with text.</p>
                        </div>
                        HTML,
                    ),
                )
                ->render(),
        );
    }

    public function testRenderWithOnlyTextStringable(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleOnlyText" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item active">
            <div class="bg-primary text-white p-5 text-center">
            <h2>Title 1</h2>
            <p>This is the first slide with text.</p>
            </div>
            </div>
            <div class="carousel-item">
            <div class="bg-success text-white p-5 text-center">
            <h2>Title 2</h2>
            <p>This is the second slide with text.</p>
            </div>
            </div>
            <div class="carousel-item">
            <div class="bg-danger text-white p-5 text-center">
            <h2>Title 3</h2>
            <p>This is the third slide with text.</p>
            </div>
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleOnlyText" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleOnlyText" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleOnlyText')
                ->items(
                    CarouselItem::to(
                        Div::tag()
                            ->addClass('bg-primary text-white p-5 text-center')
                            ->addContent(
                                "\n",
                                H2::tag()->content('Title 1'),
                                "\n",
                                P::tag()->content('This is the first slide with text.'),
                                "\n",
                            ),
                    ),
                    CarouselItem::to(
                        Div::tag()
                            ->addClass('bg-success text-white p-5 text-center')
                            ->addContent(
                                "\n",
                                H2::tag()->content('Title 2'),
                                "\n",
                                P::tag()->content('This is the second slide with text.'),
                                "\n",
                            ),
                    ),
                    CarouselItem::to(
                        Div::tag()
                            ->addClass('bg-danger text-white p-5 text-center')
                            ->addContent(
                                "\n",
                                H2::tag()->content('Title 3'),
                                "\n",
                                P::tag()->content('This is the third slide with text.'),
                                "\n",
                            ),
                    ),
                )
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#indicators
     */
    public function testShowIndicators(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
            <button type="button" class="active" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleIndicators')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->showIndicators()
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/customize/color-modes/
     */
    public function testTheme(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-theme="dark">
            <div class="carousel-indicators">
            <button type="button" class="active" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="image-1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="image-3.jpg" alt="Third slide">
            </div>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
            </div>
            HTML,
            Carousel::widget()
                ->id('carouselExampleIndicators')
                ->items(
                    CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')),
                    CarouselItem::to(Img::tag()->alt('Second slide')->src('image-2.jpg')),
                    CarouselItem::to(Img::tag()->alt('Third slide')->src('image-3.jpg')),
                )
                ->showIndicators()
                ->theme('dark')
                ->render(),
        );
    }

    public function testThrowExceptionForIdWithEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Carousel::widget()
            ->id('')
            ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
            ->render();
    }

    public function testThrowExceptionForIdWithFalse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" must be specified.');

        Carousel::widget()
            ->id(false)
            ->items(CarouselItem::to(Img::tag()->alt('First slide')->src('image-1.jpg')))
            ->render();
    }
}
