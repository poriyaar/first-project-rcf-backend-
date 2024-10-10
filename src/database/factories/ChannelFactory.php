<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Channel::class;


    public function definition()
    {
        $name  = $this->faker->sentence(4);
        return [
            'name' => $name,
            'slug' => Str::slug($name)
        ];
    }
}
