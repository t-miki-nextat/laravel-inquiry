<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Http\Requests\User\StorePost;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;


    public const INDEX_PATH = 'admin/users';
    public const SIGNUP_PATH = 'admin/users/create';
    public const LOGIN_PATH = '/login';

    /** @testdox unauthenticated user may not be allowed to log-in. */
    public function testStoreNotAuthenticated(): void
    {
        $response = $this->get(self::SIGNUP_PATH);
        $response->assertRedirect(self::LOGIN_PATH);
    }

    /** @testdox authenticated user can post new user to database. */
    public function testStoreAuthenticated(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'test',
            'email' => 'email@example.com',
            'password' => '0123456',
        ];
        $response = $this->actingAs($user)
            ->post(route('admin.users.store'), $data);
        $response->assertRedirect(self::INDEX_PATH);

        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @testdox invalid post request may not be allowed with being followed by right error messages
     * @dataProvider dataProvideInvalidStoreUser
     * @param array $storeUser
     * @param array $errorMessage
     * @return void
     */
    public function testStoreInvalidRequest(array $storeUser, array $errorMessage): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->storeRequest($storeUser);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorMessage);
    }

    /** @testdox check right redirection is returning when valid post request is sent */
    public function testStoreValidRequest(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->storeRequest();
        $response->assertRedirect(self::INDEX_PATH);
    }

    /**
     * @param array|null $storeUser
     * @return TestResponse
     */
    public function storeRequest(array $storeUser = null): TestResponse
    {
        return $this->json(
            'post',
            "/admin/users/create",
            $storeUser ?? $this->baseStoreUser()
        );
    }

    /** @return iterable */
    public function dataProvideInvalidStoreUser(): iterable
    {
        yield 'value is null' => [
            'storeUser' => array_merge(
                $this->baseStoreUser(),
                [
                    'name' => null,
                    'email' => null,
                    'password' => null,
                ]
            ),
            'errorMessage' => [
                'name' => '名前は必ず指定してください。',
                'email' => 'メールアドレスは必ず指定してください。',
                'password' => 'パスワードは必ず指定してください。',
            ]
        ];

        yield 'number of characters is above 255' => [
            'storeUser' => array_merge(
                $this->baseStoreUser(),
                [
                    'name' => str_repeat('a', 256),
                    'email' => str_repeat('a', 256),
                ]
            ),
            'errorMessage' => [
                'name' => '名前は、255文字以下で指定してください。',
                'email' => 'メールアドレスは、255文字以下で指定してください。'
            ]
        ];

        yield 'value is not string' => [
            'storeUser' => array_merge(
                $this->baseStoreUser(),
                [
                    'name' => true,
                    'email' => true,
                    'password' => true,
                ]
            ),
            'errorMessage' => [
                'name' => '名前は文字列を指定してください。',
                'email' => 'メールアドレスは文字列を指定してください。',
                'password' => 'パスワードは文字列を指定してください。',
            ]
        ];
    }

    /** @return array */
    private function baseStoreUser(): array
    {
        return [
            'name' => 'test',
            'email' => 'example@com',
            'password' => 'test'
        ];
    }
}
