<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Img;
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
