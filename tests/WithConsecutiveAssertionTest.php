<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit\Tests;

use Inspirum\PHPUnit\Assertion;
use PHPUnit\Framework\MockObject\Stub\Stub;

final class WithConsecutiveAssertionTest extends BaseWithConsecutiveTestCase
{
    /**
     * @inheritDoc
     */
    protected static function assert(array $arguments, mixed $responses = null): Stub
    {
        return Assertion::withConsecutive($arguments, $responses);
    }
}
