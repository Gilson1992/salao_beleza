<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'duration_minutes' => $this->faker->randomElement([30, 45, 60, 90]),
            'base_price' => $this->faker->randomFloat(2, 30, 300),
            'is_active' => true,
        ];
    }
}
