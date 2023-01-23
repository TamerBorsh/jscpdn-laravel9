<?php

namespace App\Http\Controllers\User;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UploadRequestExcel;
use App\Imports\UsersImport;
use App\Models\User;
use App\Traits\ImageTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $request = request();

        $query = User::query();
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $data = $query->select('id', 'id_number', 'name', 'email', 'password', 'photo', 'mobile', 'address', 'admin_id', 'created_at')->whereAdmin_id(auth('admin')->user()->id)->orderByDesc('id')->paginate(page_numbering_back);

        // return response()->json($data);
        return response()->view('backend.user.index', ['users' => $data]);
    }

    public function create()
    {
        $roles = Role::whereGuard_name('web')->get();
        return response()->view("backend.user.create", ['roles' => $roles]);
    }

    public function store(StoreRequest $request)
    {

        $role = Role::findById($request->input('role_id'), 'web');


        if ($request->hasFile('photo_main') && request('photo_main') != null) {

            $file = $request->file('photo_main');
            $fileName = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads/users/'), $fileName);


            $request->merge([
                'photo'         => url('/') . '/images/uploads/users/' . $fileName
            ]);
        }

        $request->merge([
            'admin_id'  => auth('admin')->user()->id,
            'photo'     => $request->photo
        ]);
        $data = $request->only('name', 'id_number', 'email', 'password', 'mobile', 'address', 'admin_id', 'photo');

        $user = User::create($data);

        if ($user) {
            $user->assignRole($role);
            return response()->json(['message' => $user ? 'تم الحفظ' : 'هناك خطأ ما'], $user ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(user $user)
    {
        //
    }

    public function edit(User $user)
    {
        $user = User::whereId($user->id)->where('admin_id', auth('admin')->user()->id)->first();

        $roles = Role::where('guard_name', '=', 'web')->get();
        $roleAdmin =  $user->roles()->first();

        if ($user) {
            return response()->view('backend.user.edit', ['user' => $user, 'roles' => $roles, 'roleAdmin' => $roleAdmin]);
        } else {
            return abort('404');
        }
    }

    public function update(UpdateRequest $request, user $user)
    {
        // return response()->json($request->all());
        $role = Role::findById($request->input('role_id'), 'web');

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

        $data = $request->only('name', 'id_number', 'email', 'password', 'mobile', 'address', 'photo');

        $isSave = $user->update($data);

        if ($isSave) {
            $user->syncRoles($role);
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(user $user)
    {
        $isDelete = $user->delete();
        $file_path  = public_path('images/uploads/users/') . $user->photo;
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function UploadExcel()
    {
        return response()->view("backend.user.upload-excel");
    }
    public function ExportExcel()
    {
        return Excel::download(new UsersExport(), 'JSCPDN-USERS ' . date('Y-m-d') . ' ' . time() . '.xlsx');
    }

    public function ImportExcel(UploadRequestExcel $request)
    {
        Excel::import(new UsersImport, $request->file('attachment'));
        return redirect()->route('users.index');
    }
}
