<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Http\Controllers\Token;
use App\Models\UserModel;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $header = $request->header('Authorization');

            if ($header) {
                $Token = new Token();
                $userId = $Token->is_jwt_valid($header);

                if ($userId) {
                    return response()->json(["message" => "You are already logged in"], 200);
                }
            }
            
            $request->validate([
                "email" => "required|exists:users|min:3|max:50",
                "password" => "required|min:6|max:50"
            ]);

            $User = new UserModel();

            $userInfo = $User->getUserByEmail($request->email);

            if (!$userInfo) {
                return response()->json(["message" => "Incorrect email or password"], 403);
            } else {
                if (Hash::check($request->password, $userInfo->password)) {
                    $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                    $payload = array('id' => $userInfo->user_id, "email" => $userInfo->email, 'exp' => (time() + 1024 * 24 * 60 * 60));

                    $Token = new Token();
                    $token = $Token->generate_jwt($headers, $payload);

                    return response()->json(["token" => $token, "message" => "Authentication successful"], 200);
                } else {
                    return response()->json(["message" => "Incorrect email or password"], 403);
                }
            }
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|unique:users|max:150|min:3",
                "username" => "required|unique:users|max:150|min:3",
                "password" => "required|max:25|min:6"
            ]);

            $User = new UserModel();

            $newUser = $User->createUser([
                'user_id' => uniqid('user_'),
                "email" => $request->email,
                "username" => $request->username,
                "password" => Hash::make($request->password)
            ]);

            if ($newUser) {
                return response()->json([
                    "message" => "User created successfully",
                    "data" => $newUser
                ], 201);
            } else {
                return response()->json(["message" => "User creation failed"], 400);
            }
        } catch (Exception $e) {;
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function getUserData(Request $request)
    {
        try {
            $header = $request->header('Authorization');

            if (!$header) {
                return response()->json([
                    'error' => "Authorization failed"
                ], 401);
            }

            $Token = new Token();
            $user = $Token->is_jwt_valid($header);

            if (!$user) {
                return response()->json([
                    'error' => "Authorization failed"
                ], 401);
            }

            $User = new UserModel();

            $isUserAvailble = $User->getUser($user);

            if ($isUserAvailble) {
                return response()->json(["user" => [
                    "user_id" => $isUserAvailble->user_id,
                    "email" => $isUserAvailble->email,
                    "username" => $isUserAvailble->username
                ]], 200);
            } else {
                return response()->json(["message" => "User not found"], 404);
            }
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        try {
            $header = $request->header('Authorization');

            if (!$header) {
                return response()->json([
                    'error' => "No token found"
                ], 401);
            }

            $Token = new Token();

            $user = $Token->is_jwt_valid($header);

            if (!$user) {
                return response()->json([
                    'error' => "Already logged out"
                ], 401);
            }

            $isTokenInvalid = $Token->invalidate_jwt($header);

            if ($isTokenInvalid) {
                return response()->json(["message" => "Logged out successfully"], 200);
            } else {
                return response()->json(["message" => "Logout failed"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 400);
        }
    }
}
