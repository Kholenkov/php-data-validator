<?php

declare(strict_types=1);

namespace Kholenkov\DataValidator\Russia;

use InvalidArgumentException;

class TaxpayerRegistrationReasonCode
{
    public static function isValid(string $code): true
    {
        if (!$code) {
            throw new InvalidArgumentException('Empty taxpayer registration reason code', 1);
        } elseif (!preg_match('/^[0-9]{4}[0-9A-Z]{2}[0-9]{3}$/', $code)) {
            throw new InvalidArgumentException(
                'Invalid taxpayer registration reason code (can only consist of 9 digits or capital letters from A to Z)',
                2,
            );
        }

        return true;
    }
}
