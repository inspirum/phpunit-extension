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
    protected static function neverExpect(array $mocks): void
    {
        foreach ($mocks as $mock) {
            $mock->expects(self::never())->method(self::anything());
        }
    }
}
