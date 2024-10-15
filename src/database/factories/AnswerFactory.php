<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->realText(),
            'thread_id' => Thread::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
