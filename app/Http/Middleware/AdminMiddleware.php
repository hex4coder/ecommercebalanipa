<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user == null) {
            // belum login
            return redirect('/login');
        } else {
            // sudah login
            $role = $user->role;
            if($role != 0) {
                // bukan admin

                // customer
                if($role == 1) {
                    return redirect('/customer-panel');
                }

                return redirect('/');
            }
        }
        return $next($request);
    }
}
