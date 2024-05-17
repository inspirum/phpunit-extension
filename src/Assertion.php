<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit;

use LengthException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\MockObject\Stub\ConsecutiveCalls;
use PHPUnit\Framework\MockObject\Stub\Exception;
use PHPUnit\Framework\MockObject\Stub\ReturnCallback;
use PHPUnit\Framework\MockObject\Stub\Stub;
use Throwable;
use function array_map;
use function count;
use function func_get_arg;
use function func_get_args;
use function is_array;
use function range;
use function sprintf;

final class Assertion
{
    /**
     * @param array<array<int,mixed>|\PHPUnit\Framework\Constraint\Callback<mixed>> $arguments
     */
    public static function withConsecutive(array $arguments, mixed $responses = null): Stub
    {
        if (is_array($responses) && count($arguments) !== count($responses)) {
            throw new LengthException('Arguments and responses arrays must be same length');
        }

        if (!is_array($responses)) {
            $responses = array_map(static fn() => $responses, $arguments);
        }

        $indexes = count($arguments) > 0 ? range(0, count($arguments) - 1) : [];

        $values = array_map(static function (array|Callback $arguments, mixed $response, int $i): Stub {
            if ($response instanceof Stub) {
                return $response;
            }

            if ($response instanceof Throwable) {
                return new Exception($response);
            }

            return new ReturnCallback(static function () use ($arguments, $response, $i) {
                if ($arguments instanceof Callback) {
                    $arguments->evaluate(func_get_arg(0));
                } else {
                    $actualArguments = func_get_args();
                    foreach ($arguments as $j => $argument) {
                        if (!($argument instanceof Constraint)) {
                            $argument = new IsEqual($argument);
                        }

                        Assert::assertThat($actualArguments[$j] ?? null, $argument, sprintf('Parameter #%d for invocation #%d does not match expected value.', $j, $i));
                    }
                }

                return $response;
            });
        }, $arguments, $responses, $indexes);

        return new ConsecutiveCalls($values);
    }
}
