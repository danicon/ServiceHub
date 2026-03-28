<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id', 'technical_notes',
        'enriched_data', 'responsible_email', 'processed_at'
    ];

    protected $casts = [
        'enriched_data' => 'array',
        'processed_at'  => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}