<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KeuanganMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {

            if( $request->user()->role === 'keuangan') {
                // Redirect to a 403 Forbidden page or any other action
                
                return $next($request);
            }

            else if ($request->user()->role === 'administrasi') {
                
                return redirect()->route('administrasi.dashboard');
            }

            else if ($request->user()->role === 'aset') {
                
                return redirect()->route('aset.dashboard');
            }
        }

        return redirect()->route('login')->with('error', 'You do not have access to this section.');

    }
}
