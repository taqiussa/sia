<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class IPRestrictionMiddleware
{
    private $allowedIPs = [
        '36.71.82.141', // Example allowed IP address
        '192.168.0.1', // Another example allowed IP address
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestIP = $request->ip();

        // Check if the request IP is in the allowed IP addresses
        if (!in_array($requestIP, $this->allowedIPs)) {
            abort(403, 'Access Denied'); // Return 403 Forbidden if IP is not allowed
        }

        return $next($request);
    }
}
