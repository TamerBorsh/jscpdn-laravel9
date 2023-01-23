<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin,web');
    }

    public function index()
    {
        $admin = Admin::count();
        $user = User::count();

        if (Auth::guard('web')->check()) {
            $problem = Problem::whereUser_id(auth('web')->user()->id)->orderByDesc('id')->limit('5')->get();
            $problem_count = $problem->count();
        } else {
            $problem = Problem::whereAdmin_id(auth('admin')->user()->id)->orderByDesc('id')->limit('5')->get();
            $problem_count = $problem->count();
        }

        // return response()->json($problem);
        return response()->view('backend.dashboard.index', ['admin' => $admin, 'problem_count' => $problem_count, 'user' => $user, 'problems' => $problem]);
    }
}
