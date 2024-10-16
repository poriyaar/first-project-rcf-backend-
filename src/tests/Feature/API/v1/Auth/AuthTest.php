<?php

namespace Tests\Feature\API\v1\Auth;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;


    public function rolesAndPermissions()
    {
        $this->seed(RoleAndPermissionSeeder::class);
    }

    /**
     * Test Register
     */
    public function test_register_should_be_validated()
    {
        //    $response = $this->postJson('api/v1/auth/register');
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_new_user_can_register()
    {
        $this->rolesAndPermissions();
        //  $response = $this->postJson('api/v1/auth/register');
        $response = $this->postJson(route('auth.register'), [
            'name' => "poriya",
            'email' => "poriya@gmail.com",
            'password' => "123456789",
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    /**
     * Test login
     */
    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login_with_true_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => "password",
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test logged In User
     */
    public function test_show_user_info_if_logged_in()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('auth.user'));

        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * Test Logout
     */
    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('auth.logout'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
