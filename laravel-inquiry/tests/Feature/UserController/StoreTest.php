<?php

declare(strict_types=1);

namespace Tests\Feature\UserController;

use App\Http\Requests\User\StorePost;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;


    public const INDEX_PATH = 'admin/users';
    public const SIGNUP_PATH = 'admin/users/create';
    public const LOGIN_PATH = '/login';

    public function testStoreNotAuthenticated(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthenticationException::class);
        $response = $this->get(self::SIGNUP_PATH);
        $response->assertRedirect(self::LOGIN_PATH);
    }

    public function testStoreAuthenticated(): void
    {
        $this->withoutExceptionHandling();

        $user=User::factory()->create();
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

    public function testNotNullableRules(): void
    {
        $data = [
            'name' => null,
            'email' => null,
            'password' => null,
        ];
        $request = new StorePost();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'name' => ['Required' => [],],
            'email' => ['Required' => [],],
            'password' => ['Required' => [],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }
    public function testMaxDigitRules(): void
    {
        $data = [
            'name' => str_repeat('a', 256),
            'email' => str_repeat('a', 256),
            'password' => 'test',
        ];
        $request = new StorePost();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'name' => ['Max' => [255],],
            'email' => ['Max' => [255],],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }

    public function testValidStore(): void
    {
        $data = [
            'name' => 'test',
            'email' => 'email@example.com',
            'password' => '0123456',
        ];
        $request = new StorePost();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    public function testEmailUniqueness()
    {
        $user=User::factory()->create();
        /** @var User $user $data */
        $data=[
            'name'=>'test',
            'email'=>$user->email,
            'password'=>'0123456',
        ];
        $request=new StorePost();
        $rules=$request->rules();

        $validator=Validator::make($data, $rules);

        $result=$validator->passes();
        $this->assertFalse($result);
        $expectedFailed=[
            'email'=>['Unique'=>['users']],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }


}
