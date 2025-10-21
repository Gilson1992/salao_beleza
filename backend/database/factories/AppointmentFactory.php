<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $scheduledAt = $this->faker->dateTimeBetween('-1 week', '+1 month');

        return [
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'scheduled_at' => $scheduledAt,
            'notes' => $this->faker->boolean(40) ? $this->faker->sentence() : null,
            'status' => $this->faker->randomElement(AppointmentStatus::cases()),
            'service_id' => Service::factory(),
            'professional_id' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
}
