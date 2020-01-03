<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RefreshToken
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
        try {
            $user = JWTAuth::toUser($request->input('token'));
        }catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'code' => 299,
                    'message' => 'token_expired',
                    'data' => [],
                ], $e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'code' => 289,
                    'message' => 'token_invalid',
                    'data' => [],
                ], $e->getStatusCode());
            }else{
                return response()->json([
                    'code' => 288,
                    'message' => 'Token is required',
                    'data' => []
                ]);
            }
        }
        return $next($request);
    }
}
