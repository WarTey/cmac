<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

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
            'chapter_id' => Chapter::all()->random()->id
        ];
    }
}
