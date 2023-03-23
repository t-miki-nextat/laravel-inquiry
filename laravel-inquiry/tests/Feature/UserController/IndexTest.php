<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';

    /** @testdox authenticated user is allowed to log-in. */
    public function testIndexAuthenticated(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(self::INDEX_PATH);
        $response->assertOk();
    }

    /** @testdox unauthenticated user may not be allowed to log-in. */
    public function testIndexNotAuthenticated(): void
    {
        $response = $this->get(self::INDEX_PATH);
        $response->assertRedirect(self::LOGIN_PATH);
    }
}
