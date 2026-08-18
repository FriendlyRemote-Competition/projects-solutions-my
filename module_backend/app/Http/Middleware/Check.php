<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Check
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if(!Auth::guard("api")->user() || Auth::guard("api")->user()->role !== $role){
            throw new HttpResponseException(response()->json([
                "message" => "Forbidden"
            ]));
        }
        return $next($request);
    }
}
