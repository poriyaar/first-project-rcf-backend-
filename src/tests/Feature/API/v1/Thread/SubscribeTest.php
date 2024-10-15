<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplaySubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_subscribe_channel()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();

        $response = $this->post(route('subscribe', [$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            'message' => 'user subscribe successfully'
        ]);
    }

    /** @test */
    function user_can_unsubscribe_from_a_channel()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $thread = Thread::factory()->create();

        $response = $this->post(route('unSubscribe', [$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            'message' => 'user unsubscribed successfully'
        ]);
    }

    /** @test */
    function notification_will_send_t0_subscribes_of_a_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Notification::fake();


        $thread = Thread::factory()->create();


        $subscribe_response = $this->post(route('subscribe', [$thread]));
        $subscribe_response->assertSuccessful();
        $subscribe_response->assertJson([
            'message' => 'user subscribe successfully'
        ]);

        $answer_response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id
        ]);

        $answer_response->assertSuccessful();
        $answer_response->assertJson([
            'message' => 'answer submitted successfully'
        ]);

        Notification::assertSentTo($user , NewReplaySubmitted::class);
    }
}
