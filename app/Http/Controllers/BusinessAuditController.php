<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class BusinessAuditController extends Controller
{
    /**
     * 业务审核
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $auditing = Business::where('status', 1)->paginate(15);

        $count = DB::table('business')->where('status', 1)->count();
        $all   = DB::table('business')->count();

        $config = config('session');
        Cookie::queue('_menu',
            'audit',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessAudit.index', [
            'page_title' => '业务审核',
            'count'      => $count,
            'all'        => $all,
            'auditing'   => $auditing,
            'user'       => \Auth::user(),
        ]);
    }

    /**
     * 全部业务
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists()
    {
        $business = Business::paginate(15);

        $count = DB::table('business')->where('status', 1)->count();
        $all   = DB::table('business')->count();

        $config = config('session');
        Cookie::queue('_menu',
            'audit',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessAudit.list', [
            'page_title' => '全部业务',
            'count'      => $count,
            'all'        => $all,
            'business'   => $business,
            'user'       => \Auth::user(),
        ]);
    }

    /**
     * 审核通过
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auditPass($id)
    {
        $business = Business::find($id);

        if ($business->status == 1) {
            $business->status     = 2;
            $business->audit_time = date('Y-m-d H:i:s');
            $business->save();
        }

        return redirect('business/audit');
    }

    /**
     * 审核不通过
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auditFailed(Request $request)
    {
        $rules = [
            'audit_msg' => 'required',
        ];

        $messages = [
            'audit_msg.required' => '请填写审核不通过原因',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $business_id = $request->get('business_id');
        $audit_msg   = $request->get('audit_msg');
        $audit_time  = date('Y-m-d H:i:s');

        $business             = Business::find($business_id);
        $business->status     = 3;
        $business->audit_msg  = $audit_msg;
        $business->audit_time = $audit_time;
        $business->save();

        return redirect('business/audit');
    }
}
