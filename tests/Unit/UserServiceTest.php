<?php

namespace Tests\Unit;

use App\Mail\UserCreated;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    public function setup(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
    }



    public function testIndexWithoutFilters()
    {
        $loggedUser  = User::factory()->create();
        Auth::login($loggedUser);

        User::create(['name' => 'John Doe', 'email' => '0k3t8@example.com', 'password' => '123456', 'manager_id' => $loggedUser->id]);
        User::create(['name' => 'Jane Doe', 'email' => 'jane.doe', 'password' => '123456', 'manager_id' => $loggedUser->id]);
        User::create(['name' => 'Alice Smith', 'email' => 'alice.smith', 'password' => '123456', 'manager_id' => $loggedUser->id]);

        $result = $this->userService->index([]);


        $this->assertCount(4, $result);
    }

    public function testIndexWithFilters()
    {
        $loggedUser  = User::factory()->create();
        Auth::login($loggedUser);

        User::create(['name' => 'John Doe', 'email' => '0k3t8@example.com', 'password' => '123456', 'manager_id' => $loggedUser->id]);
        User::create(['name' => 'Jane Doe', 'email' => 'jane.doe', 'password' => '123456', 'manager_id' => $loggedUser->id]);
        User::create(['name' => 'Alice Smith', 'email' => 'alice.smith', 'password' => '123456', 'manager_id' => $loggedUser->id]);

        $result = $this->userService->index(['search' => 'Doe']);

        $this->assertCount(2, $result);
    }

    public function testStore()
    {
        $loggedUser  = User::factory()->create();
        Auth::login($loggedUser);

        Mail::fake();
        $data = ['name' => 'New User', 'email' => 'newuser@example.com', 'manager_id' => $loggedUser->id];
        $user = $this->userService->store($data);

        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);

        Mail::assertSent(\App\Mail\UserCreated::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function testUpdate()
    {
        $loggedUser  = User::factory()->create();
        Auth::login($loggedUser);
        $user = User::create(['name' => 'John Doe', 'email' => '0k3t8@example.com', 'password' => '123456', 'manager_id' => $loggedUser->id]);

        $data = ['name' => 'Updated Name'];
        $result = $this->userService->update($data, $user->id);

        $this->assertTrue($result);
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function testDestroy()
    {
        $loggedUser  = User::factory()->create();
        Auth::login($loggedUser);
        $user = User::create(['name' => 'John Doe', 'email' => '0k3t8@example.com', 'password' => '123456', 'manager_id' => $loggedUser->id]);

        $result = $this->userService->destroy($user->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
