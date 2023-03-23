<?php

declare(strict_types=1);

namespace Tests\Unit\UserController;

use App\Http\Requests\User\UpdatePut;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public const INDEX_PATH = 'admin/users';
    public const LOGIN_PATH = '/login';
    public const EDIT_PATH = 'admin/users/';

    /**
     * @testdox name and email cannot be filled with null
     * @return void
     */
    public function testNotNullableRules(): void
    {
        $data = [
            'name' => null,
            'email' => null,
        ];
        $request = new UpdatePut();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertFalse($result);
        $expectedFailed = [
            'name' => ['Required' => [],],
            'email' => ['Required' => [],],
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
        ];
        $request = new UpdatePut();
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
     * @testdox valid name, email can pass validation
     * @return void
     */
    public function testValidUpdate(): void
    {
        $data = [
            'name' => 'test',
            'email' => 'email@example.com',
        ];
        $request = new UpdatePut();
        $rules = $request->rules();

        $validator = Validator::make($data, $rules);

        $result = $validator->passes();
        $this->assertTrue($result);
    }

    /**
     * @testdox email may not be filled with string which already exists in database
     * @return void
     */
    public function testEmailUniqueness(): void
    {
        $user = User::factory()->create();
        /** @var User $user $data */
        $data = [
            'name' => 'test',
            'email' => $user->email,
        ];
        $request = new UpdatePut();
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
