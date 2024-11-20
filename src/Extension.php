<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit;

use PHPUnit\Framework\MockObject\Stub\Stub;

trait Extension
{
    /**
     * @param array<array<int,mixed>|\PHPUnit\Framework\Constraint\Callback<mixed>> $arguments
     */
    protected static function withConsecutive(array $arguments, mixed $responses = null): Stub
    {
        return Assertion::withConsecutive($arguments, $responses);
    }

    /**
     * @param list<\PHPUnit\Framework\MockObject\MockObject> $mocks
     */
    protected function neverExpect(array $mocks): void
    {
        foreach ($mocks as $mock) {
            $mock->expects($this->never())->method(self::anything());
        }
    }
}
