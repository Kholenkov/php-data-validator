<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Russia;

use InvalidArgumentException;
use Kholenkov\DataValidator\Russia\TaxpayerRegistrationReasonCode;
use PHPUnit\Framework\TestCase;

class TaxpayerRegistrationReasonCodeTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code): void
    {
        self::assertTrue(TaxpayerRegistrationReasonCode::isValid($code));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('Empty taxpayer registration reason code');

        TaxpayerRegistrationReasonCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage('Invalid taxpayer registration reason code (can only consist of 9 digits or capital letters from A to Z)');

        TaxpayerRegistrationReasonCode::isValid($code);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['000000000'],
            ['012345678'],
            ['123456789'],
            ['0000AZ000'],
        ];
    }

    public static function getDataProviderForIsValidWhenEmpty(): array
    {
        return [
            [''],
            ['0'],
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

            ['01234567'],
            ['12345678'],
            ['0123456789'],
            ['1234567890'],
            ['0000aZ000'],
            ['0000A-000'],
        ];
    }
}
