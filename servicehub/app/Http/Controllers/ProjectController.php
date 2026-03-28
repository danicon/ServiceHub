<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::with('company')->withCount('tickets')->latest()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Projects/Create', [
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id'  => ['required', 'exists:companies,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive,completed'],
        ]);

        Project::create($request->only('company_id', 'name', 'description', 'status'));

        return redirect()->route('projects.index');
    }

    public function show(Project $project): Response
    {
        return Inertia::render('Projects/Show', [
            'project' => $project->load(['company', 'tickets.user']),
        ]);
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('Projects/Edit', [
            'project'   => $project,
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive,completed'],
        ]);

        $project->update($request->only('name', 'description', 'status'));

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}