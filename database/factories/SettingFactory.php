<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(),
            'value' => $this->faker->boolean()
        ];
    }

    /**
     * Create a maintenance mode setting
     */
    public function maintenanceMode($enabled = false): static
    {
        return $this->state(fn(array $attributes) => [
            'key' => 'maintenance_mode',
            'value' => $enabled,
        ]);
    }
}
