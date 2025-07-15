<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstitutionalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'institutional'])) {
            abort(403, 'Access denied. Insufficient privileges.');
        }

        // If user is institutional, ensure they have an institution assigned
        if ($user->role === 'institutional' && !$user->institution_id) {
            abort(403, 'Access denied. No institution assigned.');
        }

        return $next($request);
    }
}
