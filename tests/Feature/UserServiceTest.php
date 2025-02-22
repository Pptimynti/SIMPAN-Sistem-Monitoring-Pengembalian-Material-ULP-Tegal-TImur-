<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserInterface;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    use RefreshDatabase;
    private UserInterface $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserInterface::class);
    }

    public function test()
    {
        self::assertTrue(true);
    }

    public function testStore()
    {
        $data = [
            'name' => 'Dhika',
            'email' => 'dhikakr@gmail.com',
            'password' => 'dhika12345',
            'password_confirmation' => 'dhika12345',
            'role' => 'admin'
        ];
        self::assertTrue($this->userService->store($data));
    }

    public function testDestroy()
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::first();
        self::assertCount(1, User::all());
        self::assertTrue($this->userService->destroy($user->id));
        self::assertCount(0, User::all());
    }

    public function testUpdate()
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::first();
        self::assertEquals('Test User', $user->name);
        $data = [
            'name' => 'Dhika',
            'email' => 'dhikakr@gmail.com',
            'password' => 'dhika12345',
            'password_confirmation' => 'dhika12345',
            'role' => 'admin'
        ];
        self::assertTrue($this->userService->update($user->id, $data));
        self::assertEquals('Dhika', User::first()->name);
    }
}
