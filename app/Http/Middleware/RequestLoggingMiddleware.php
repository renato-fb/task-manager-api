<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;

class RequestLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log apenas requisições para endpoints de tasks
        if ($this->shouldLog($request)) {
            $this->logRequest($request, $response);
        }

        return $response;
    }

    /**
     * Determine if the request should be logged
     */
    private function shouldLog(Request $request): bool
    {
        $path = $request->path();
        return str_starts_with($path, 'tasks') || str_starts_with($path, 'logs');
    }

    /**
     * Log the request details
     */
    private function logRequest(Request $request, $response): void
    {
        try {
            $logData = [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'request_data' => $this->getRequestData($request),
                'response_data' => $this->getResponseData($response),
            ];

            Log::create([
                'action' => 'api_request',
                'entity_type' => 'Request',
                'entity_id' => null,
                'details' => $logData,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the main flow
            \Log::error('Failed to log request: ' . $e->getMessage());
        }
    }

    /**
     * Get sanitized request data
     */
    private function getRequestData(Request $request): array
    {
        $data = $request->all();
        
        // Remove sensitive data
        unset($data['password'], $data['password_confirmation'], $data['token']);
        
        return $data;
    }

    /**
     * Get sanitized response data
     */
    private function getResponseData($response): array
    {
        $content = $response->getContent();
        $data = json_decode($content, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            // Limit response data size
            if (isset($data['data']) && is_array($data['data'])) {
                $data['data'] = array_slice($data['data'], 0, 5); // Limit to 5 items
            }
            return $data;
        }
        
        return ['content' => substr($content, 0, 500)]; // Limit to 500 chars
    }
}
