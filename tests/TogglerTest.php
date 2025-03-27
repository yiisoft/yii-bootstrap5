<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Yiisoft\Bootstrap5\Toggler;

#[Group('collapse')]
final class TogglerTest extends TestCase
{
    public function testImmutability(): void
    {
        $toggler = Toggler::for();

        $this->assertNotSame($toggler, $toggler->ariaControls(''));
        $this->assertNotSame($toggler, $toggler->content(''));
        $this->assertNotSame($toggler, $toggler->encode(false));
        $this->assertNotSame($toggler, $toggler->id(''));
        $this->assertNotSame($toggler, $toggler->togglerAsLink(false));
        $this->assertNotSame($toggler, $toggler->togglerAttributes([]));
        $this->assertNotSame($toggler, $toggler->togglerContent(''));
        $this->assertNotSame($toggler, $toggler->togglerMultiple(false));
        $this->assertNotSame($toggler, $toggler->togglerTag(''));
    }
}
