<?php
declare(strict_types=1);

namespace App\Enums;


enum InquiryType: string
{
    case ESTIMATE = 'estimate';
    case RECRUIT = 'recruit';
    case OTHER = 'other';

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

