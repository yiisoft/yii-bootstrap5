<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\H2;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\P;
use Yiisoft\Yii\Bootstrap5\Carousel;
use Yiisoft\Yii\Bootstrap5\CarouselItem;
use Yiisoft\Yii\Bootstrap5\Tests\Support\Assert;

/**
 * Tests for `Carousel` widget.
 *
 * @group carousel
 */
final class CarouselTest extends \PHPUnit\Framework\TestCase
{
    public function testAddAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide test-class-definition" data-test="test">
            <div class="carousel-inner">
            <div class="carousel-item">
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
            Carousel::widget(config: ['attributes()' => [['class' => 'test-class-definition']]])
                ->addAttributes(['data-test' => 'test'])
                ->id('carouselExample')
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testAddClass(): void
    {
        $carouselWidget = Carousel::widget()
            ->addClass('test-class', null)
            ->id('carouselExample')
            ->items(
                new CarouselItem(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                ),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide test-class">
            <div class="carousel-inner">
            <div class="carousel-item">
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
            <div id="carouselExample" class="carousel slide test-class test-class-1 test-class-2">
            <div class="carousel-inner">
            <div class="carousel-item">
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
            ->items(
                new CarouselItem(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                ),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red;">
            <div class="carousel-inner">
            <div class="carousel-item">
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
            <div class="carousel-item">
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
            ->items(
                new CarouselItem(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                ),
            );

        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide" style="color: red;">
            <div class="carousel-inner">
            <div class="carousel-item">
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
            <div class="carousel-item">
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
            <div class="carousel-item">
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
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testAttributesWithId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="test-id" class="carousel slide test-class">
            <div class="carousel-inner">
            <div class="carousel-item">
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
                ->attributes(['class' => 'test-class', 'id' => 'test-id'])
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                    ),
                )
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        autoPlayingInterval: 10000,
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                        autoPlayingInterval: 2000,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
                )
                ->withoutControls()
                ->render(),
        );
    }

    /**
     * @link https://getbootstrap.com/docs/5.3/components/carousel/#captions
     */
    public function testCaptions(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExampleCaptions" class="carousel slide carousel-fade">
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        'First slide',
                        'Some representative placeholder content for the first slide.',
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                        'Second slide',
                        'Some representative placeholder content for the second slide.',
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                        'Third slide',
                        'Some representative placeholder content for the third slide.',
                    ),
                )
                ->crossfade()
                ->render(),
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide custom-class another-class">
            <div class="carousel-inner">
            <div class="carousel-item">
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
                ->class('custom-class', 'another-class')
                ->id('carouselExample')
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testControlNextLabelAndControlPrevLabelWithRussianLanguage(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
            <div class="carousel-item">
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
                ->controlPrevLabel('Предыдущий')
                ->id('carouselExample')
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                    ),
                )
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
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
                ->disableTouchSwiping()
                ->id('carouselExampleControlsNoTouching')
                ->items(
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testId(): void
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testIdWithEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`');

        Carousel::widget()
            ->id('')
            ->items(
                new CarouselItem(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                    active: true,
                ),
            )
            ->render();
    }

    public function testIdWithFalse(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "id" property must be a non-empty string or `true`');

        Carousel::widget()
            ->id(false)
            ->items(
                new CarouselItem(
                    Img::tag()->alt('First slide')->src('image-1.jpg'),
                    active: true,
                ),
            )
            ->render();
    }

    public function testImmutability(): void
    {
        $carousel = Carousel::widget();

        $this->assertNotSame($carousel, $carousel->addAttributes([]));
        $this->assertNotSame($carousel, $carousel->addClass(''));
        $this->assertNotSame($carousel, $carousel->addCssStyle(''));
        $this->assertNotSame($carousel, $carousel->attributes([]));
        $this->assertNotSame($carousel, $carousel->autoPlaying('false'));
        $this->assertNotSame($carousel, $carousel->class(''));
        $this->assertNotSame($carousel, $carousel->controlNextLabel(''));
        $this->assertNotSame($carousel, $carousel->controlPrevLabel(''));
        $this->assertNotSame($carousel, $carousel->crossfade(false));
        $this->assertNotSame($carousel, $carousel->disableTouchSwiping());
        $this->assertNotSame($carousel, $carousel->id(''));
        $this->assertNotSame(
            $carousel,
            $carousel->items(
                new CarouselItem(Img::tag()->alt('First slide')->src('image-1.jpg')),
            ),
        );
        $this->assertNotSame($carousel, $carousel->showIndicators(false));
        $this->assertNotSame($carousel, $carousel->withoutControls(false));
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
                )
                ->render(),
        );
    }

    public function testRenderWithEmptyItems(): void
    {
        $this->assertEmpty(Carousel::widget()->render());
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
                    new CarouselItem(
                        <<<HTML
                        <div class="bg-primary text-white p-5 text-center">
                        <h2>Title 1</h2>
                        <p>This is the first slide with text.</p>
                        </div>
                        HTML,
                        active: true,
                    ),
                    new CarouselItem(
                        <<<HTML
                        <div class="bg-success text-white p-5 text-center">
                        <h2>Title 2</h2>
                        <p>This is the second slide with text.</p>
                        </div>
                        HTML,
                    ),
                    new CarouselItem(
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
                    new CarouselItem(
                        Div::tag()
                            ->addClass('bg-primary text-white p-5 text-center')
                            ->addContent(
                                "\n",
                                H2::tag()->content('Title 1'),
                                "\n",
                                P::tag()->content('This is the first slide with text.'),
                                "\n",
                            ),
                        active: true,
                    ),
                    new CarouselItem(
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
                    new CarouselItem(
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
                    new CarouselItem(
                        Img::tag()->alt('First slide')->src('image-1.jpg'),
                        active: true,
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Second slide')->src('image-2.jpg'),
                    ),
                    new CarouselItem(
                        Img::tag()->alt('Third slide')->src('image-3.jpg'),
                    ),
                )
                ->showIndicators()
                ->render(),
        );
    }
}
