<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IndexPaginationTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';
    public const VIEW_PATH = '/admin/users?page=';

    /** @testdox checking */
    public function testIndexPageOne(): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        /** @var User $users */
        $users = User::factory(9)->create();

        $response = $this->get(self::VIEW_PATH . 1);
        $response->assertOk();

        /** @var User $user */
        foreach ($users as $user) {
            $response->assertSeeText($user->name);
        }
    }

    public function testIndexPageTwo(): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        User::factory(9)->create();
        /** @var User $users */
        $users = User::factory(1)->create();

        $response = $this->get(self::VIEW_PATH . 2);
        $response->assertOk();
        /** @var User $user */
        foreach ($users as $user) {
            $response->assertSeeText($user->name);
        }
    }


    /** @testdox any user does not exist on pages which is not created yet by pagination feature */
    public function testIndexPagination_ng(): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $paginationLimit = 10;
        $additionalData = 1;
        $dataSize = $paginationLimit + $additionalData;

        $users = User::factory($dataSize)->create();

        $page = 4;
        $response = $this->get(self::VIEW_PATH . $page);
        $response->assertStatus(200);

        /** @var User $user */
        foreach ($users as $user) {
            $response->assertDontSeeText($user->name);
        }
    }
}
