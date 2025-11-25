<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil role dari session atau cara lainnya
        $userRole = session('role');

        if (! $userRole || ! in_array($userRole, $roles)) {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
