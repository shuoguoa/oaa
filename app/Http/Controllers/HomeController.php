<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        if ($user->hasRole('yunying')) {
            // 运营
            return redirect('business');
        } elseif ($user->hasRole('yeguan')) {
            // 业管
            return redirect('business/audit');
        } elseif ($user->hasRole('zhixing')) {
            // 执行
            return redirect('task');
        } elseif ($user->hasRole('admin')) {
            // 管理员
            return redirect('admin/user');
        } else {
            return redirect(403);
        }
    }

    /**
     * 重定向到login页面
     */
    public function login()
    {
        redirect('/login');
    }
}
