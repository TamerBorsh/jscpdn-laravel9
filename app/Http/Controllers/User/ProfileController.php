<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:admin,web');
    }

    public function get_profile(User $user)
    {
        return response()->view('backend.user.profile', ['user' => $user]);
    }
    public function update_profile(Request $request, $id)
    {
        if (Auth::guard('admin')->check()) {
            $user = Admin::find($id);
        } else {
            $user = User::find($id);
        }

        if ($request->hasFile('photo_main') && request('photo_main') != null) {
            $file_path  = public_path('images/uploads/users/') . $user->photo;
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $request->photo             = $this->SaveImage($request->file('photo_main'), 'images/uploads/users/');

            $request->merge([
                'photo'     => $request->photo
            ]);
        }

        $data = $request->only('password', 'mobile', 'photo');

        $isSave = $user->update($data);

        if ($isSave) {
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }
}
