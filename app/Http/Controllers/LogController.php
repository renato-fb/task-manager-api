<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Logs",
 *     description="Operações relacionadas a logs de eventos"
 * )
 */
class LogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/logs",
     *     summary="Listar logs de eventos",
     *     tags={"Logs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID específico do log (opcional)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de logs",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Log"))
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Log::query();

            // Se um ID específico foi fornecido, retornar apenas esse log
            if ($request->has('id')) {
                $log = $query->where('id', $request->id)->first();
                
                if (!$log) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Log não encontrado'
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $log,
                    'message' => 'Log encontrado'
                ], 200);
            }

            // Caso contrário, retornar os últimos 30 logs
            $logs = $query->orderBy('created_at', 'desc')
                         ->limit(30)
                         ->get();

            return response()->json([
                'success' => true,
                'data' => $logs,
                'message' => 'Logs listados com sucesso'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
