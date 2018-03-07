<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $accounts = DB::table('accounts')->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'account',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.account.index', ['accounts' => $accounts, 'page_title' => '帐户管理']);
    }

    /**
     * 新添加一个帐户
     * @return $this
     */
    public function create()
    {
        $data = [
            'page_title' => '添加帐户',
        ];

        $config = config('session');
        Cookie::queue('_menu',
            'account',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.account.create')->with($data);
    }

    /**
     * 保存新添加的帐户信息
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name'   => 'required|unique:accounts|max:32',
            'type'   => 'required',
            'status' => 'required',
            'remark' => 'required',
        ];

        $messages = [
            'name.required'   => '请填写帐户名称',
            'name.unique'     => '帐户名称已存在',
            'name.max'        => '帐户名称长度已超过32个字符',
            'type.required'   => '请选择帐户类型',
            'status.required' => '请选择帐户状态',
            'remark.required' => '请填写帐户备注信息',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $account         = new Account();
        $account->name   = $request->get('name');
        $account->type   = $request->get('type');
        $account->status = $request->get('status');
        $account->remark = $request->get('remark');

        if ($account->save()) {
            return redirect('/admin/account');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * 删除一个未启用的帐户
     * @param $id
     * @return $this
     */
    public function destroy($id)
    {
        $account = Account::find($id);

        if ($account->status === 1) {
            return redirect()->back()->withInput()->withErrors('此帐户正在使用中，不能删除！');
        }

        $account->delete();

        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    /**
     * 修改帐户的状态[启用或禁用]
     * @param $id
     * @param $status
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, $status)
    {
        $account = Account::find($id);

        if ($status == 1) {
            $newStatus = 2;
        } elseif ($status == 2) {
            $newStatus = 1;
        }

        if ($newStatus && $account->update(['status' => $newStatus])) {
            return redirect('/admin/account');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }
}
