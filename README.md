# PHPUnit extension

[![Latest Stable Version][ico-packagist-stable]][link-packagist-stable]
[![Build Status][ico-workflow]][link-workflow]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![PHPStan][ico-phpstan]][link-phpstan]
[![Total Downloads][ico-packagist-download]][link-packagist-download]
[![Software License][ico-license]][link-licence]

PHPUnit extension with additional assertions and other helpers.

- Support some deprecated functionality
- Easy to implement

## Features

Supports deprecated assertion method `withConsecutive`

Before PHPUnit 10.0

```php
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    public function testMultiply(): void
    {
        $mock = $this->createMock(Calculator::class);
        
        $arguments = [[1,2,3], [4,5,6]]
        $responses = [6, 120]
        
        $mock->expects(self::exactly(count($arguments)))->method('multiply')
            ->withConsecutive(...$arguments)
            ->willReturnOnConsecutiveCalls(...$responses);
            
        // ... test
    }
}
```

After PHPUnit 10.0

```php
use Inspirum\PHPUnit\Extension;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    use Extension;
    
    public function testMultiply(): void
    {
        $mock = $this->createMock(Calculator::class);
        
        $arguments = [[1,2,3], [4,5,6]]
        $responses = [6, 120]
        
        $mock->expects(self::exactly(count($arguments)))->method('multiply')
            ->will(self::withConsecutive($arguments, $responses));
            
        // ... test
    }
}
```


## System requirements

* [PHP 8.1+](http://php.net/releases/8_1_0.php)

## Installation

Run composer require command
```bash
$ composer require inspirum/phpunit-extension
```
or add requirement to your `composer.json`
```json
"inspirum/phpunit-extension": "^1.0"
```

## Usage

Validate arguments and responses:

```php
$mock->expects(self::exactly(count($arguments)))->method('example')
    ->will(self::withConsecutive(
        arguments: [
            [1, 2, 0.1],
            [2, 3, 0.01],
        ], 
        responses: [
            true,
            false,
        ],
    ));

self::assertTrue($mock->example(1, 2, 0.1));
self::assertFalse($mock->example(2, 3, 0.01));
```

Optional responses:

```php
$mock->expects(self::exactly(count($arguments)))->method('example')
    ->will(self::withConsecutive(
        arguments: [
            [1, 2, 0.1],
            [2, 3, 0.01],
        ], 
    ));

$mock->example(1, 2, 0.1);
$mock->example(2, 3, 0.01);
```

Simplification for same response for each call

```php
$mock->expects(self::exactly(count($arguments)))->method('example')
    ->will(self::withConsecutive(
        arguments: [
            [1, 2, 0.1],
            [2, 3, 0.01],
        ], 
        responses: true,
    ));

self::assertTrue($mock->example(1, 2, 0.1));
self::assertTrue($mock->example(2, 3, 0.01));
```

Supports throwing exceptions:

```php
$mock->expects(self::exactly(count($arguments)))->method('example')
    ->will(self::withConsecutive(
        arguments: [
            [1, 2, 0.1],
            [2, 3, 0.01],
        ], 
        responses: [
           true,
           new RuntimeException('Custom error'),
        ],
    ));

self::assertTrue($mock->example(1, 2, 0.1));

try {
    $mock->example(2, 3, 0.01);
} catch (RuntimeException $exception) {
    self::assertSame('Custom error', $exception->getMessage());
}
```

## Testing

To run unit tests, run:

```bash
$ composer test:test
```

To show coverage, run:

```bash
$ composer test:coverage
```


## Contributing

Please see [CONTRIBUTING][link-contributing] and [CODE_OF_CONDUCT][link-code-of-conduct] for details.


## Security

If you discover any security related issues, please email tomas.novotny@inspirum.cz instead of using the issue tracker.


## Credits

- [Tomáš Novotný](https://github.com/tomas-novotny)
- [All Contributors][link-contributors]


## License

The MIT License (MIT). Please see [License File][link-licence] for more information.


[ico-license]:              https://img.shields.io/github/license/inspirum/phpunit-extension.svg?style=flat-square&colorB=blue
[ico-workflow]:             https://img.shields.io/github/actions/workflow/status/inspirum/phpunit-extension/master.yml?branch=master&style=flat-square
[ico-scrutinizer]:          https://img.shields.io/scrutinizer/coverage/g/inspirum/phpunit-extension/master.svg?style=flat-square
[ico-code-quality]:         https://img.shields.io/scrutinizer/g/inspirum/phpunit-extension.svg?style=flat-square
[ico-packagist-stable]:     https://img.shields.io/packagist/v/inspirum/phpunit-extension.svg?style=flat-square&colorB=blue
[ico-packagist-download]:   https://img.shields.io/packagist/dt/inspirum/phpunit-extension.svg?style=flat-square&colorB=blue
[ico-phpstan]:              https://img.shields.io/badge/style-level%209-brightgreen.svg?style=flat-square&label=phpstan

[link-author]:              https://github.com/inspirum
[link-contributors]:        https://github.com/inspirum/phpunit-extension/contributors
[link-licence]:             ./LICENSE.md
[link-changelog]:           ./CHANGELOG.md
[link-contributing]:        ./docs/CONTRIBUTING.md
[link-code-of-conduct]:     ./docs/CODE_OF_CONDUCT.md
[link-workflow]:            https://github.com/inspirum/phpunit-extension/actions
[link-scrutinizer]:         https://scrutinizer-ci.com/g/inspirum/phpunit-extension/code-structure
[link-code-quality]:        https://scrutinizer-ci.com/g/inspirum/phpunit-extension
[link-packagist-stable]:    https://packagist.org/packages/inspirum/phpunit-extension
[link-packagist-download]:  https://packagist.org/packages/inspirum/phpunit-extension/stats
[link-phpstan]:             https://github.com/phpstan/phpstan
