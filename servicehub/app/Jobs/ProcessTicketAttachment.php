<?php

namespace App\Jobs;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Ticket $ticket) {}

    public function handle(): void
    {
        $ticket = $this->ticket;

        if (!$ticket->attachment_path) {
            return;
        }

        $content = Storage::disk('public')->get($ticket->attachment_path);
        $enriched = null;

        // Tenta interpretar como JSON
        $decoded = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $enriched = $decoded;
        } else {
            // Se for TXT, armazena como texto simples
            $enriched = ['raw_content' => $content];
        }

        $ticket->detail()->updateOrCreate(
            ['ticket_id' => $ticket->id],
            [
                'enriched_data'     => $enriched,
                'technical_notes'   => 'Processado automaticamente via fila.',
                'responsible_email' => $ticket->user->email,
                'processed_at'      => now(),
            ]
        );

        Log::info("Ticket #{$ticket->id} processado com sucesso.");
    }
}