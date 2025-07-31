<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AsetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {

            if( $request->user()->role === 'aset') {
                // Redirect to a 403 Forbidden page or any other action
                
                return $next($request);
            }

            else if ($request->user()->role === 'administrasi') {
                
                return to_route('administrasi.dashboard');
            }

            else if ($request->user()->role === 'Keuangan') {
                
                return to_route('keuangan.dashboard');
            }
        }

        return to_route('Beranda');

    }
}
