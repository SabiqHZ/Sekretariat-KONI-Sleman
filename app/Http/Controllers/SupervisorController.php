<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Surats;
use App\Policies\ViewerPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupervisorController extends Controller
{
    use AuthorizesRequests;

    public function show (Surats $surat)
    {
            if (!Gate::allows('viewer-access', $surat)) {
        abort(403, 'Anda tidak memiliki akses');
    }

    return view('surat.show', compact('surat'));
}

    // Atau gunakan helper
    public function edit(Surats $surat)
    {
        $this->authorize('edit-surat', $surat);
        return view('surat.edit');
    }
    
}
