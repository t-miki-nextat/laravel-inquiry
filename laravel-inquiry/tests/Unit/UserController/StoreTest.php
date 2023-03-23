<?php

declare(strict_types=1);

namespace Tests\Unit\UserController;

use App\Http\Requests\User\StorePost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;


    public const INDEX_PATH = 'admin/users';
    public const SIGNUP_PATH = 'admin/users/create';
    public const LOGIN_PATH = '/login';

    /**
     * @testdox name, email and password cannot be filled with null
     * @return void
     */
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

    /**
     * @testdox name and email cannot be filled with string above 256 digits
     * @return void
     */
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

    /**
     * @testdox valid name, email and password can pass validation
     * @return void
     */
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

    /**
     * @testdox email should not be filled with string which already exists in database
     * @return void
     */
    public function testEmailUniqueness(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $data = [
            'name' => 'test',
            'email' => $user->email,
            'password' => '0123456',
        ];
        $request = new StorePost();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'email' => ['Unique' => ['users']],
        ];
        $this->assertEquals($expectedFailed, $validator->failed());
    }


}
