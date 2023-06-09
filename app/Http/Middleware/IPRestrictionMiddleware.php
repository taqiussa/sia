<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class IPRestrictionMiddleware
{
    // Define the allowed IP range
    private $allowedIPRange = '36.71.';
    // private $allowedIPRangeTu = '36.71.85.';
    // private $allowedIPRange = '182.2.38.';  
    private $allowedIPRangeLocal = '127.0.0.';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestIP = $request->ip();

        // Check if the request IP matches the allowed IP range
        if (
            Str::startsWith($requestIP, $this->allowedIPRange)
            // || Str::startsWith($requestIP, $this->allowedIPRangeTu)
            || Str::startsWith($requestIP, $this->allowedIPRangeLocal)
        ) {
            return $next($request);
        }

        abort(403, 'Terhubunglah dengan Wi-fi Ruang Guru Atau TU'); // Return 403 Forbidden if IP is not allowed
    }
}
