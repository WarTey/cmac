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
            'position' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->numberBetween(0, 20),
            'price_three_months' => $this->faker->numberBetween(0, 20),
            'price_six_months' => $this->faker->numberBetween(0, 20),
            'chapter_id' => Chapter::all()->random()->id
        ];
    }
}
