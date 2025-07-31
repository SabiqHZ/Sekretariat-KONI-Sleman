<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdministrasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {

            if( $request->user()->role === 'administrasi') {
                
                
                return $next($request);
            }
            
            else if ($request->user()->role === 'Keuangan') {

                return to_route('keuangan.dashboard');
            }

            else if ($request->user()->role === 'aset') {

                return to_route('aset.dashboard');
            }

        }

        return to_route('Beranda');

    }
}
