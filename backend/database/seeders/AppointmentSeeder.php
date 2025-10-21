<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $professional = User::where('role', 'professional')->first();
        $receptionist = User::where('role', 'receptionist')->first();
        $services = Service::all();

        if ($services->isEmpty()) {
            return;
        }

        foreach (range(1, 10) as $index) {
            $service = $services->random();
            $scheduledAt = Carbon::now()->addDays($index)->setTime(9 + $index % 8, 0);

            Appointment::create([
                'customer_name' => 'Cliente '. $index,
                'customer_phone' => '1190000'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                'scheduled_at' => $scheduledAt,
                'notes' => $index % 3 === 0 ? 'Cliente prefere atendimento matinal.' : null,
                'status' => AppointmentStatus::Scheduled,
                'service_id' => $service->id,
                'professional_id' => $professional?->id,
                'created_by' => $receptionist?->id,
            ]);
        }
    }
}
