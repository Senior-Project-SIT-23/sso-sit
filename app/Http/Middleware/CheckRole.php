<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Support\Arr;

/**
 * @author https://github.com/Stunext
 *
 * PHP, and by extension, Laravel does not support multipart/form-data requests when using any request method other than POST.
 * This limits the ability to implement RESTful architectures. This is a middleware for Laravel 5.7 that manually decoding
 * the php://input stream when the request type is PUT, DELETE or PATCH and the Content-Type header is mutlipart/form-data.
 *
 * The implementation is based on an example by [netcoder at stackoverflow](http://stackoverflow.com/a/9469615).
 * This is necessary due to an underlying limitation of PHP, as discussed here: https://bugs.php.net/bug.php?id=55815.
 * 
 */

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = $request["roles"];
        foreach ($roles as $key => $role) {
            if ($role->name === "Admin") {
                return $next($request);
                break;
            }
        }
        return response()->json(
            [
                'error' => 'Access not allow (role invalid).'
            ],
            401
        );
    }
}

class CheckRoleApprover
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = $request["roles"];
        foreach ($roles as $key => $role) {
            if ($role->name === "Approver" || $role->name === "Admin") {
                return $next($request);
                break;
            }
        }
        return response()->json(
            [
                'error' => 'Access not allow (role invalid).'
            ],
            401
        );
    }
}
