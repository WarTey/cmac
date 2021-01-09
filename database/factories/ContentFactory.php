<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

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
            'position' => $this->faker->numberBetween(0, 100),
            'course_id' => Course::all()->random()->id
        ];
    }
}
