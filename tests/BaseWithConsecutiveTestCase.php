<?php

declare(strict_types=1);

namespace Inspirum\PHPUnit\Tests;

use LengthException;
use PHPUnit\Framework\Constraint\Callback;
use PHPUnit\Framework\Constraint\GreaterThan;
use PHPUnit\Framework\Constraint\IsAnything;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;
use PHPUnit\Framework\MockObject\Stub\Stub;
use PHPUnit\Framework\TestCase;
use RuntimeException;

abstract class BaseWithConsecutiveTestCase extends TestCase
{
    private Mock&MockObject $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->createMock(Mock::class);
    }

    /**
     * @param array<array<int,mixed>|\PHPUnit\Framework\Constraint\Callback<mixed>> $arguments
     */
    abstract protected static function assert(array $arguments, mixed $responses = null): Stub;

    public function testSingle(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('single')
            ->will(static::assert([
                ['1'],
                ['2'],
                ['3'],
            ]));

        $this->mock->single('1');
        $this->mock->single('2');
        $this->mock->single('3');
    }

    public function testEmpty(): void
    {
        $this->mock
            ->expects(self::exactly(0))
            ->method('single')
            ->will(static::assert([], true));
    }

    public function testSingleResponse(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('single')
            ->will(static::assert([
                ['1'],
                ['2'],
                ['3'],
            ], [
                '4',
                '5',
                '6',
            ]));

        self::assertSame('4', $this->mock->single('1'));
        self::assertSame('5', $this->mock->single('2'));
        self::assertSame('6', $this->mock->single('3'));
    }

    public function testSingleSameResponse(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('single')
            ->will(static::assert(
                [
                    ['1'],
                    ['2'],
                    ['3'],
                ],
                false,
            ));

        self::assertSame(false, $this->mock->single('1'));
        self::assertSame(false, $this->mock->single('2'));
        self::assertSame(false, $this->mock->single('3'));
    }

    public function testSingleFailResponseLength(): void
    {
        self::expectException(LengthException::class);
        self::expectExceptionMessage('Arguments and responses arrays must be same length');

        $this->mock
            ->expects(self::any())
            ->method('single')
            ->will(static::assert([
                ['1'],
                ['2'],
                ['3'],
            ], [false]));

        $this->mock->single('1');
    }

    public function testSingleExceptionResponse(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Custom error');

        $this->mock
            ->expects(self::any())
            ->method('single')
            ->will(static::assert([
                ['1'],
                ['2'],
                ['3'],
            ], [
                true,
                new RuntimeException('Custom error'),
                true,
            ]));

        self::assertSame(true, $this->mock->single('1'));
        $this->mock->single('2');
    }

    public function testSingleStubResponse(): void
    {
        $this->mock
            ->expects(self::any())
            ->method('single')
            ->will(static::assert([
                ['1'],
                ['2'],
                ['3'],
            ], [
                true,
                new ReturnStub(false),
                true,
            ]));

        self::assertSame(true, $this->mock->single('1'));
        self::assertSame(false, $this->mock->single('2'));
        self::assertSame(true, $this->mock->single('3'));
    }

    public function testSingleWithOptional(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('singleWithOptional')
            ->will(static::assert([
                ['1'],
                [],
                ['3'],
            ]));

        $this->mock->singleWithOptional('1');
        $this->mock->singleWithOptional();
        $this->mock->singleWithOptional('3');
    }

    public function testSingleWithDefaultValue(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('singleWithDefault')
            ->will(static::assert([
                ['1'],
                ['default'],
                ['3'],
            ]));

        $this->mock->singleWithDefault('1');
        $this->mock->singleWithDefault();
        $this->mock->singleWithDefault('3');
    }

    public function testDouble(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('double')
            ->will(static::assert([
                ['1.1', '1.2'],
                ['2.1', '2.2'],
                ['3.1', '3.2'],
            ]));

        $this->mock->double('1.1', '1.2');
        $this->mock->double('2.1', '2.2');
        $this->mock->double('3.1', '3.2');
    }

    public function testDoubleWithOptional(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('doubleWithOptional')
            ->will(static::assert([
                ['1.1', '1.2'],
                ['2.1'],
                ['3.1', '3.2'],
            ]));

        $this->mock->doubleWithOptional('1.1', '1.2');
        $this->mock->doubleWithOptional('2.1');
        $this->mock->doubleWithOptional('3.1', '3.2');
    }

    public function testDoubleWithDefault(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('doubleWithDefault')
            ->will(static::assert([
                ['1.1', '1.2'],
                ['2.1', 'default'],
                ['3.1', '3.2'],
            ]));

        $this->mock->doubleWithDefault('1.1', '1.2');
        $this->mock->doubleWithDefault('2.1');
        $this->mock->doubleWithDefault('3.1', '3.2');
    }

    public function testVariadic(): void
    {
        $this->mock
            ->expects(self::exactly(3))
            ->method('variadic')
            ->will(static::assert([
                ['1.1', '1.2', '1.3'],
                ['2.1', '2.2', '2.3'],
                ['3.1', '3.2', '3.3'],
            ]));

        $this->mock->variadic('1.1', '1.2', '1.3');
        $this->mock->variadic('2.1', '2.2', '2.3');
        $this->mock->variadic('3.1', '3.2', '3.3');
    }

    public function testVariadicConstraint(): void
    {
        $this->mock
            ->expects(self::exactly(4))
            ->method('variadic')
            ->will(static::assert([
                [new IsAnything(), '1.2', '1.3'],
                ['2.1', new IsEqual('2.2'), new GreaterThan('2.2')],
                [new IsIdentical('3.1'), '3.3'],
                new Callback(static function (mixed $arg) {
                    self::assertSame('4.1-4.2-3.3', $arg);

                    return true;
                }),
            ]));

        $this->mock->variadic('1.1', '1.2', '1.3');
        $this->mock->variadic('2.1', '2.2', '2.3');
        $this->mock->variadic('3.1', '3.3');
        $this->mock->variadic('4.1-4.2-3.3');
    }

    public function testVariadicFailMatch(): void
    {
        self::expectException(ExpectationFailedException::class);
        self::expectExceptionMessage("Parameter #2 for invocation #1 does not match expected value.\nFailed asserting that null matches expected '2.3'");

        $this->mock
            ->expects(self::exactly(2))
            ->method('variadic')
            ->will(static::assert([
                ['1.1', '1.2', '1.3'],
                ['2.1', '2.2', '2.3'],
            ]));

        $this->mock->variadic('1.1', '1.2', '1.3');
        $this->mock->variadic('2.1', '2.2');
    }
}
