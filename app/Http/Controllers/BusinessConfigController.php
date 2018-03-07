<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class BusinessConfigController extends Controller
{
    /**
     * 待配置的业务列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $auditing = Business::where('status', 2)
            ->where('created_by', Auth::id())
            ->paginate(15);

        // 待配置的
        $count = DB::table('business')
            ->where('status', 2)
            ->where('created_by', Auth::id())
            ->count();

        // 全部
        $all = DB::table('business')
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的
        $num = DB::table('business')
            ->where('status', 4)
            ->where('created_by', Auth::id())
            ->count();

        $config = config('session');
        Cookie::queue('_menu',
            'config',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessConfig.index', [
            'page_title' => '业务配置',
            'auditing'   => $auditing,
            'count'      => $count,
            'all'        => $all,
            'num'        => $num,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 全部业务
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists()
    {
        $business = Business::where('created_by', Auth::id())
            ->paginate(15);

        // 待配置的
        $count = DB::table('business')
            ->where('status', 2)
            ->where('created_by', Auth::id())
            ->count();

        // 全部
        $all = DB::table('business')
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的
        $num = DB::table('business')
            ->where('created_by', Auth::id())
            ->where('status', 4)
            ->count();

        $config = config('session');
        Cookie::queue('_menu',
            'config',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessConfig.list', [
            'page_title' => '全部业务',
            'count'      => $count,
            'all'        => $all,
            'num'        => $num,
            'business'   => $business,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 已配置的业务
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function configured(Request $request)
    {
        $name = $request->get('search_name');

        if (!$name) {
            $business = Business::where('status', 4)
                ->where('created_by', Auth::id())
                ->paginate(15);

        } else {
            $business = Business::where('status', 4)
                ->where('created_by', Auth::id())
                ->where('name', $name)
                ->paginate(15);

        }

        // 待配置的
        $count = DB::table('business')
            ->where('status', 2)
            ->where('created_by', Auth::id())
            ->count();

        // 全部
        $all = DB::table('business')
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的
        $num = DB::table('business')
            ->where('status', 4)
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的业务的名称
        $names = DB::table('business')
            ->select('id', 'name')
            ->where('status', 4)
            ->where('created_by', Auth::id())
            ->get();

        $config = config('session');
        Cookie::queue('_menu',
            'config',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessConfig.configured', [
            'page_title' => '业务配置',
            'count'      => $count,
            'all'        => $all,
            'num'        => $num,
            'business'   => $business,
            'user'       => Auth::user(),
            'names'      => $names->toArray(),
            'search_name' => $name,
        ]);
    }

    /**
     * 已配置的业务的配置详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info($id)
    {
        $business = Business::find($id);

        // 待配置的
        $count = DB::table('business')
            ->where('status', 2)
            ->where('created_by', Auth::id())
            ->count();

        // 全部
        $all = DB::table('business')
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的
        $num = DB::table('business')
            ->where('created_by', Auth::id())
            ->where('status', 4)
            ->count();

        // 配置信息
        $tasks = Task::with('media')
            ->where('business_id', $id)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'config',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessConfig.info', [
            'page_title' => '业务配置',
            'count'      => $count,
            'all'        => $all,
            'num'        => $num,
            'business'   => $business,
            'tasks'      => $tasks,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 业务配置
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toConfig($id)
    {
        $business = Business::find($id);

        // 待配置的
        $count = DB::table('business')
            ->where('status', 2)
            ->where('created_by', Auth::id())
            ->count();

        // 全部
        $all = DB::table('business')
            ->where('created_by', Auth::id())
            ->count();

        // 已配置的
        $num = DB::table('business')
            ->where('status', 4)
            ->where('created_by', Auth::id())
            ->count();

        // 媒介
        $medias = DB::table('media')
            ->select(['id', 'name'])
            ->where('status', 1)
            ->get();

        $config = config('session');
        Cookie::queue('_menu',
            'config',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('businessConfig.config', [
            'page_title' => '业务配置',
            'count'      => $count,
            'all'        => $all,
            'num'        => $num,
            'business'   => $business,
            'medias'     => $medias,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 业务名称搜索
     * @param Request $request
     */
    public function search_name(Request $request)
    {
        $name = $request->get('name');
        var_dump($name);
    }

    /**
     * 业务配置详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $business = Business::find($id);
        $status   = $business->status;
        $config   = $business->config;
        $name     = $business->name;

        $getMedia = '';
        if ($status >= 4 && $config) {
            $configs  = json_decode($config, true);
            $mediaIds = explode(',', $configs['mediaIds']);
            $getMedia = DB::table('media')->select(['id', 'name'])->whereIn('id', $mediaIds)->get();
        }

        return response()->json([
            'name'     => $name,
            'getMedia' => $getMedia,
            'config'   => json_decode($config, true),
        ]);
    }

    /**
     * 存取业务配置信息
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'media_id' => 'required',
        ];

        $messages = [
            'media_id.required' => '请选择媒介',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $_mode       = $request->get('_mode');
        $mediaIds    = $request->get('media_id');
        $business_id = $request->get('business_id');

        $tasks = [];
        foreach ($mediaIds as $mediaId) {

            $tasks[] = [
                'business_id' => $business_id,
                'media_id'    => $mediaId,
                'start_time'  => $request->get("start_time_{$mediaId}"),
                'end_time'    => $request->get("end_time_{$mediaId}"),
                'throws'      => $request->get("throws_{$mediaId}", 0),
                'plan'        => $request->get("plan_{$mediaId}"),
                'status'      => 1,
            ];
        }

        DB::table('business')->where('id', $business_id)->update(['status' => 4]);

        DB::table('tasks')->insert($tasks);

        if ($_mode == 1) {
            $config = config('session');
            Cookie::queue('_menu',
                'config',
                Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
                $config['path'],
                $config['domain'],
                $config['secure'],
                false
            );

            return redirect('business/config');
        } else {
            $config = config('session');
            Cookie::queue('_menu',
                'task',
                Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
                $config['path'],
                $config['domain'],
                $config['secure'],
                false
            );

            return redirect()->back();
        }

    }
}
