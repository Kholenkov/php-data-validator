<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Russia;

use InvalidArgumentException;

class LegalEntityCode
{
    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty legal entity code', 1);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Legal entity code can only consist of digits', 2);
        } elseif (13 !== strlen($code)) {
            throw new InvalidArgumentException('Legal entity code can only consist of 13 digits', 3);
        }

        $checkDigit13 = (int) substr(
            bcsub(
                substr($code, 0, -1),
                bcmul(
                    bcdiv(substr($code, 0, -1), '11'),
                    '11',
                ),
            ),
            -1,
        );
        if ($checkDigit13 !== (int) $code[12]) {
            throw new InvalidArgumentException('Incorrect check digit of legal entity code', 4);
        }

        return true;
    }
}
