<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chapter::class;

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
            'description' => $this->faker->paragraphs(2, true),
            'image' => $this->faker->sentence(),
            'level_id' => Level::all()->random()->id
        ];
    }
}
