<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Ru;

use InvalidArgumentException;

class SocialInsuranceCode
{
    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty social insurance code', 1);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Social insurance code can only consist of digits', 2);
        } elseif (11 !== strlen($code)) {
            throw new InvalidArgumentException('Social insurance code can only consist of 11 digits', 3);
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $code[$i] * (9 - $i);
        }
        $checkDigit = 0;
        if ($sum < 100) {
            $checkDigit = $sum;
        } elseif (101 < $sum) {
            $checkDigit = $sum % 101;
            if (100 === $checkDigit) {
                $checkDigit = 0;
            }
        }
        if ($checkDigit !== (int) substr($code, -2)) {
            throw new InvalidArgumentException('Incorrect check digit of social insurance code', 4);
        }

        return true;
    }
}
