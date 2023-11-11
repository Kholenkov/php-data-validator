<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Russia;

use InvalidArgumentException;

class BankCode
{
    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty bank code', 1);
        } elseif (preg_match('/[^0-9]/', $code)) {
            throw new InvalidArgumentException('Bank code can only consist of digits', 2);
        } elseif (9 !== strlen($code)) {
            throw new InvalidArgumentException('Bank code can only consist of 9 digits', 3);
        }

        return true;
    }
}
