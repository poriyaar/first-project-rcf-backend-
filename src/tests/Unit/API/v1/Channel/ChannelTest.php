<?php

namespace Tests\Unit\API\v1\Channel;

use Tests\TestCase;
use App\Models\Channel;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelControllerTest extends TestCase
{

    use RefreshDatabase;

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
         $repository = $this->postJson(route('channel.create'), [
            'name' => 'laravel'
         ]);

         $repository->assertStatus(Response::HTTP_CREATED);
    }


    public function test_create_new_channel()
    {
         $repository = $this->postJson(route('channel.create'), []);

         $repository->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $response = $this->json('PUT',route('channel.update') , []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $channel = Channel::factory()->create([
            'name' => 'laravel'
        ]);
        $response = $this->json('PUT',route('channel.update') , [
            'id' => $channel->id,
            'name' => 'VueJs',
        ]);
        $updatedChannel = Channel::find($channel->id);
        $response->assertStatus(200);
        $this->assertEquals('VueJs' , $updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->json('DELETE' , route('channel.delete'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_delete_channel()
    {
        $channel = Channel::factory()->create();
        $response = $this->json('DELETE' , route('channel.delete') ,[
            'id' => $channel->id
        ]);

        $response->assertStatus(200);
    }

}
