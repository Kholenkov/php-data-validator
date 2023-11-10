<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Ru;

use InvalidArgumentException;
use Kholenkov\DataValidator\Ru\SocialInsuranceCode;
use PHPUnit\Framework\TestCase;

class SocialInsuranceCodeTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code): void
    {
        self::assertTrue(SocialInsuranceCode::isValid($code));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('Empty social insurance code');

        SocialInsuranceCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('Incorrect check digit of social insurance code');

        SocialInsuranceCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        $this->expectExceptionMessage('Social insurance code can only consist of digits');

        SocialInsuranceCode::isValid($code);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage('Social insurance code can only consist of 11 digits');

        SocialInsuranceCode::isValid($code);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['00000000000'],
            ['08765430300'],
            ['55555500600'],
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
            ['01234567890'],
            ['12345678901'],
            ['18765430300'],
            ['08865430300'],
            ['08766430300'],
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
            ['0000000000'],
            ['0123456789'],
            ['1234567890'],
            ['000000000000'],
            ['012345678901'],
            ['123456789012'],
        ];
    }
}
