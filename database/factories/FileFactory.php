<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'title' => $this->faker->sentence(),
            'name' => $this->faker->sentence(),
            'content_id' => Content::all()->random()->id
        ];
    }
}
