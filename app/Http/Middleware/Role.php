<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class Role
{

    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user's role matches the required role
            if ($request->user()->role !== $role) {
                // Redirect the user to their corresponding dashboard based on their role
                if ($request->user()->role === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($request->user()->role === 'user') {
                    return redirect('/user/dashboard');
                }
            }
        } else {
            // If the user is not authenticated, redirect them to the login page
            return redirect('/login');
        }

        return $next($request);
    }

}
