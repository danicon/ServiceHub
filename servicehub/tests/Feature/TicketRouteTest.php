<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_tickets(): void
    {
        $response = $this->get('/tickets');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_tickets(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_ticket(): void
    {
        $user    = User::factory()->create();
        $company = Company::factory()->create();
        $project = Project::factory()->create(['company_id' => $company->id]);

        $response = $this->actingAs($user)->post('/tickets', [
            'project_id'  => $project->id,
            'title'       => 'Erro no sistema',
            'description' => 'Descrição do erro',
            'priority'    => 'high',
        ]);

        $response->assertRedirect('/tickets');
        $this->assertDatabaseHas('tickets', ['title' => 'Erro no sistema']);
    }

    public function test_ticket_creation_requires_title(): void
    {
        $user    = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user)->post('/tickets', [
            'project_id' => $project->id,
            'title'      => '',
            'priority'   => 'low',
        ]);

        $response->assertSessionHasErrors('title');
    }
}