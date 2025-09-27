<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Task Manager API",
 *     version="1.0.0",
 *     description="API para gerenciamento de tarefas com logging de eventos"
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de desenvolvimento"
 * )
 * 
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Task",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Nova tarefa"),
 *         @OA\Property(property="description", type="string", example="Descrição da tarefa"),
 *         @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="pending"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time")
 *     ),
 *     @OA\Schema(
 *         schema="Log",
 *         type="object",
 *         @OA\Property(property="id", type="string", example="507f1f77bcf86cd799439011"),
 *         @OA\Property(property="action", type="string", example="created"),
 *         @OA\Property(property="entity_type", type="string", example="Task"),
 *         @OA\Property(property="entity_id", type="integer", example=1),
 *         @OA\Property(property="details", type="object"),
 *         @OA\Property(property="ip_address", type="string", example="127.0.0.1"),
 *         @OA\Property(property="user_agent", type="string", example="Mozilla/5.0..."),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time")
 *     )
 * )
 */
class Controller extends BaseController
{
    protected function logAction(string $action, string $entityType, ?int $entityId, array $details = [], $request = null): void
    {
        $logData = [
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => json_encode($details),
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->header('User-Agent') : null,
        ];

        try {
            \App\Models\Log::create($logData);
        } catch (\Exception $e) {
            error_log('Failed to create log entry: ' . $e->getMessage());
        }
    }
}