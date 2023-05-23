<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class IPRestrictionMiddleware
{
    // Define the allowed IP range
    private $allowedIPRange = '36.71.82.';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestIP = $request->ip();

        // Check if the request IP matches the allowed IP range
        if (!Str::startsWith($requestIP, $this->allowedIPRange)) {
            abort(403, 'Access Denied'); // Return 403 Forbidden if IP is not allowed
        }
        return $next($request);
    }
}
