<?php

declare(strict_types=1);

namespace KholenkovTest\DataValidator\Russia;

use InvalidArgumentException;
use Kholenkov\DataValidator\Russia\BankAccount;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    /**
     * @dataProvider getDataProviderForIsValid
     */
    public function testIsValid(string $code, string $bankCode): void
    {
        self::assertTrue(BankAccount::isValid($code, $bankCode));
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenEmpty
     */
    public function testIsValidWhenEmpty(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(11);
        $this->expectExceptionMessage('Empty bank account');

        BankAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenIncorrectCheckDigit
     */
    public function testIsValidWhenIncorrectCheckDigit(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(14);
        $this->expectExceptionMessage('Incorrect check digit of bank account');

        BankAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidFormat
     */
    public function testIsValidWhenInvalidFormat(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(12);
        $this->expectExceptionMessage('Bank account can only consist of digits');

        BankAccount::isValid($code, $bankCode);
    }

    /**
     * @dataProvider getDataProviderForIsValidWhenInvalidLength
     */
    public function testIsValidWhenInvalidLength(string $code, string $bankCode): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(13);
        $this->expectExceptionMessage('Bank account can only consist of 20 digits');

        BankAccount::isValid($code, $bankCode);
    }

    public static function getDataProviderForIsValid(): array
    {
        return [
            ['00000000000000000000', '000000000'],
            ['40702810900000002851', '044030827'],
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
            ['50702810900000002851', '044030827'],
            ['40802810900000002851', '044030827'],
            ['40703810900000002851', '044030827'],
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
