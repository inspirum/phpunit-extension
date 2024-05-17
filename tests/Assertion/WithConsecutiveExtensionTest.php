<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit\Tests\Assertion;

use Inspirum\PHPUnit\Extension;
use PHPUnit\Framework\MockObject\Stub\Stub;

final class WithConsecutiveExtensionTest extends BaseWithConsecutiveTestCase
{
    use Extension;

    /**
     * @inheritDoc
     */
    protected static function assert(array $arguments, mixed $responses = null): Stub
    {
        return self::withConsecutive($arguments, $responses);
    }
}
