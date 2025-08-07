<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureProfitRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is coming from the Laravel scheduler
        if ($request->header('User-Agent') === 'Laravel-Scheduler') {
            return $next($request);
        }
        
        // Check if the request has a valid API key
        $apiKey = env('PROFIT_ROUTE_API_KEY', 'your-secure-api-key-here');
        
        if ($request->query('api_key') !== $apiKey) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
} 