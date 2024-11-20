<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit\Tests;

use Inspirum\PHPUnit\Extension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class NeverExpectTest extends TestCase
{
    use Extension;

    private Mock&MockObject $mock1;
    private Mock&MockObject $mock2;
    private Mock&MockObject $mock3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock1 = $this->createMock(Mock::class);
        $this->mock2 = $this->createMock(Mock::class);
        $this->mock3 = $this->createMock(Mock::class);
    }

    public function testNeverExpect(): void
    {
        $this->neverExpect([
            $this->mock1,
            $this->mock2,
            $this->mock3,
        ]);
    }
}
