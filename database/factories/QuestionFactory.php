<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'type' => json_encode($this->faker->randomElement(['text', 'textarea', 'radio', 'checkbox', 'select', 'email', 'number', 'date', 'tel', 'url'])),
            'options' => json_encode($this->faker->randomElements(['Option 1', 'Option 2', 'Option 3'], 3)),
        ];
    }
}
