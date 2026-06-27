<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Debe iniciar sesión para continuar.');
        }

        if (auth()->user()->role !== 'administrador') {
            return redirect()->route('dashboard')
                ->with('error', 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}