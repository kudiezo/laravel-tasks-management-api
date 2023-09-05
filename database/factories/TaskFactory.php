<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'completed' => $this->faker->boolean(),
            'completed_at' => $this->faker->optional()->dateTime(),
            'deleted_at' => $this->faker->optional()->dateTime(),
            'user_id' => $this->faker->numberBetween(1, DB::table('users')->max('id')),
        ];
    }
}
