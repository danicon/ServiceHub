<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessTicketAttachment;
use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessTicketAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_enriches_ticket_detail_with_json(): void
    {
        Storage::fake('public');

        $ticket = Ticket::factory()->create([
            'attachment_path' => 'attachments/test.json',
        ]);

        TicketDetail::factory()->create(['ticket_id' => $ticket->id]);

        Storage::disk('public')->put(
            'attachments/test.json',
            json_encode(['sistema' => 'Windows', 'erro' => 'Timeout'])
        );

        (new ProcessTicketAttachment($ticket))->handle();

        $ticket->refresh();

        $this->assertNotNull($ticket->detail->processed_at);
        $this->assertEquals('Windows', $ticket->detail->enriched_data['sistema']);
        $this->assertEquals(
            'Processado automaticamente via fila.',
            $ticket->detail->technical_notes
        );
    }

    public function test_job_handles_txt_attachment(): void
    {
        Storage::fake('public');

        $ticket = Ticket::factory()->create([
            'attachment_path' => 'attachments/test.txt',
        ]);

        TicketDetail::factory()->create(['ticket_id' => $ticket->id]);

        Storage::disk('public')->put('attachments/test.txt', 'Erro crítico no servidor');

        (new ProcessTicketAttachment($ticket))->handle();

        $ticket->refresh();

        $this->assertArrayHasKey('raw_content', $ticket->detail->enriched_data);
    }

   public function test_job_skips_ticket_without_attachment(): void
    {
        $ticket = Ticket::factory()->create(['attachment_path' => null]);

        TicketDetail::factory()->create([
            'ticket_id'    => $ticket->id,
            'processed_at' => null,          // força null explicitamente
        ]);

        (new ProcessTicketAttachment($ticket))->handle();

        $ticket->refresh();

        $this->assertNull($ticket->detail->processed_at);
    }
}