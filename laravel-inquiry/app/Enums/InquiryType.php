<?php

declare(strict_types=1);

namespace App\Enums;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

enum InquiryType: string
{
    case ESTIMATE = 'estimate';
    case RECRUIT = 'recruit';
    case OTHER = 'other';

    /**
     * @return string
     */
    public function text(): string
    {
        return match ($this) {
            self::ESTIMATE => 'お見積り',
            self::RECRUIT => '採用',
            self::OTHER => 'その他',
        };
    }

}

