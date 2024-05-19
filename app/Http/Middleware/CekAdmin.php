<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

class CekAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->level !== 'admin') {
            if (Route::currentRouteName() !== 'login') {
                return redirect('/')->withErrors(['error' => 'Only admin can do this!']);
            }
        }

        return $next($request);
    }
}
