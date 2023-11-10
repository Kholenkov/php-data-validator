<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Ru;

use InvalidArgumentException;
use Kholenkov\DataValidator\Ru\TaxpayerCode;
use PHPUnit\Framework\TestCase;

class TaxpayerCodeTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code): void
    {
        self::assertTrue(TaxpayerCode::isValid($code));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('Empty taxpayer code');

        TaxpayerCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('Incorrect check digit of taxpayer code');

        TaxpayerCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage('Taxpayer code can only consist of digits');

        TaxpayerCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage('Taxpayer code can only consist of 10 or 12 digits');

        TaxpayerCode::isValid($code);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['0000000000'],
            ['7827004526'],

            ['000000000000'],
            ['760307073214'],
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
            ['0123456789'],
            ['1234567890'],
            ['8827004526'],
            ['7837004526'],
            ['7827104526'],

            ['012345678901'],
            ['123456789012'],
            ['860307073214'],
            ['761307073214'],
            ['760317073214'],
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
            ['000000000'],
            ['012345678'],
            ['123456789'],
            ['00000000000'],
            ['01234567890'],
            ['12345678901'],
            ['0000000000000'],
            ['0123456789012'],
            ['1234567890123'],
        ];
    }
}
