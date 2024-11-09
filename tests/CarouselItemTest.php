<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Tag\Img;
use Yiisoft\Yii\Bootstrap5\CarouselItem;

/**
 * Tests for `CarouselItem`.
 *
 * @group carousel
 */
final class CarouselItemTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAttributes(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            attributes: ['class' => 'test'],
        );

        $this->assertSame(['class' => 'test'], $carouselItem->getAttributes());
    }

    public function testGetAutoPlayingInterval(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            autoPlayingInterval: 5000,
        );

        $this->assertSame(5000, $carouselItem->getAutoPlayingInterval());
    }

    public function testGetContent(): void
    {
        $image = Img::tag()->alt('First slide')->src('image-1.jpg');
        $carouselItem = new CarouselItem($image);

        $this->assertSame($image, $carouselItem->getContent());
    }

    public function testGetContentWithStringable(): void
    {
        $carouselItem = new CarouselItem(
            new class () implements \Stringable {
                public function __toString(): string
                {
                    return 'First slide';
                }
            },
        );

        $this->assertSame('First slide', (string) $carouselItem->getContent());
    }

    public function testGetContentCaption(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            contentCaption: 'First slide',
        );

        $this->assertSame('First slide', $carouselItem->getContentCaption());
    }

    public function testGetContentCaptionEncodeWithFalse(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            contentCaption: '<strong>First slide</strong>',
            encodeContentCaption: false,
        );

        $this->assertSame('<strong>First slide</strong>', $carouselItem->getContentCaption());
    }

    public function testGetContentCaptionPlaceholder(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            contentCaptionPlaceholder: '<strong>Some representative placeholder content for the first slide.</strong>',
        );

        $this->assertSame(
            '&lt;strong&gt;Some representative placeholder content for the first slide.&lt;/strong&gt;',
            $carouselItem->getContentCaptionPlaceholder(),
        );
    }

    public function testGetContentCaptionPlaceholderEncodeWithFalse(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            contentCaptionPlaceholder: '<strong>Some representative placeholder content for the first slide.</strong>',
            encodeContentCaptionPlaceholder: false,
        );

        $this->assertSame(
            '<strong>Some representative placeholder content for the first slide.</strong>',
            $carouselItem->getContentCaptionPlaceholder(),
        );
    }

    public function testIsActive(): void
    {
        $carouselItem = new CarouselItem(
            Img::tag()->alt('First slide')->src('image-1.jpg'),
            active: true,
        );

        $this->assertTrue($carouselItem->isActive());
    }
}
