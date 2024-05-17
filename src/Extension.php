<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit;

use PHPUnit\Framework\MockObject\Stub\Stub;

trait Extension
{
    /**
     * @param array<array<int,mixed>|\PHPUnit\Framework\Constraint\Callback<mixed>> $arguments
     */
    final public static function withConsecutive(array $arguments, mixed $responses = null): Stub
    {
        return Assertion::withConsecutive($arguments, $responses);
    }
}
