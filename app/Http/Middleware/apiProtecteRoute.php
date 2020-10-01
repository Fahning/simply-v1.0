<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtecteRoute extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {

        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (\Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){

                return response()->json(['status' => 'Token inválido.']);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){

                return response()->json(['status' => 'Token expirado.']);

            }else{

                return response()->json(['status' => 'Token de autorização não encontrado.']);

            }

        }

        return $next($request);

    }

}
