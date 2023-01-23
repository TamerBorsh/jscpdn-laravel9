<?php

namespace App\Http\Controllers\Problem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Problem\StoreRequest;
use App\Http\Requests\Problem\UpdateRequest;
use App\Models\Admin;
use App\Models\Problem;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class ProblemController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:admin,web');
        $this->authorizeResource(Problem::class, 'problem');
    }

    public function index()
    {
        $request = request();

        if (Auth::guard('web')->check()) {
            $data = Problem::with(['user', 'admin'])
                ->select('id', 'title', 'category', 'importance', 'photo', 'content', 'status', 'user_id', 'admin_id', 'reply', 'number_call', 'created_at')
                ->whereUser_id(auth('web')->user()->id)
                ->orderByDesc('id')->paginate(page_numbering_back);
        } else {
            $query = Problem::query();
            if ($search = $request->query('search')) {
                $query->where('title', 'like', "%{$search}%");
            }
            if ($status = $request->query('status')) {
                $query->whereStatus($status);
            }
            if ($category = $request->query('category')) {
                $query->whereCategory($category);
            }
            if ($importance = $request->query('importance')) {
                $query->whereImportance($importance);
            }

            $data = $query->whereAdmin_id(auth('admin')->user()->id)->orderByDesc('id')->paginate(page_numbering_back);
        }
        // return response()->json($data);
        return response()->view('backend.problem.index', ['problems' => $data]);
    }

    public function create()
    {
        $admin = Admin::select('id', 'name')->where('id', '!=', '1')->get();
        return response()->view('backend.problem.create', ['admins' => $admin]);
    }

    public function store(StoreRequest $request)
    {

        if ($request->hasFile('photo_main') && request('photo_main') != null) {

            $file = $request->file('photo_main');
            $fileName = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/uploads/problems/'), $fileName);


            $request->merge([
                'photo'         => url('/') . '/images/uploads/problems/' . $fileName
            ]);
        }


        $request->merge([
            'user_id'   => auth()->user()->id,
            'photo'     => $request->photo
        ]);

        $data = $request->only(['title', 'category', 'content', 'admin_id', 'user_id', 'photo', 'number_call']);

        $problem = Problem::create($data);

        if ($problem) {
            return response()->json(['message' => $problem ? 'تم الحفظ' : 'هناك خطأ ما'], $problem ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Problem $problem)
    {
        $admin = Admin::select('id', 'name')->get();
        // return response()->json($problem);
        // $problem = $problem->whereAdmin_id(auth('admin')->user()->id);

        return response()->view('backend.problem.show', ['problem' => $problem, 'admins' => $admin]);
    }

    public function edit(Problem $problem)
    {
        $admin = Admin::select('id', 'name')->get();
        if ($problem->admin_id != auth('admin')->user()->id) {
            return abort('404');
        }
        return response()->view('backend.problem.edit', ['problem' => $problem, 'admins' => $admin]);
    }

    public function update(UpdateRequest $request, Problem $problem)
    {
        $data = $request->only(['status', 'importance', 'reply']);

        $isSave = $problem->update($data);
        if ($isSave) {
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Problem $problem)
    {
        if ($problem->admin_id != auth('admin')->user()->id) {
            return abort('404');
        }
        $isDelete = $problem->delete();
        $file_path  = public_path('images/uploads/problems/') . $problem->photo;
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
