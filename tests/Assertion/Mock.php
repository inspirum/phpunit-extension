<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit\Tests\Assertion;

interface Mock
{
    public function single(mixed $arg): mixed;

    public function singleWithOptional(mixed $arg = null): mixed;

    public function singleWithDefault(mixed $arg = 'default'): mixed;

    public function double(mixed $arg1, mixed $arg2): mixed;

    public function doubleWithOptional(mixed $arg1, mixed $arg2 = null): mixed;

    public function doubleWithDefault(mixed $arg1, mixed $arg2 = 'default'): mixed;

    public function variadic(mixed ...$arguments): mixed;
}
