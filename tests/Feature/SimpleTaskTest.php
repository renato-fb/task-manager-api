<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    /**
     * Test creating a new task
     */
    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'pending'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'title' => 'Test Task',
                        'description' => 'This is a test task',
                        'status' => 'pending'
                    ]
                ]);
    }

    /**
     * Test listing tasks
     */
    public function test_can_list_tasks()
    {
        $response = $this->getJson('/api/tasks');

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
     * Test showing a specific task
     */
    public function test_can_show_task()
    {
        // Create a task first
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending'
        ]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $task->id,
                        'title' => 'Test Task',
                        'description' => 'Test Description',
                        'status' => 'pending'
                    ]
                ]);
    }

    /**
     * Test updating a task
     */
    public function test_can_update_task()
    {
        // Create a task first
        $task = Task::create([
            'title' => 'Original Title',
            'description' => 'Original description',
            'status' => 'pending'
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'status' => 'in_progress'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $task->id,
                        'title' => 'Updated Title',
                        'status' => 'in_progress'
                    ]
                ]);
    }

    /**
     * Test deleting a task
     */
    public function test_can_delete_task()
    {
        // Create a task first
        $task = Task::create([
            'title' => 'Task to delete',
            'description' => 'This task will be deleted',
            'status' => 'pending'
        ]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Tarefa excluída com sucesso'
                ]);
    }

    /**
     * Test validation errors
     */
    public function test_validation_errors()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => '', // Empty title should fail
            'status' => 'invalid_status' // Invalid status should fail
        ]);

        $response->assertStatus(422)
                ->assertJson([
                    'success' => false,
                    'message' => 'Dados de validação inválidos'
                ])
                ->assertJsonStructure(['errors']);
    }

    /**
     * Test task not found
     */
    public function test_task_not_found()
    {
        $response = $this->getJson('/api/tasks/999');

        $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Tarefa não encontrada'
                ]);
    }
}
