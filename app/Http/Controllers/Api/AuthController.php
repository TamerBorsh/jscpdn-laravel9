<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'             => 'required|string|email|max:255',
            'password'          => 'required|string|min:8',
        ]);
        if (!$validator->fails()) {
            $user = User::whereEmail($request->post('email'))->first();
            if (!$user) {
                return response()->json(
                    ['code' => Response::HTTP_NOT_FOUND, 'status' => 'true', 'message' => 'المستخدم غير موجود'],
                    Response::HTTP_NOT_FOUND
                );
            }
            // return $user;
            if (Hash::check($request->post('password'), $user->password)) {
                $token = $user->createToken('Login-Api');
                $user->setAttribute('token', $token->accessToken);
                return response()->json(
                    ['code' => Response::HTTP_OK, 'status' => 'true', 'message' => 'تم تسجيل الدخول بنجاح', 'object' => $user],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(['message' => 'فشل تسجيل الدخول, حاول مرة أخرى'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user('api')->token();
        // $revoke = $token->revoke();
        $revoke = $token->delete();
        return response()->json([
            'status'    => $revoke,
            'message'   => $revoke ? 'تم تسجيل الخروج بنجاح' : ' فشل تسجيل الخروج , حاول مرة أخرى',
        ]);
    }
}
