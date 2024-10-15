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
    use RefreshDatabase;

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
    public function create_threads_should_be_validated()
    {
        Sanctum::actingAs(User::factory()->create());

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

    /** @test */
    public function edit_threads_should_be_validated()
    {
        // $this->withExceptionHandling();

        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();

        $response = $this->putJson(route('threads.update', $thread), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /** @test */
    public function can_update_thread()
    {
        // for show bug message
        // $this->withExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            'title' => 'Foo',
            'content' => 'Bar',
            'channel_id' => Channel::factory()->create()->id,
            'user_id' => $user->id
        ]);

        $this->putJson(route('threads.update', [$thread]), [
            'title' => 'BAR',
            'content' => 'Bar',
            'channel_id' => Channel::factory()->create()->id
        ])->assertSuccessful();

        // come back data from database
        $thread->refresh();

        $this->assertSame('BAR', $thread->title);
    }


    /** @test */
    public function can_add_best_answer_id_for_thread()
    {
        // for show bug message
        // $this->withExceptionHandling();
        // $this->withExceptionHandling();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            'user_id' => $user->id
        ]);


        $this->putJson(route('threads.update', [$thread]), [
            'best_answer_id' => 1,
        ])->assertSuccessful();

        // come back data from database
        $thread->refresh();

        $this->assertSame(1, $thread->best_answer_id);
    }



    /** @test */
    function can_delete_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->delete(route('threads.destroy', [$thread->id]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
