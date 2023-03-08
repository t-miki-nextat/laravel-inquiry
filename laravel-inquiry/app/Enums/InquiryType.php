<?php
declare(strict_types=1);

namespace App\Enums;


enum InquiryType: string
{
    case ESTIMATE = 'お見積り';
    case RECRUIT = '採用';
    case OTHER = 'その他';

    /**
     *
     */
    public function text(): string
    {
        return match($this) {
            self::ESTIMATE => 'お見積り',
            self::RECRUIT => '採用',
            self::OTHER => 'その他',
        };
    }
}

