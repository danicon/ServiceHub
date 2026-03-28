<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use App\Jobs\ProcessTicketAttachment;
class TicketController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::with(['project.company', 'user'])
                ->latest()
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tickets/Create', [
            'projects' => Project::with('company')->get(['id', 'name', 'company_id']),
        ]);
    }

    public function store(StoreTicketRequest $request)
    {
        
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')
                ->store('attachments', 'public');
        }

        $ticket = Ticket::create($data);

        TicketDetail::create([
            'ticket_id'         => $ticket->id,
            'responsible_email' => auth()->user()->email,
        ]);

        if ($ticket->attachment_path) {
            ProcessTicketAttachment::dispatch($ticket);
        }

        return redirect()->route('tickets.index');
    }

    public function show(Ticket $ticket): Response
    {
        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket->load(['project.company', 'user.profile', 'detail']),
        ]);
    }

    public function edit(Ticket $ticket): Response
    {
        return Inertia::render('Tickets/Edit', [
            'ticket'   => $ticket->load('project'),
            'projects' => Project::with('company')->get(['id', 'name', 'company_id']),
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        if ($ticket->attachment_path) {
            Storage::disk('public')->delete($ticket->attachment_path);
        }
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}