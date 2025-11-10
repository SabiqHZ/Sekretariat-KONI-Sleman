<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $user = $request->user();

        if (! $user) {
            return to_route('Beranda');
        }

        $role = strtolower($user->role);

        if (in_array($role, ['administrasi', 'supervisor'], true)) {
            return $next($request);
        }

        return match ($role) {
            'keuangan' => to_route('keuangan.dashboard'),
            'aset'     => to_route('aset.dashboard'),
            default    => to_route('Beranda'),
        };
    }
}
