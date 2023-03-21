<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';
    public const EDIT_PATH = 'admin/users/';
    public const SIGNUP_PATH = 'admin/users/create';

    public function testUpdateNotAuthenticated(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->get(self::EDIT_PATH . $user->id);
        $response->assertRedirect(self::LOGIN_PATH);
    }

    public function testDestroyAuthenticated(): void
    {
        $data = [
            'name' => 'test',
            'email' => 'email@example.com',
            'password' => '0123456',
        ];

        $user=User::factory()->create();
        $response=$this->actingAs($user);
        $response->post(self::SIGNUP_PATH, $data);
        /** @var User $destroyable */
        $destroyable=User::query()->where('name', 'test')->first();

        $response=$this->delete(self::EDIT_PATH.$destroyable->id, ['id'=>$destroyable->id]);
        $response->assertRedirect(self::INDEX_PATH);

        $this->assertDatabaseMissing('users', [
            'id' => $destroyable->id,
            'name' => $destroyable->name,
            'email' => $destroyable->email,
        ]);
    }

}
