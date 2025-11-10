<?php

namespace App\Http\Controllers;

use App\Models\Surats;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupervisorController extends Controller
{
    public function show(Surats $surat): View
    {
        $this->ensureSupervisorAccess();

        return view('administrasi.surat.show', compact('surat'));
    }

    public function edit(): never
    {
        abort(403, 'Anda tidak memiliki akses');
    }

    private function ensureSupervisorAccess(): void
    {
        if (Auth::user()?->role !== 'supervisor') {
            abort(403, 'Anda tidak memiliki akses');
        }
    }
}
