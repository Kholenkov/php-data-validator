<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Russia;

use InvalidArgumentException;

class TaxpayerCode
{
    public static function calculateCheckDigit(string $code, array $coefficients): int
    {
        $sum = 0;
        foreach ($coefficients as $i => $k) {
            $sum += (int) $k * (int) $code[(int) $i];
        }
        return $sum % 11 % 10;
    }

    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty taxpayer code', 1);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Taxpayer code can only consist of digits', 2);
        } elseif (!in_array($length = strlen($code), [10, 12])) {
            throw new InvalidArgumentException('Taxpayer code can only consist of 10 or 12 digits', 3);
        }

        switch ($length) {
            case 10:
                $checkDigit10 = self::calculateCheckDigit($code, [2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if ($checkDigit10 !== (int) $code[9]) {
                    throw new InvalidArgumentException('Incorrect check digit of taxpayer code', 4);
                }
                break;
            case 12:
                $checkDigit11 = self::calculateCheckDigit($code, [7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                $checkDigit12 = self::calculateCheckDigit($code, [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8]);
                if ($checkDigit11 !== (int) $code[10] || $checkDigit12 !== (int) $code[11]) {
                    throw new InvalidArgumentException('Incorrect check digit of taxpayer code', 4);
                }
                break;
        }

        return true;
    }
}
