<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_has_many_projects(): void
    {
        $company = Company::factory()->create();
        Project::factory()->count(3)->create(['company_id' => $company->id]);

        $this->assertCount(3, $company->projects);
        $this->assertInstanceOf(Project::class, $company->projects->first());
    }

    public function test_company_can_be_created_with_valid_data(): void
    {
        $company = Company::factory()->create([
            'name'  => 'KPMG Brasil',
            'email' => 'contato@kpmg.com.br',
        ]);

        $this->assertDatabaseHas('companies', [
            'name'  => 'KPMG Brasil',
            'email' => 'contato@kpmg.com.br',
        ]);
    }

    public function test_deleting_company_cascades_to_projects(): void
    {
        $company = Company::factory()->create();
        Project::factory()->count(2)->create(['company_id' => $company->id]);

        $company->delete();

        $this->assertDatabaseMissing('projects', ['company_id' => $company->id]);
    }
}