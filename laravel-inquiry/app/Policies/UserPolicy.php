<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param User $user_model
     * @return bool
     */
    public function edit(User $user, User $user_model): bool
    {
        return $user->id == $user_model->id;
    }
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
