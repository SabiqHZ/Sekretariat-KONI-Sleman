<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;


class SupervisorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if( $request->user()->role === 'administrasi') {
            // Blokir method selain GET/HEAD/OPTIONS
            if (!in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
                abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini');
            }
        }
            return $next($request);
    }
}
