<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Companies/Index', [
            'companies' => Company::withCount('projects')->latest()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Companies/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:companies,email'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        Company::create($request->only('name', 'email', 'phone'));

        return redirect()->route('companies.index');
    }

    public function show(Company $company): Response
    {
        return Inertia::render('Companies/Show', [
            'company'  => $company->load('projects'),
        ]);
    }

    public function edit(Company $company): Response
    {
        return Inertia::render('Companies/Edit', [
            'company' => $company,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:companies,email,'. $company->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $company->update($request->only('name', 'email', 'phone'));

        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }
}