<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($request->routeIs('admin.*')) {
            return route('admin.login');
        }

        // Redirect to the main page if a non-admin protected route is accessed without authentication.
        return route('recruitment.show');
    }
}
