<?php

namespace Tests\Feature;

use App\Enums\AppointmentStatus;
use App\Enums\Role;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_professional_can_only_see_own_appointments(): void
    {
        $service = Service::factory()->create();
        $professional = User::factory()->create(['role' => Role::Professional]);
        $otherProfessional = User::factory()->create(['role' => Role::Professional]);
        $creator = User::factory()->create(['role' => Role::Receptionist]);

        Appointment::factory()->create([
            'service_id' => $service->id,
            'professional_id' => $professional->id,
            'created_by' => $creator->id,
            'status' => AppointmentStatus::Scheduled,
        ]);

        Appointment::factory()->create([
            'service_id' => $service->id,
            'professional_id' => $otherProfessional->id,
            'created_by' => $creator->id,
            'status' => AppointmentStatus::Scheduled,
        ]);

        $response = $this->actingAs($professional, 'sanctum')->getJson('/api/appointments');

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
    }
}
