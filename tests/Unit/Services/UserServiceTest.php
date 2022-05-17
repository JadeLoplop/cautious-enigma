<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;

class UserServiceTest extends TestCase
{
    // DatabaseMigrations //ecounter 'There is no active transaction' -. not familliar with this. So I remove it on the trait for the meantime
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();


    }

    public function test_it_can_return_a_paginated_list_of_users()
    {
        User::factory()->count(20)->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('users', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertJsonStructure([
            'current_page'
        ]);
        $response->assertOk();
    }
    public function test_it_can_store_a_user_to_database()
    {
        $data = [
            'prefixname' => $this->faker->randomElement(['Mr', 'Ms', 'Mrs']),
            'firstname' =>  $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('users/create', $data ,array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertCreated();
        $this->assertDatabaseHas('users',[
            'prefixname' => $data['prefixname'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'username' => $data['username'],
        ]);

    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_find_and_return_an_existing_user()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(route('users.show', $user),array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertOk();
        $response->assertJson([
            'prefixname' => $user['prefixname'],
            'firstname' => $user['firstname'],
            'middlename' => $user['middlename'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'username' => $user['username'],
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_update_an_existing_user()
    {
        $user = User::factory()->create();
        $data = [
            'prefixname' => $this->faker->randomElement(['Mr', 'Ms', 'Mrs']),
            'firstname' =>  $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(route('users.update', $user), $data ,array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertOk();
        $this->assertDatabaseHas('users',[
            'prefixname' => $data['prefixname'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_soft_delete_an_existing_user()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(route('users.destroy', $user), $data = [] ,array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertSuccessful();
        $this->assertSoftDeleted('users',[
            'prefixname' => $user['prefixname'],
            'firstname' => $user['firstname'],
            'middlename' => $user['middlename'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'username' => $user['username'],
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_return_a_paginated_list_of_trashed_users()
    {
        User::factory()->count(20)->create([
            'deleted_at' => now()
        ]);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('users/trashed', array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertJsonStructure([
            'current_page'
        ]);
        $response->assertOk();
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_restore_a_soft_deleted_user()
    {
	    $user = User::factory()->create([
            'deleted_at' => now()
        ]);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(route('users.restore', $user), $data = [], array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertOk();
        $this->assertDatabaseHas('users',[
            'prefixname' => $user['prefixname'],
            'firstname' => $user['firstname'],
            'middlename' => $user['middlename'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'username' => $user['username'],
            'deleted_at' => null,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_permanently_delete_a_soft_deleted_user()
    {
        $user = User::factory()->create([
            'deleted_at' => now()
        ]);
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(route('users.delete', $user), $data = [] ,array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertOk();
        $this->assertDatabaseMissing('users',[
            'prefixname' => $user['prefixname'],
            'firstname' => $user['firstname'],
            'middlename' => $user['middlename'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'username' => $user['username'],
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function test_it_can_upload_photo()
    {
        $data = [
            'prefixname' => $this->faker->randomElement(['Mr', 'Ms', 'Mrs']),
            'firstname' =>  $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'photo' => $this->faker->image('public/storage/uploads/users',400,300, null, false)
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('users/create', $data ,array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $response->assertCreated();
        $this->assertDatabaseHas('users',[
            'prefixname' => $data['prefixname'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
    }
}
