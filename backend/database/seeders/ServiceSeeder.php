<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Corte Feminino',
                'description' => 'Corte feminino com finalização.',
                'duration_minutes' => 60,
                'base_price' => 80,
            ],
            [
                'name' => 'Corte Masculino',
                'description' => 'Corte masculino tradicional.',
                'duration_minutes' => 40,
                'base_price' => 45,
            ],
            [
                'name' => 'Coloração Completa',
                'description' => 'Coloração completa com retoque de raiz.',
                'duration_minutes' => 120,
                'base_price' => 220,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service + ['is_active' => true]);
        }
    }
}
