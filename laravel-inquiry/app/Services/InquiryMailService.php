<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Notifications\InquiryNotification;

class InquiryMailService
{
    /**
     * メールを送る
     *
     * @param User $user
     * @param string $content
     */
    public function send(User $user, string $content): void
    {
        $user->notify(new InquiryNotification($content));
    }
}
