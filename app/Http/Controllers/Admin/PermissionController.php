<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * 权限管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'permission',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.permission.index', ['permissions' => $permissions, 'page_title' => '权限管理']);
    }

    /**
     * 添加权限
     * @return $this
     */
    public function create()
    {
        $data = ['page_title' => '添加权限'];

        $config = config('session');
        Cookie::queue('_menu',
            'permission',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.permission.create')->with($data);
    }

    /**
     * 保存一个新添加的权限
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|unique:permissions|alpha_dash|max:32',
            'display_name' => 'required|max:32',
            'description'  => 'nullable|max:128',
        ];

        $messages = [
            'name.required'   => '请填写角色名',
            'name.unique'     => '角色名已存在',
            'name.alpha_dash' => '名称 只能由字母、数字、下划线(_)以及破折号(-)组成',
            'name.max'        => '长度已超过32个字符',

            'display_name.required' => '请填写角色的显示名',
            'display_name.max'      => '长度已超过32个字符',

            'description.max' => '长度已超过128个字符',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $permission               = new Permission();
        $permission->name         = $request->get('name');
        $permission->display_name = $request->get('display_name');
        $permission->description  = $request->get('description');

        if ($permission->save()) {
            return redirect('/admin/permission');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * 权限分配
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assign()
    {
        // 角色
        $roles = DB::table('roles')->select(['id', 'display_name'])->get();

        // 权限
        $permissions = DB::table('permissions')->select(['id', 'display_name'])->get();

        // 获取已分配的角色及权限信息
        $permission_roles = [];

        $getRoles = Role::all();
        foreach ($getRoles as $role) {
            foreach ($role->permissions as $permission) {
                $permission_roles[] = [
                    'role_id'                 => $role->id,
                    'role_display_name'       => $role->display_name,
                    'permission_id'           => $permission->id,
                    'permission_display_name' => $permission->display_name,
                ];
            }
        }

        $config = config('session');
        Cookie::queue('_menu',
            'permission',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.permission.assign', [
            'roles'            => $roles,
            'permissions'      => $permissions,
            'permission_roles' => $permission_roles,
            'page_title'       => '权限分配',
        ]);
    }

    /**
     * 权限分配
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doAssign(Request $request)
    {
        $rules = [
            'role_id'       => 'required',
            'permission_id' => 'required',
        ];

        $messages = [
            'role_id.required'       => '请选择角色',
            'permission_id.required' => '请选择权限',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role_id       = $request->get('role_id');
        $permission_id = $request->get('permission_id');

        $role = Role::find($role_id);

        $role->attachPermissions($permission_id);

        return redirect('admin\permission\assign');
    }

    /**
     * 去
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removal(Request $request)
    {
        $role_id       = $request->get('role_id');
        $permission_id = $request->get('permission_id');

        $role = Role::find($role_id);
        $role->detachPermission($permission_id);

        return redirect('admin\permission\assign');
    }
}
