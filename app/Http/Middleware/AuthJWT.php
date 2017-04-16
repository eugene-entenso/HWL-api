<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid']);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired']);
            } else if ($e instanceof JWTException) {
                return response()->json(['error' => $e->getMessage()]);
            } else {
                return response()->json([
                    'error' => $e->getMessage(),
                    'type' => get_class($e),
                ]);
                return response()->json(['error' => 'Something is wrong']);
            }
        }

        return $next($request);
    }
}
