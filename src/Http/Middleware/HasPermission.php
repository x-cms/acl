<?php

namespace Xcms\Acl\Http\Middleware;

use Closure;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        if (!$request->user('admin') || !$request->user('admin')->hasPermission($permissions)) {
            abort(403);
        }

        return $next($request);
    }
}
