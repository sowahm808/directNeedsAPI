<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_applications()
    {
        // Create test data
        $applicant = User::factory()->create(['role' => 'applicant']);
        Application::factory()->count(3)->create(['applicant_id' => $applicant->id]);

        // Hit the API endpoint
        $response = $this->getJson('/api/applications');

        // Assert that the response is OK and has 3 records
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_an_application()
    {
        $applicant = User::factory()->create(['role' => 'applicant']);

        $data = [
            'applicant_id' => $applicant->id,
            'status' => 'submitted',
            'grant_amount' => 500.00,
        ];

        $response = $this->postJson('/api/applications', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['status' => 'submitted']);

        $this->assertDatabaseHas('applications', ['applicant_id' => $applicant->id]);
    }
}
