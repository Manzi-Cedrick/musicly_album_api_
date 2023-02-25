<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Token;
use App\Models\UserModel;
use Closure;
use Illuminate\Http\Request;

class CheckAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'Not authorized'
            ], 401);
        }

        $Token = new Token();

        $user = $Token->is_jwt_valid($token);

        if (!$user) {
            return response()->json([
                'message' => 'Not authorized'
            ], 401);
        }

        $User = new UserModel();

        $isUserAvailble = $User->getUser($user);

        if (!$isUserAvailble) {
            return response()->json([
                'message' => 'Not authorized'
            ], 401);
        }

        return $next($request);
    }
}
