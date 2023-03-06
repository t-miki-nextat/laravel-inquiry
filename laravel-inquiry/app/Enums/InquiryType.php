<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InquiryType extends Enum
{
    const ESTIMATE = 0;
    const RECRUIT = 1;
    const OTHER = 2;

    public static function getDescription($value): string
    {
        if ($value === self::ESTIMATE) {
            return 'お見積り';
        }

        if ($value === self::RECRUIT) {
            return '採用';
        }

        if ($value === self::OTHER) {
            return 'その他';
        }

        return parent::getDescription($value);
    }

    public static function getValue($key): int
    {
        if ($key === 'お見積り') {
            return self::ESTIMATE;
        }

        if ($key === '採用') {
            return self::RECRUIT;
        }

        if ($key === 'その他') {
            return self::OTHER;
        }

        return parent::getValue($key);
    }
}
