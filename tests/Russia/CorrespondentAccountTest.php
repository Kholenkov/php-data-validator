<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Russia;

use InvalidArgumentException;
use Kholenkov\DataValidator\Russia\CorrespondentAccount;
use PHPUnit\Framework\TestCase;

class CorrespondentAccountTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code, string $bankCode): void
    {
        self::assertTrue(CorrespondentAccount::isValid($code, $bankCode));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(11);
        $this->expectExceptionMessage('Empty correspondent account');

        CorrespondentAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(14);
        $this->expectExceptionMessage('Incorrect check digit of correspondent account');

        CorrespondentAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(12);
        $this->expectExceptionMessage('Correspondent account can only consist of digits');

        CorrespondentAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(13);
        $this->expectExceptionMessage('Correspondent account can only consist of 20 digits');

        CorrespondentAccount::isValid($code, $bankCode);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['00000000000000000000', '000000000'],
            ['30101810200000000827', '044030827'],
        ];
    }

    public static function getDataProviderForIsValidWhenEmpty(): array
    {
        return [
            ['', '000000000'],
            ['0', '000000000'],
        ];
    }

    public static function getDataProviderForIsValidWhenIncorrectCheckDigit(): array
    {
        return [
            ['01234567890123456789', '000000000'],
            ['12345678901234567890', '000000000'],
            ['40101810200000000827', '044030827'],
            ['30201810200000000827', '044030827'],
            ['30102810200000000827', '044030827'],
        ];
    }

    public static function getDataProviderForIsValidWhenInvalidFormat(): array
    {
        return [
            [' ', '000000000'],
            ['0.', '000000000'],
            ['0.0', '000000000'],
            ['.0', '000000000'],
            ['a123', '000000000'],
            ['123-', '000000000'],
        ];
    }

    public static function getDataProviderForIsValidWhenInvalidLength(): array
    {
        return [
            ['0000000000000000000', '000000000'],
            ['0123456789012345678', '000000000'],
            ['1234567890123456789', '000000000'],
            ['000000000000000000000', '000000000'],
            ['012345678901234567890', '000000000'],
            ['123456789012345678901', '000000000'],
        ];
    }
}
