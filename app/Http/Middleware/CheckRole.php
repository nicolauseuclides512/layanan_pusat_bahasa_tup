<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guard('web')->check() && $role === 'admin') {
            return $next($request);
        }
        if (Auth::guard('mahasiswa')->check() && $role === 'mahasiswa') {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
} 