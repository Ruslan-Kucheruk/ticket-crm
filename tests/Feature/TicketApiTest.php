<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ticket;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_ticket_can_be_created(): void
    {
        $response = $this->postJson('/api/tickets', [
            'name' => 'Ruslan',
            'phone' => '+380507301111',
            'email' => 'ruslan@test.com',
            'subject' => 'Test subject',
            'message' => 'Test message',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('customers', [
            'email' => 'ruslan@test.com',
        ]);

        $this->assertDatabaseHas('tickets', [
            'subject' => 'Test subject',
            'message' => 'Test message',
        ]);
    }

    public function test_customer_cannot_create_more_than_one_ticket_per_day(): void
    {
        $payload = [
            'name' => 'Ruslan',
            'phone' => '+380507301111',
            'email' => 'ruslan@test.com',
            'subject' => 'First subject',
            'message' => 'First message',
        ];

        $this->postJson('/api/tickets', $payload)
            ->assertCreated();

        $this->postJson('/api/tickets', [
            ...$payload,
            'subject' => 'Second subject',
            'message' => 'Second message',
        ])->assertStatus(429);

        $this->assertDatabaseCount('tickets', 1);
    }

    public function test_statistics_endpoint_returns_counts(): void
    {
        Ticket::factory()->count(3)->create();

        $response = $this->getJson('/api/tickets/statistics');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'day',
                    'week',
                    'month',
                ],
            ]);
    }
}
