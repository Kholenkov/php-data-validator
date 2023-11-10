<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Ru;

use InvalidArgumentException;

class EntrepreneurCode
{
    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty entrepreneur code', 1);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Entrepreneur code can only consist of digits', 2);
        } elseif (15 !== strlen($code)) {
            throw new InvalidArgumentException('Entrepreneur code can only consist of 15 digits', 3);
        }

        $checkDigit15 = (int) substr(
            bcsub(
                substr($code, 0, -1),
                bcmul(
                    bcdiv(substr($code, 0, -1), '13'),
                    '13',
                ),
            ),
            -1,
        );
        if ($checkDigit15 !== (int) $code[14]) {
            throw new InvalidArgumentException('Incorrect check digit of entrepreneur code', 4);
        }

        return true;
    }
}
