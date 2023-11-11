<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Russia;

use InvalidArgumentException;
use Kholenkov\DataValidator\Russia\LegalEntityCode;
use PHPUnit\Framework\TestCase;

class LegalEntityCodeTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code): void
    {
        self::assertTrue(LegalEntityCode::isValid($code));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('Empty legal entity code');

        LegalEntityCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('Incorrect check digit of legal entity code');

        LegalEntityCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage('Legal entity code can only consist of digits');

        LegalEntityCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage('Legal entity code can only consist of 13 digits');

        LegalEntityCode::isValid($code);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['0000000000000'],
            ['1027812400868'],
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
            ['0123456789012'],
            ['1234567890123'],
            ['2027812400868'],
            ['1037812400868'],
            ['1027912400868'],
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
            ['000000000000'],
            ['012345678901'],
            ['123456789012'],
            ['00000000000000'],
            ['01234567890123'],
            ['12345678901234'],
        ];
    }
}
