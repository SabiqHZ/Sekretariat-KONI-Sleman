<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $user = $request->user();

        if (! $user) {
            return to_route('login')->with('error', 'You do not have access to this section.');
        }

        $role = strtolower($user->role);

        if (in_array($role, ['keuangan', 'supervisor'], true)) {
            return $next($request);
        }

        return match ($role) {
            'administrasi' => to_route('administrasi.dashboard'),
            'aset'         => to_route('aset.dashboard'),
            default        => to_route('Beranda'),
        };
    }
}
