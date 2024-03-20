<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form>
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // 'user_id' => $this->faker->numberBetween(1, 10),
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'style' => json_encode([
                'font' => $this->faker->word(),
                'font_color' => $this->faker->hexColor(),
                'background_color' => $this->faker->hexColor(),
            ]),
            'webhook_url' => $this->faker->url(),
        ];
    }
}
