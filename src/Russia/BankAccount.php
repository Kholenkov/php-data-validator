<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Russia;

use InvalidArgumentException;

class BankAccount
{
    public static function isValid(string $code, string $bankCode): true
    {
        BankCode::isValid($bankCode);

        if (!$code) {
            throw new InvalidArgumentException('Empty bank account', 11);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Bank account can only consist of digits', 12);
        } elseif (20 !== strlen($code)) {
            throw new InvalidArgumentException('Bank account can only consist of 20 digits', 13);
        }

        $value = substr($bankCode, -3) . $code;
        $sum = 0;
        foreach ([7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1] as $i => $k) {
            $sum += $k * ((int) $value[$i] % 10);
        }
        if (0 !== $sum % 10) {
            throw new InvalidArgumentException('Incorrect check digit of bank account', 14);
        }

        return true;
    }
}
