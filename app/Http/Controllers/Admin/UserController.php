<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = DB::table('users')->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'user',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.user.index', [
            'users'      => $users,
            'page_title' => '用户管理',
            'user'       => \Auth::user(),
        ]);
    }

    /**
     * 新添加一个用户
     * @return $this
     */
    public function create()
    {
        $data = [
            'page_title' => '添加用户',
            'user'       => \Auth::user(),
        ];

        $config = config('session');
        Cookie::queue('_menu',
            'user',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.user.create')->with($data);
    }

    /**
     * 新添加一个用户
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required|unique:users|max:32|min:6',
            'email'     => 'required|unique:users|email',
            'real_name' => 'required|max:32',
            'password'  => 'required',
            'user_type' => 'required',
            'status'    => 'required',
        ];

        $messages = [
            'name.required'      => '请填写用户名',
            'name.unique'        => '用户名已存在',
            'name.max'           => '用户名长度已超过32个字符',
            'name.min'           => '用户名长度少于6个字符',
            'email.required'     => '请填写用户邮箱',
            'email.unique'       => 'Email已被使用',
            'email.email'        => '请填写正确的Email',
            'real_name.required' => '请填写用户的真实姓名',
            'real_name.max'      => '已超过32个字符',
            'password.required'  => '请填写初始密码',
            'user_type.required' => '请选择用户类型',
            'status.required'    => '请选择用户状态',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user            = new User();
        $user->name      = $request->get('name');
        $user->email     = $request->get('email');
        $user->real_name = $request->get('real_name');
        $user->password  = bcrypt($request->get('password'));
        $user->user_type = $request->get('user_type');
        $user->status    = $request->get('status');
        $user->remark    = $request->get('remark');

        if ($user->save()) {
            return redirect('/admin/user');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }
}
