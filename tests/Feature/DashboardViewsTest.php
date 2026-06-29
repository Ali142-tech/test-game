<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_chart_sections(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        $response->assertSee('Sales trend');
        $response->assertSee('svg');
        $response->assertSee('data-value');
        $response->assertSee('data-label');
    }

    public function test_user_dashboard_shows_chart_sections(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Activity overview');
        $response->assertSee('svg');
        $response->assertSee('data-value');
        $response->assertSee('data-label');
    }
}
