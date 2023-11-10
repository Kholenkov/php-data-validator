<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Ru;

use InvalidArgumentException;
use Kholenkov\DataValidator\Ru\EntrepreneurCode;
use PHPUnit\Framework\TestCase;

class EntrepreneurCodeTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code): void
    {
        self::assertTrue(EntrepreneurCode::isValid($code));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('Empty entrepreneur code');

        EntrepreneurCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('Incorrect check digit of entrepreneur code');

        EntrepreneurCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage('Entrepreneur code can only consist of digits');

        EntrepreneurCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage('Entrepreneur code can only consist of 15 digits');

        EntrepreneurCode::isValid($code);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['000000000000000'],
            ['307760324100018'],
        ];
    }

    public static function getDataProviderForIsValidWhenEmpty(): array
    {
        return [
            [''],
            ['0'],
        ];
    }

    public static function getDataProviderForIsValidWhenIncorrectCheckDigit(): array
    {
        return [
            ['012345678901234'],
            ['123456789012345'],
            ['407760324100018'],
            ['308760324100018'],
            ['307770324100018'],
        ];
    }

    public static function getDataProviderForIsValidWhenInvalidFormat(): array
    {
        return [
            [' '],
            ['0.'],
            ['0.0'],
            ['.0'],
            ['a123'],
            ['123-'],
        ];
    }

    public static function getDataProviderForIsValidWhenInvalidLength(): array
    {
        return [
            ['00000000000000'],
            ['01234567890123'],
            ['12345678901234'],
            ['0000000000000000'],
            ['0123456789012345'],
            ['1234567890123456'],
        ];
    }
}
