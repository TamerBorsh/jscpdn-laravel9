<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index(Request $request)
    {
        $request = request();
        $query = Admin::query();
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $data = $query->select('id', 'name', 'email', 'photo', 'password', 'mobile', 'created_at')->where('id', '!=', auth('admin')->id())->orderByDesc('id')->paginate(page_numbering_back);

        // return response()->json($data);
        return response()->view('backend.admin.index', ['admins' => $data]);
    }

    public function create()
    {
        $roles = Role::whereGuard_name('admin')->get();
        return response()->view("backend.admin.create", ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $role = Role::findById($request->input('role_id'), 'admin');

        if ($request->hasFile('photo_main') && request('photo_main') != null) {
            $request->photo     = $this->SaveImage($request->file('photo_main'), 'images/uploads/users/');

            $request->merge([
                'photo'         => $request->photo
            ]);
        }

        $data = $request->only('name', 'email', 'password', 'photo');

        $admin = Admin::create($data);
        if ($admin) {
            $admin->assignRole($role);
            return response()->json(['message' => $admin ? 'تم الحفظ' : 'هناك خطأ ما'], $admin ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Admin $Admin)
    {
        //
    }

    public function edit(Admin $admin)
    {
        $roles = Role::whereGuard_name('admin')->get();
        $roleAdmin =  $admin->roles()->first();
        return response()->view('backend.admin.edit', ['admin' => $admin, 'roles' => $roles, 'roleAdmin' => $roleAdmin]);
    }

    public function update(Request $request, Admin $admin)
    {
        $role = Role::findById($request->input('role_id'), 'admin');

        if ($request->hasFile('photo_main') && request('photo_main') != null) {

            $file_path  = public_path('images/uploads/users/') . $admin->photo;
            if (File::exists($file_path)) {
                File::delete($file_path);
            }

            $request->photo     = $this->SaveImage($request->file('photo_main'), 'images/uploads/users/');

            $request->merge([
                'photo'         => $request->photo
            ]);
        }

        $data = $request->only('name', 'email', 'password', 'photo');

        $isSave = $admin->update($data);

        if ($isSave) {
            $admin->syncRoles($role);
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Admin $Admin)
    {
        $isDelete = $Admin->delete();
        $file_path  = public_path('images/uploads/users/') . $Admin->photo;
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
