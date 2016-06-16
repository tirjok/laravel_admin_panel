<?php
namespace Greenelf\Panel\libs;

use Closure;
use Gate;
use Greenelf\Panel\Admin;
use Lang;

class PermissionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    protected $app;

    public function handle($request, Closure $next)
    {

        $admin = Admin::find((\Auth::guard('panel')->user()->id));

        $urlSegments = $request->segments();

        if ($admin->hasRole('super')) {

            return $next($request);
        } else {
            if (array_key_exists(2, $urlSegments)) {

                $PermissionToCheck = $urlSegments[1] . $urlSegments[2];

                if ($admin->hasPermission($PermissionToCheck)) {

                    return $next($request);
                } else {
                    /**
                     * Show Access denied page to User
                     */

                    abort(403);
                }
            }

            return $next($request);
        }

    }
}
