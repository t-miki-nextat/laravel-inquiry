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

    /** @testdox users whose ids are from 1 to 10 should be seen at first page
     * @dataProvider paginationTestData
     * @param int $id
     * @param string $name
     */
    public function testIndexPaginationOne(int $id, string $name): void
    {
        $userAdmin = User::factory()->create(['id' => 20]);
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $users = [
            ['id' => 1, 'name' => 'test1', 'email' => 'test@1', 'password' => '1234'],
            ['id' => 2, 'name' => 'test2', 'email' => 'test@2', 'password' => '1234'],
            ['id' => 3, 'name' => 'test3', 'email' => 'test@3', 'password' => '1234'],
            ['id' => 4, 'name' => 'test4', 'email' => 'test@4', 'password' => '1234'],
            ['id' => 5, 'name' => 'test5', 'email' => 'test@5', 'password' => '1234'],
            ['id' => 6, 'name' => 'test6', 'email' => 'test@6', 'password' => '1234'],
            ['id' => 7, 'name' => 'test7', 'email' => 'test@7', 'password' => '1234'],
            ['id' => 8, 'name' => 'test8', 'email' => 'test@8', 'password' => '1234'],
            ['id' => 9, 'name' => 'test9', 'email' => 'test@9', 'password' => '1234'],
            ['id' => 10, 'name' => 'testTenth', 'email' => 'test@10', 'password' => '1234'],
        ];
        User::query()->insert($users);

        $response = $this->get(self::VIEW_PATH . 1);
        $response->assertOk();

        $response->assertSeeText($name);
    }

    /** @testdox user whose id is 11 should be seen at second page
     * @dataProvider paginationTestData
     * @param int $id
     * @param string $name
     */
    public function testIndexPaginationTwo(int $id, string $name): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $users = [
            ['id' => 1, 'name' => 'test1', 'email' => 'test@1', 'password' => '1234'],
            ['id' => 2, 'name' => 'test2', 'email' => 'test@2', 'password' => '1234'],
            ['id' => 3, 'name' => 'test3', 'email' => 'test@3', 'password' => '1234'],
            ['id' => 4, 'name' => 'test4', 'email' => 'test@4', 'password' => '1234'],
            ['id' => 5, 'name' => 'test5', 'email' => 'test@5', 'password' => '1234'],
            ['id' => 6, 'name' => 'test6', 'email' => 'test@6', 'password' => '1234'],
            ['id' => 7, 'name' => 'test7', 'email' => 'test@7', 'password' => '1234'],
            ['id' => 8, 'name' => 'test8', 'email' => 'test@8', 'password' => '1234'],
            ['id' => 9, 'name' => 'test9', 'email' => 'test@9', 'password' => '1234'],
            ['id' => 10, 'name' => 'testTenth', 'email' => 'test@10', 'password' => '1234'],
        ];
        User::query()->insert($users);

        User::query()->create(['id' => 11, 'name' => 'testEleventh', 'email' => 'test@11', 'password' => '1234']);

        $response = $this->get(self::VIEW_PATH . 2);
        $response->assertOk();

        $response->assertSeeText('testEleventh');
        $response->assertDontSeeText($name);
    }


    /** @testdox any user does not exist on pages which is not created yet by pagination feature
     * @dataProvider paginationTestData
     * @param int $id
     * @param string $name
     */
    public function testIndexPagination_ng(int $id, string $name): void
    {
        $userAdmin = User::factory()->create();
        $this->actingAs($userAdmin);
        $this->assertTrue(Auth::check());

        $users = [
            ['id' => 1, 'name' => 'test1', 'email' => 'test@1', 'password' => '1234'],
            ['id' => 2, 'name' => 'test2', 'email' => 'test@2', 'password' => '1234'],
            ['id' => 3, 'name' => 'test3', 'email' => 'test@3', 'password' => '1234'],
            ['id' => 4, 'name' => 'test4', 'email' => 'test@4', 'password' => '1234'],
            ['id' => 5, 'name' => 'test5', 'email' => 'test@5', 'password' => '1234'],
            ['id' => 6, 'name' => 'test6', 'email' => 'test@6', 'password' => '1234'],
            ['id' => 7, 'name' => 'test7', 'email' => 'test@7', 'password' => '1234'],
            ['id' => 8, 'name' => 'test8', 'email' => 'test@8', 'password' => '1234'],
            ['id' => 9, 'name' => 'test9', 'email' => 'test@9', 'password' => '1234'],
            ['id' => 10, 'name' => 'testTenth', 'email' => 'test@10', 'password' => '1234'],
        ];
        User::query()->insert($users);

        $response = $this->get(self::VIEW_PATH . 2);
        $response->assertStatus(200);

        $response->assertDontSeeText($name);
    }


    public function paginationTestData(): iterable
    {
        yield 'id1' => [
            'id' => 1,
            'name' => 'test1',
        ];
        yield 'id2' => [
            'id' => 2,
            'name' => 'test2',
        ];
        yield 'id3' => [
            'id' => 3,
            'name' => 'test3',
        ];
        yield 'id4' => [
            'id' => 4,
            'name' => 'test4',
        ];
        yield 'id5' => [
            'id' => 5,
            'name' => 'test5',
        ];
        yield 'id6' => [
            'id' => 6,
            'name' => 'test6',
        ];
        yield 'id7' => [
            'id' => 7,
            'name' => 'test7',
        ];
        yield 'id8' => [
            'id' => 8,
            'name' => 'test8',
        ];
        yield 'id9' => [
            'id' => 9,
            'name' => 'test9',
        ];
        yield 'id10' => [
            'id' => 10,
            'name' => 'testTenth',
        ];
    }
}
