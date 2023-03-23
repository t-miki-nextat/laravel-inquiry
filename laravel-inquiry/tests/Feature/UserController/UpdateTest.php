<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';
    public const EDIT_PATH = 'admin/users/';

    /** @testdox unauthenticated user may not be allowed to log-in. */
    public function testUpdateNotAuthenticated(): void
    {
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->get(self::EDIT_PATH . $user->id);
        $response->assertRedirect(self::LOGIN_PATH);
    }

    /** @testdox authenticated user can update database. */
    public function testUpdateAuthenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $data = [
            'name' => 'test',
            'email' => 'email@example.com',
        ];
        $response = $this->actingAs($user)
            ->put(self::EDIT_PATH . $user->id, $data);
        $response->assertRedirect(self::INDEX_PATH);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'test',
            'email' => 'email@example.com',
        ]);
    }


    /**
     * @testdox invalid put request may not be allowed with being followed by right error messages
     * @dataProvider dataProvideInvalidPutUser
     * @param array $putUser
     * @param array $errorMessage
     * @return void
     */
    public function testUpdateInvalidRequest(array $putUser, array $errorMessage): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putRequest($putUser);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorMessage);
    }

    /** @testdox check right redirection is returning when valid post request is sent */
    public function testUpdateValidRequest(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson(self::EDIT_PATH . $user->id, $this->basePutUser());
        $response->assertRedirect(self::INDEX_PATH);
    }

    /** @testdox user email should be unique */
    public function testEmailUniqueness(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $response = $this->actingAs($user)
            ->putJson(self::EDIT_PATH . $user->id, $data);
        $response->assertStatus(422);
    }


    /**
     * @param array|null $putUser
     * @return TestResponse
     */
    public function putRequest(array $putUser = null): TestResponse
    {
        return $this->json(
            'put',
            self::EDIT_PATH . 4,
            $putUser ?? $this->basePutUser()
        );
    }

    /** @return iterable */
    public function dataProvideInvalidPutUser(): iterable
    {
        yield 'value is null' => [
            'putUser' => array_merge(
                $this->basePutUser(),
                [
                    'id' => 4,
                    'name' => null,
                    'email' => null,
                ]
            ),
            'errorMessage' => [
                'name' => '名前は必ず指定してください。',
                'email' => 'メールアドレスは必ず指定してください。',
            ]
        ];

        yield 'number of characters is above 255' => [
            'putUser' => array_merge(
                $this->basePutUser(),
                [
                    'id' => 4,
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
            'putUser' => array_merge(
                $this->basePutUser(),
                [
                    'id' => 4,
                    'name' => true,
                    'email' => true,
                ]
            ),
            'errorMessage' => [
                'name' => '名前は文字列を指定してください。',
                'email' => 'メールアドレスは文字列を指定してください。',
            ]
        ];
    }

    /** @return array */
    private function basePutUser(): array
    {
        return [
            'name' => 'test',
            'email' => 'example@com',
        ];
    }
}
