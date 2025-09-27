<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Log;

class LogTest extends TestCase
{
    /**
     * Test listing logs
     */
    public function test_can_list_logs()
    {
        $response = $this->getJson('/api/logs');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'message'
                ]);
    }

    /**
     * Test showing a specific log
     */
    public function test_can_show_specific_log()
    {
        // Create a log first
        $log = Log::create([
            'action' => 'created',
            'entity_type' => 'Task',
            'entity_id' => 1,
            'details' => json_encode(['title' => 'Test Task']),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Test Agent'
        ]);

        $response = $this->getJson("/api/logs?id={$log->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $log->id,
                        'action' => 'created',
                        'entity_type' => 'Task',
                        'entity_id' => 1
                    ]
                ]);
    }

    /**
     * Test log not found
     */
    public function test_log_not_found()
    {
        $response = $this->getJson('/api/logs?id=999');

        $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Log não encontrado'
                ]);
    }
}
