<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{

    /** @test */
    public function all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));

        $response->assertStatus(Response::HTTP_OK);
    }


    /** @test */
    public function threads_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('threads.index', $thread->slug));

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function threads_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /** @test */
    public function can_create_thread()
    {
        // for show bug message
        // $this->withExceptionHandling();

        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('threads.store'), [
            'title' => 'Foo',
            'content' => 'Bar',
            'channel_id' => Channel::factory()->create()->id
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
}
