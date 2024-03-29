<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isBendahara
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->id_jabatan == 3 || auth()->user()->role == 1) {
            return $next($request);
        }
        return redirect('home');
    }
}
