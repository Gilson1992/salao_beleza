<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_service(): void
    {
        $admin = User::factory()->create([
            'role' => Role::Admin,
        ]);

        $payload = [
            'name' => 'Teste Serviço',
            'description' => 'Descrição de teste',
            'duration_minutes' => 45,
            'base_price' => 99.9,
        ];

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/services', $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('services', ['name' => 'Teste Serviço']);
    }

    public function test_non_admin_cannot_create_service(): void
    {
        $user = User::factory()->create([
            'role' => Role::Professional,
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/services', [
            'name' => 'Serviço Bloqueado',
            'description' => 'Teste',
            'duration_minutes' => 30,
            'base_price' => 50,
        ]);

        $response->assertStatus(403);
    }
}
