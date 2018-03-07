<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * 角色管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'role',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.role.index', ['roles' => $roles, 'page_title' => '角色管理']);
    }

    /**
     * 添加一个角色
     * @return $this
     */
    public function create()
    {
        $data = ['page_title' => '添加角色'];

        $config = config('session');
        Cookie::queue('_menu',
            'role',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.role.create')->with($data);
    }

    /**
     * 保存一个新添加的角色
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|unique:roles|alpha|max:32',
            'display_name' => 'required|max:32',
            'description'  => 'nullable|max:128',
        ];

        $messages = [
            'name.required' => '请填写角色名',
            'name.unique'   => '角色名已存在',
            'name.alpha'    => '角色名仅能包含英文字母',
            'name.max'      => '长度已超过32个字符',

            'display_name.required' => '请填写角色的显示名',
            'display_name.max'      => '长度已超过32个字符',

            'description.max' => '长度已超过128个字符',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role               = new Role();
        $role->name         = $request->get('name');
        $role->display_name = $request->get('display_name');
        $role->description  = $request->get('description');

        if ($role->save()) {
            return redirect('/admin/role');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * 角色分配
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assign()
    {
        // 角色
        $roles = DB::table('roles')->select(['id', 'display_name'])->get();

        // 用户
        $users = DB::table('users')->select(['id', 'name'])->get();

        // 获取已分配的角色及权限信息
        $role_users = [];

        $getUsers = User::all();
        foreach ($getUsers as $user) {
            foreach ($user->roles as $role) {
                $role_users[] = [
                    'user_id'           => $user->id,
                    'user_name'         => $user->name,
                    'role_id'           => $role->id,
                    'role_display_name' => $role->display_name,
                ];
            }
        }

        return view('admin.role.assign', [
            'roles'      => $roles,
            'users'      => $users,
            'role_users' => $role_users,
            'page_title' => '权限分配',
        ]);
    }

    /**
     * 角色分配
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doAssign(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'role_id' => 'required',
        ];

        $messages = [
            'user_id.required' => '请选择用户',
            'role_id.required' => '请选择角色',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = $request->get('user_id');
        $role_id = $request->get('role_id');

        $user = User::find($user_id);
        $user->attachRoles($role_id);

        return redirect('admin\role\assign');
    }

    /**
     * 去
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removal(Request $request)
    {
        $role_id = $request->get('role_id');
        $user_id = $request->get('user_id');

        $user = User::find($user_id);

        $user->detachRole($role_id);

        return redirect('admin\role\assign');
    }

}
