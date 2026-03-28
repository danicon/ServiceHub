<?php

namespace Tests\Unit\Models;

use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_belongs_to_user(): void
    {
        $ticket = Ticket::factory()->create();

        $this->assertInstanceOf(User::class, $ticket->user);
    }

    public function test_ticket_has_one_detail(): void
    {
        $ticket = Ticket::factory()->create();
        TicketDetail::factory()->create(['ticket_id' => $ticket->id]);

        $this->assertInstanceOf(TicketDetail::class, $ticket->detail);
    }

    public function test_ticket_detail_is_unique_per_ticket(): void
    {
        $ticket = Ticket::factory()->create();
        TicketDetail::factory()->create(['ticket_id' => $ticket->id]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        TicketDetail::factory()->create(['ticket_id' => $ticket->id]);
    }

    public function test_user_has_one_profile(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->profile);
        $this->assertEquals($user->id, $user->profile->user_id);
    }
}