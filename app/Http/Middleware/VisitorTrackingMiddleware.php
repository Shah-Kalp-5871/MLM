<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorTrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        
        if ($ip) {
            $today = date('Y-m-d');
            
            \App\Models\Visitor::firstOrCreate([
                'ip_address' => $ip,
                'visit_date' => $today
            ]);
        }

        return $next($request);
    }
}
