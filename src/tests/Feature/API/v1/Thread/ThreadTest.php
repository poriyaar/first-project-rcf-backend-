<?php

namespace Tests\Feature\API\v1\Thread;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
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
        $response = $this->get(route('threads.index' , $thread->slug));

        $response->assertStatus(Response::HTTP_OK);
    }
}
