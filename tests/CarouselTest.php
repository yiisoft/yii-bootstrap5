<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

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
}
