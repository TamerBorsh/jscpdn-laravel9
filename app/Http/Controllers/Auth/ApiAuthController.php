<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    protected function getRules()
    {
        return [
            'email' =>          ['required', 'email', 'exists:users,email'],
            'password' =>       ['required', 'string', 'min:8']
        ];
    }

    protected function getMessages()
    {
        return [
            'email.required'        => 'البريد الإلكتروني مطلوب',
            'email.email'           => 'يجب أن يكون عنوان بريد إلكتروني صالحًا',
            'email.exists'          => 'البريد الإلكتروني  غير صالح',
            'password.required'     => ' كلمة المرور مطلوبة',
            'password.min'          => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل',
        ];
    }

    public function login(Request $request)
    {
        $rules          = $this->getRules();
        $messages       = $this->getMessages();
        $validator      = Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {
            $user = User::where('email', $request->input('email'))->first();

            if (Hash::check($request->input('password'), $user->password)) {
                if (!$this->checkActiveSessions($user->id)) {
                    $token = $user->createToken('Login-Api');
                    $user->setAttribute('token', $token->accessToken);
                    return response()->json([
                        'status' => 'true',
                        'message' => 'تم تسجيل الدخول بنجاح',
                        'object' => $user
                    ]);
                } else {
                    return response()->json(['message' => 'لا يمكن تسجيل الدخول إلى نفس الحساب من جهازين في وقت واحد'], Response::HTTP_FORBIDDEN);
                }

            } else {
                return response()->json(['message' => 'فشل تسجيل الدخول, حاول مرة أخرى'], Response::HTTP_BAD_REQUEST);
            }

        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function checkActiveSessions($userId)
    {
        return DB::table('oauth_access_tokens')->where('user_id', $userId)->where('revoked', false)->exists();
    }

    public function logout(Request $request)
    {
        $token = $request->user('api-login')->token();
        $revoke = $token->revoke();
        return response()->json([
            'status'    => $revoke,
            'message'   => $revoke ? 'تم تسجيل الخروج بنجاح' : ' فشل تسجيل الخروج , حاول مرة أخرى',
        ]);
    }
}
