<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\problem;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProblemController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_problems()
    {
        $data = Problem::select('id', 'title', 'category', 'importance', 'photo', 'content', 'status', 'user_id', 'admin_id', 'created_at')
            ->whereUser_id(auth()->user()->id)
            ->orderByDesc('id')->paginate(page_numbering_back);

        return response()->json(['code' => Response::HTTP_OK, 'status' => true, 'message' => 'Problems list', 'problems' => $data], Response::HTTP_OK);
    }

    public function add_problem(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:80',
            'admin_id'          => 'required',
            'category'          => 'required|integer',
            'importance'        => 'required|integer',
            'photo'             => 'image|mimes:jpg,png,jpeg|max:300',
        ]);

        if (!$validator->fails()) {

            if ($request->hasFile('photo_main') && request('photo_main') != null) {
                $request->photo                     = $this->SaveImage($request->file('photo_main'), 'images/uploads/problems/');
            }

            $request->merge([
                'user_id'   => auth()->user()->id,
                'photo'     => $request->photo
            ]);

            $data = $request->only(['title', 'category', 'content', 'admin_id', 'user_id', 'photo']);

            $problem = Problem::create($data);

            if ($problem) {
                return response()->json(['message' => $problem ? 'تم الحفظ' : 'هناك خطأ ما'], $problem ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
