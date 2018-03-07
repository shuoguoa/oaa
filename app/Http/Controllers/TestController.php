<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index()
    {
        $data['tasks'] = [
            [
                'name'     => 'Design New Dashboard',
                'progress' => '87',
                'color'    => 'danger',
            ],
            [
                'name'     => 'Create Home Page',
                'progress' => '76',
                'color'    => 'warning',
            ],
            [
                'name'     => 'Some Other Task',
                'progress' => '32',
                'color'    => 'success',
            ],
            [
                'name'     => 'Start Building Website',
                'progress' => '56',
                'color'    => 'info',
            ],
            [
                'name'     => 'Develop an Awesome Algorithm',
                'progress' => '10',
                'color'    => 'success',
            ],
        ];

        return view('test')->with($data);
    }

    /**
     * 在Permissions中添加数据
     */
    public function insert_to_permissions()
    {
        $permissions = [
            /*[
                'name'         => 'business_index',
                'display_name' => '业务列表',
                'description'  => '查看业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_create',
                'display_name' => '创建业务页面',
                'description'  => '创建业务信息页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_store',
                'display_name' => '记录业务信息',
                'description'  => '保存新创建的业务信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_show',
                'display_name' => '业务信息详情',
                'description'  => '查看业务信息详情',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_edit',
                'display_name' => '修改业务页面',
                'description'  => '修改业务信息页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_update',
                'display_name' => '保存业务信息',
                'description'  => '保存修改后的业务信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'business_destory',
                'display_name' => '删除业务信息',
                'description'  => '删除一条业务信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'config_index',
                'display_name' => '业务配置列表',
                'description'  => '待配置的业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_toConfig',
                'display_name' => '业务配置页面',
                'description'  => '显示业务配置页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_store',
                'display_name' => '保存业务配置信息',
                'description'  => '保存业务配置信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_lists',
                'display_name' => '业务列表',
                'description'  => '包含已配置的和未配置的全部业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_detail',
                'display_name' => '业务配置详情',
                'description'  => '查看业务配置详情',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_configured',
                'display_name' => '已配置的业务',
                'description'  => '已配置的业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'config_info',
                'display_name' => '业务配置详情',
                'description'  => '已配置的业务的配置详情',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'task_show',
                'display_name' => '任务详情',
                'description'  => '获取一个任务的详情',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_update',
                'display_name' => '修改任务信息',
                'description'  => '修改任务信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_stop',
                'display_name' => '停止任务执行',
                'description'  => '停止任务执行',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_add',
                'display_name' => '新增任务',
                'description'  => '给业务新增加一个任务配置',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_store',
                'display_name' => '存储任务信息',
                'description'  => '业务配置后，存储生成的任务信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'audit_index',
                'display_name' => '待审核的业务列表',
                'description'  => '待审核的业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'audit_pass',
                'display_name' => '业务审核通过',
                'description'  => '业管审核通过',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'audit_failed',
                'display_name' => '业务审核驳回',
                'description'  => '业务审核不通过',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'audit_list',
                'display_name' => '业务列表',
                'description'  => '包含审核通过的和不通过的业务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'task_list',
                'display_name' => '待执行的任务',
                'description'  => '待执行的任务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_executing',
                'display_name' => '执行中的任务',
                'description'  => '执行中任务列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_revised',
                'display_name' => '修改后的任务',
                'description'  => '修改后需要重新执行的任务',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_needstop',
                'display_name' => '需停止的任务',
                'description'  => '运营需要，需停止执行的任务',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_stat',
                'display_name' => '数据统计页面',
                'description'  => '数据统计页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_doStop',
                'display_name' => '任务停止',
                'description'  => '停止一个任务的执行',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_setStatTable',
                'display_name' => '数据上报表格',
                'description'  => '形成数据上报表格数据',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'task_exec',
                'display_name' => '任务开始',
                'description'  => '将任务状态修改为执行',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'stat_getStats',
                'display_name' => '获取投放数据',
                'description'  => '获取执行中任务最近更新日期及已投放量',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'stat_store',
                'display_name' => '保存统计数据',
                'description'  => '保存任务的统计数据',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'account_index',
                'display_name' => '帐户列表',
                'description'  => '帐户列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'account_create',
                'display_name' => '添加帐户',
                'description'  => '添加帐户页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'account_store',
                'display_name' => '存储帐户信息',
                'description'  => '存储新添加的帐户信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'account_destroy',
                'display_name' => '删除帐户信息',
                'description'  => '删除一条帐户信息记录',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'account_update',
                'display_name' => '修改帐户信息',
                'description'  => '修改帐户为启用或未启用',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            /*[
                'name'         => 'media_list',
                'display_name' => '媒介列表',
                'description'  => '媒介列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_create',
                'display_name' => '添加媒介',
                'description'  => '添加媒介页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_store',
                'display_name' => '存储媒介信息',
                'description'  => '存储新添加的媒介信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_destroy',
                'display_name' => '删除媒介',
                'description'  => '删除一条媒介记录',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_update',
                'display_name' => '更新媒介信息',
                'description'  => '更新媒介信息为启用或未启用',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_assign',
                'display_name' => '媒介分配页面',
                'description'  => '媒介分配管理者页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_doAssign',
                'display_name' => '媒介分配',
                'description'  => '媒介分配',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'media_deluser',
                'display_name' => '删除媒介分配',
                'description'  => '解除媒介分配关系',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            [
                'name'         => 'user_index',
                'display_name' => '用户列表',
                'description'  => '系统用户列表',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'user_create',
                'display_name' => '创建用户',
                'description'  => '创建用户页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'user_store',
                'display_name' => '存储用户信息',
                'description'  => '保存一条新添加的用户信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

            [
                'name'         => 'role_index',
                'display_name' => '角色列表',
                'description'  => '角色列表页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'role_create',
                'display_name' => '添加角色',
                'description'  => '添加角色页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'role_store',
                'display_name' => '保存角色信息',
                'description'  => '存储一条新添加的角色信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'role_assign',
                'display_name' => '角色分配页面',
                'description'  => '角色分配页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'role_doAssign',
                'display_name' => '角色分配',
                'description'  => '角色分配，为系统用户分配不同的角色',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'role_removal',
                'display_name' => '解除角色分配',
                'description'  => '解除角色分配关系',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            [
                'name'         => 'permission_index',
                'display_name' => '权限列表',
                'description'  => '权限列表页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'permission_create',
                'display_name' => '创建权限页面',
                'description'  => '创建权限页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'permission_store',
                'display_name' => '保存权限信息',
                'description'  => '保存一条新添加的权限信息',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'permission_assign',
                'display_name' => '权限分配页面',
                'description'  => '权限分配页面',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'permission_doAssign',
                'display_name' => '权限分配',
                'description'  => '权限分配，为角色分配不两只的权限',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'permission_removal',
                'display_name' => '解除权限分配',
                'description'  => '解除权限分配关系',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            /*[
                'name'         => '',
                'display_name' => '',
                'description'  => '',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],*/

        ];

        \DB::table('permissions')->insert($permissions);
    }
}
