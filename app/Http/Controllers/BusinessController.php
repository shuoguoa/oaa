<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Stat;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BusinessController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user   = Auth::user();
        $userId = Auth::id();

        $business = Business::where('created_by', $userId)
            ->paginate(15);

        // 到帐帐户
        $accounts = \DB::table('accounts')
            ->select(['id', 'name'])
            ->where('status', 1)
            ->get();

        // 销售
        $salesman = \DB::table('users')
            ->select(['id', 'name'])
            ->where([['status', 1], ['user_type', 3]])
            ->get();

        $config = config('session');
        Cookie::queue('_menu',
            'business', Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('business.index', [
            'business'   => $business,
            'accounts'   => $accounts,
            'salesman'   => $salesman,
            'page_title' => '业务管理',
            'user'       => $user,
        ]);
    }

    /**
     * 新添加一个业务
     * @return $this
     */
    public function create()
    {
        $user = Auth::user();

        // 到帐帐户
        $accounts = \DB::table('accounts')
            ->select(['id', 'name'])
            ->where('status', 1)
            ->get();

        // 销售
        $salesman = \DB::table('users')
            ->select(['id', 'name'])
            ->where([['status', 1], ['user_type', 3]])
            ->get();

        $config = config('session');
        Cookie::queue('_menu',
            'business', Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('business.create', [
            'page_title' => '添加业务',
            'accounts'   => $accounts,
            'salesman'   => $salesman,
            'user'       => $user,
        ]);
    }

    /**
     * 新添加一个业务
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required|unique:business|max:64',
            'payment_mode' => 'required',
            // 'material'     => 'sometimes|required|url',
            'mode'         => 'required',
            'salesman'     => 'required',
            'remark'       => 'required',
        ];

        $messages = [
            'name.required'           => '请填写业务名称',
            'name.unique'             => '业务名称已存在',
            'name.max'                => '业务名称的长度已超过64个字符',
            'salesman.required'       => '请选择所属的销售人员',
            'payment_mode.required'   => '请选择付款方式',
            'account_amount.required' => '请填写付款金额',
            'account_amount.numeric'  => '请填写正确的付款金额',
            'account_amount.min'      => '请填写正确的付款金额',
            'account_id.required'     => '请选择到款帐户',
            'account_time.required'   => '请选择付款日期',
            'account_time.date'       => '请填写正确的付款日期',
            'material.url'            => '请填写正确的素材链接',
            'price.required'          => '请填写结算单价',
            'price.numeric'           => '请填写正确的结算单价',
            'price.min'               => '请填写正确的结算单价',
            'mode.required'           => '请选择结算方式',
            'remark.required'         => '请填写备注信息',
        ];



        $validator = \Validator::make($request->all(), $rules, $messages);

        $validator->sometimes(['account_id', 'account_time', 'account_amount'], 'required', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('account_time', 'date', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('account_amount', 'numeric|min:0', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('price', 'required|numeric|min:0', function ($request) {
            return $request->mode != 4;
        });
        $validator->sometimes('material', 'url', function ($request) {
            return $request->material;
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $business               = new Business();
        $business->name         = $request->get('name');
        $business->payment_mode = $request->get('payment_mode');

        if ($business->payment_mode == 2) {
            $business->account_amount = null;
            $business->account_time   = null;
            $business->account_id     = null;
        } else {
            $business->account_amount = $request->get('account_amount');
            $business->account_time   = $request->get('account_time');
            $business->account_id     = $request->get('account_id');
        }
        $business->material   = $request->get('material', "");
        $business->price      = $request->get('price', "");
        $business->mode       = $request->get('mode');
        $business->salesman   = $request->get('salesman');
        $business->created_by = Auth::id();
        $business->remark     = $request->get('remark');

        if ($business->save()) {
            return redirect('business');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * 返回一个业务的详细信息
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $business = Business::with(['account', 'getSalesman', 'createdBy'])->find($id);

        return \Response::json($business);
    }

    /**
     * 修改业务
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // 到帐帐户
        $accounts = \DB::table('accounts')
            ->select(['id', 'name'])
            ->where('status', 1)
            ->get();

        // 销售
        $salesman = \DB::table('users')
            ->select(['id', 'name'])
            ->where([['status', 1], ['user_type', 3]])
            ->get();

        $config = config('session');
        Cookie::queue('_menu',
            'business', Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('business.edit', [
            'page_title' => '修改业务',
            'id'         => $id,
            'accounts'   => $accounts,
            'salesman'   => $salesman,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 修改业务
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $business_id = $id;

        $rules = [
            // 'name'         => 'required|unique:business|max:64',
            'name'         => [
                'required',
                'max:64',
                Rule::unique('business')->ignore($id),
            ],
            'payment_mode' => 'required',
            'mode'         => 'required',
            'salesman'     => 'required',
            'remark'       => 'required',
        ];

        $messages = [
            'name.required'           => '请填写业务名称',
            'name.unique'             => '业务名称已存在',
            'name.max'                => '业务名称的长度已超过64个字符',
            'salesman.required'       => '请选择所属的销售人员',
            'payment_mode.required'   => '请选择付款方式',
            'account_amount.required' => '请填写付款金额',
            'account_amount.numeric'  => '请填写正确的付款金额',
            'account_amount.min'      => '请填写正确的付款金额',
            'account_id.required'     => '请选择到款帐户',
            'account_time.required'   => '请选择付款日期',
            'account_time.date'       => '请填写正确的付款日期',
            'material.required'       => '请填写素材链接',
            'material.url'            => '请填写正确的素材链接',
            'price.required'          => '请填写结算单价',
            'price.numeric'           => '请填写正确的结算单价',
            'price.min'               => '请填写正确的结算单价',
            'mode.required'           => '请选择结算方式',
            'remark.required'         => '请填写备注信息',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        $validator->sometimes(['account_id', 'account_time', 'account_amount'], 'required', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('account_time', 'date', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('account_amount', 'numeric|min:0', function ($request) {
            return $request->payment_mode == 1;
        });
        $validator->sometimes('price', 'required|numeric|min:0', function ($request) {
            return $request->mode != 4;
        });
        $validator->sometimes('material', 'url', function ($request) {
            return $request->material;
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payment_mode = $request->get('payment_mode');

        DB::table('business')
            ->where('id', $business_id)
            ->update([
                'name'           => $request->get('name'),
                'payment_mode'   => $payment_mode,
                'account_amount' => ($payment_mode == 1) ? $request->get('account_amount') : null,
                'account_time'   => ($payment_mode == 1) ? $request->get('account_time') : null,
                'account_id'     => ($payment_mode == 1) ? $request->get('account_id') : null,
                'material'       => $request->get('material'),
                'price'          => $request->get('price'),
                'mode'           => $request->get('mode'),
                'status'         => 1, // 修改后为待审核
                'audit_msg'      => null, // 修改后审核信息为空
                'salesman'       => $request->get('salesman'),
                'remark'         => $request->get('remark'),
            ]);

        return redirect('business');
    }

    /**
     * 删除一个待审核的或审核失败的业务
     * @param $id
     * @return $this
     */
    public function destroy($id)
    {
        // Business::find($id)->delete();
        $Business = Business::find($id);
        if ($Business->status == 1 || $Business->status == 3) {
            $Business->delete();
        }
    }

    /**
     * 数据统计
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stat($id)
    {
        $user = Auth::user();

        // 查找任务ID
        $getTaskIds   = Task::where('business_id', $id)->pluck('id');
        $TaskIds      = $getTaskIds->toArray();
        $businessName = DB::table('business')->where('id', $id)->value('name');

        $getStat = Stat::whereIn('task_id', $TaskIds)->get();
        $statArr = $getStat->toArray();

        //
        $statDatas = [];
        foreach ($statArr as $item) {
            $task_id     = $item['task_id'];
            $getTakes    = Task::find($task_id);
            $mediaName   = $getTakes->media->name;
            $statDatas[] = [
                'id'        => $item['id'],
                'mediaName' => $mediaName,
                'date'      => $item['stat_date'],
                'show'      => $item['show'],
                'click'     => $item['click'],
                'price'     => $item['price'],
                'cost'      => $item['cost'],
                'remark'    => $item['remark'],
            ];
        }


        $config = config('session');
        Cookie::queue('_menu',
            'business', Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('business.stat', [
            'businessName' => $businessName,
            'stats'        => $statDatas,
            'page_title'   => "数据统计",
            'user'         => $user,
        ]);
    }
}
