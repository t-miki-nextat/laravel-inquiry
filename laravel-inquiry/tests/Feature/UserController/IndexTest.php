<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';

    /**
     * A basic feature test example.
     */
    public function testIndexAuthenticated(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(self::INDEX_PATH);
        $response->assertOk();
    }

    public function testIndexNotAuthenticated(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $response = $this->get(self::INDEX_PATH);
        $response->assertRedirect(self::LOGIN_PATH);
    }

    public function testIndexPagination(): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $paginationLimit = 10;
        $additionalData = 1;
        $dataSize = $paginationLimit + $additionalData;
        $totalPage = ceil($dataSize / $paginationLimit);

        $users = User::factory($dataSize)->create();

        $viewPath = '/admin/users?page=';
        for ($i = 1; $i <= $totalPage; $i++) {
            $response = $this->get($viewPath . $i);
            $response->assertOk();
            $j = 1;
            /** @var User $user */
            foreach ($users as $user) {
                $j++;
                if ($i == ceil($j / $paginationLimit)) {
                    $response->assertSeeText($user->name);
                } else {
                    $response->assertDontSeeText($user->name);
                }
            }
        }
    }

    public function testIndexPagination_ng(): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $paginationLimit = 10;
        $additionalData = 1;
        $dataSize = $paginationLimit + $additionalData;

        $users = User::factory($dataSize)->create();

        $viewPath = '/admin/users?page=';

        $page=4;
        $response=$this->get($viewPath.$page);
        $response->assertStatus(200);

        /** @var User $user */
        foreach($users as $user) {
            $response->assertDontSeeText($user->name);
        }
    }
}
