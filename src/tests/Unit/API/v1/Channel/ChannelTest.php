<?php

namespace Tests\Unit\API\v1\Channel;

use Tests\TestCase;
use App\Models\Channel;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelControllerTest extends TestCase
{

    use RefreshDatabase;

    public function registerRoleAndPermissions()
    {
        $this->seed(RoleAndPermissionSeeder::class);
    }

    /**
     * Test All Channel List Should Be Accessible
     */
    public function test_all_channel_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));

        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * Test Create Channel
     */
    public function test_create_channel_should_be_validated()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $repository = $this->actingAs($user)->postJson(route('channel.create'), [
            'name' => 'laravel'
        ]);

        $repository->assertStatus(Response::HTTP_CREATED);
    }


    public function test_create_new_channel()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $repository = $this->actingAs($user)->postJson(route('channel.create'), []);

        $repository->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->json('PUT', route('channel.update'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->actingAs($user)->json('PUT', route('channel.update'), [
            'id' => $channel->id,
            'name' => 'VueJs',
        ]);
        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(200);
        $this->assertEquals('VueJs', $updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $response = $this->actingAs($user)->json('DELETE', route('channel.delete'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_delete_channel()
    {
        $this->registerRoleAndPermissions();
        $user = User::factory()->create();
        $user->givePermissionTo('channel management');

        $channel = Channel::factory()->create();
        $response = $this->actingAs($user)->json('DELETE', route('channel.delete'), [
            'id' => $channel->id
        ]);

        $response->assertStatus(200);
    }
}
