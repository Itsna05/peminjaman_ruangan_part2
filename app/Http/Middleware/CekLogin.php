<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next, ...$roles)
    {

        if (!session()->has('user_id')) {
            return redirect('/login');
        }

        if (!empty($roles) && !in_array(session('role'), $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
