<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class TaskController extends Controller
{
    /**
     * 任务管理首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $id = Auth::id();

        // 当前用户管理的媒介
        $getMediaIds = \DB::table('media_user')
            ->where('user_id', '=', $id)
            ->pluck('media_id');
        $medias      = $getMediaIds->toArray();

        // 待执行任务数量
        $count = Task::whereIn('media_id', $medias)
            ->where('status', 1)
            ->count();

        // 执行中任务数量
        $executing = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->count();

        // 执行中修改后的任务数量
        $revised = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->count();

        // 执行中需停止的任务数量
        $needstop = Task::whereIn('media_id', $medias)
            ->whereIn('status', [1, 2])
            ->where('interim_status', 2)
            ->count();

        // 当前用户所有媒介下待执行的任务
        $tasks = Task::with('business', 'media')
            ->whereIn('media_id', $medias)
            ->where('status', 1)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'task',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('task.index', [
            'page_title' => '任务管理',
            'tasks'      => $tasks,
            'count'      => $count,
            'executing'  => $executing,
            'revised'    => $revised,
            'needstop'   => $needstop,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 执行中的任务
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function executing()
    {
        $id = Auth::id();

        // 当前用户管理的媒介
        $getMediaIds = \DB::table('media_user')
            ->where('user_id', '=', $id)
            ->pluck('media_id');
        $medias      = $getMediaIds->toArray();

        // 待执行任务数量
        $count = Task::whereIn('media_id', $medias)
            ->where('status', 1)
            ->count();

        // 执行中任务数量
        $executing = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->count();

        // 执行中修改后的任务数量
        $revised = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->count();

        // 执行中需停止的任务数量
        $needstop = Task::whereIn('media_id', $medias)
            ->whereIn('status', [1, 2])
            ->where('interim_status', 2)
            ->count();

        // 当前用户所有媒介下已执行的任务
        $tasks = Task::with('business', 'media')
            ->whereIn('media_id', $medias)
            ->where('status', 2)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'task',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('task.executing', [
            'page_title' => '任务管理',
            'tasks'      => $tasks,
            'count'      => $count,
            'executing'  => $executing,
            'revised'    => $revised,
            'needstop'   => $needstop,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 修改后需重新执行的业务
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function revised()
    {
        $id = Auth::id();

        // 当前用户管理的媒介
        $getMediaIds = \DB::table('media_user')
            ->where('user_id', '=', $id)
            ->pluck('media_id');
        $medias      = $getMediaIds->toArray();

        // 待执行任务数量
        $count = Task::whereIn('media_id', $medias)
            ->where('status', 1)
            ->count();

        // 执行中任务数量
        $executing = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->count();

        // 执行中修改后的任务数量
        $revised = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->count();

        // 执行中需停止的任务数量
        $needstop = Task::whereIn('media_id', $medias)
            ->whereIn('status', [1, 2])
            ->where('interim_status', 2)
            ->count();

        // 当前用户所有媒介下执行中修改后的任务
        $tasks = Task::with('business', 'media')
            ->whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'task',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('task.revised', [
            'page_title' => '任务管理',
            'tasks'      => $tasks,
            'count'      => $count,
            'executing'  => $executing,
            'revised'    => $revised,
            'needstop'   => $needstop,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 需停止的任务
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function needstop()
    {
        $id = Auth::id();

        // 当前用户管理的媒介
        $getMediaIds = \DB::table('media_user')
            ->where('user_id', '=', $id)
            ->pluck('media_id');
        $medias      = $getMediaIds->toArray();

        // 待执行任务数量
        $count = Task::whereIn('media_id', $medias)
            ->where('status', 1)
            ->count();

        // 执行中任务数量
        $executing = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->count();

        // 执行中修改后的任务数量
        $revised = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->count();

        // 执行中需停止的任务数量
        $needstop = Task::whereIn('media_id', $medias)
            ->whereIn('status', [1, 2])
            ->where('interim_status', 2)
            ->count();

        // 当前用户所有媒介下执行中需停止的任务
        $tasks = Task::with('business', 'media')
            ->whereIn('media_id', $medias)
            ->whereIn('status', [1, 2])
            ->where('interim_status', 2)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'task',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('task.needstop', [
            'page_title' => '任务管理',
            'tasks'      => $tasks,
            'count'      => $count,
            'executing'  => $executing,
            'revised'    => $revised,
            'needstop'   => $needstop,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 统计数据页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stat()
    {
        $id = Auth::id();

        // 当前用户管理的媒介
        $getMediaIds = \DB::table('media_user')
            ->where('user_id', '=', $id)
            ->pluck('media_id');
        $medias      = $getMediaIds->toArray();

        // 待执行任务数量
        $count = Task::whereIn('media_id', $medias)
            ->where('status', 1)
            ->count();

        // 执行中任务数量
        $executing = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->count();

        // 执行中修改后的任务数量
        $revised = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 1)
            ->count();

        // 执行中需停止的任务数量
        $needstop = Task::whereIn('media_id', $medias)
            ->where('status', 2)
            ->where('interim_status', 2)
            ->count();

        // 当前用户所有媒介下执行中的任务
        $tasks = Task::with('business', 'media')
            ->whereIn('media_id', $medias)
            ->where('status', 2)
            ->paginate(15);

        $config = config('session');
        Cookie::queue('_menu',
            'task',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('task.stat', [
            'page_title' => '任务管理',
            'tasks'      => $tasks,
            'count'      => $count,
            'executing'  => $executing,
            'revised'    => $revised,
            'needstop'   => $needstop,
            'user'       => Auth::user(),
        ]);
    }

    /**
     * 获取一个任务的详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = Task::with('business', 'media')->find($id);

        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * 将任务状态修改为已执行
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function exec($id)
    {
        $task   = Task::find($id);
        $status = $task->status;

        if ($status == 1) {
            \DB::table('tasks')->where('id', $id)
                ->update([
                    'status'  => 2,
                    'exec_at' => date('Y-m-d H:i:s'),
                ]);
        } elseif ($status == 2) {
            \DB::table('tasks')->where('id', $id)
                ->update([
                    'status'         => 2,
                    'interim_status' => null,
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
        };

        return redirect()->back();
    }

    /**
     * 修改任务的信息
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $business_id = $request->get('business_id');

        $task   = Task::find($id);
        $status = $task->status;
        if ($status == 1 || $status == 2) {
            // $ubterim_status = 1; 任务已修改
            $interim_status = ($status == 2) ? 1 : null;

            \DB::table('tasks')->where('id', $id)
                ->update([
                    'start_time'     => $request->get('start_time'),
                    'end_time'       => $request->get('end_time'),
                    'throws'         => $request->get('throws'),
                    'plan'           => $request->get('plan'),
                    'interim_status' => $interim_status,
                ]);
        }

        return redirect()->back();
    }

    /**
     * 运营人员停止一个任务的执行
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stop($id)
    {
        $task   = Task::find($id);
        $status = $task->status;

        if ($status == 1) {
            // 未开始执行的任务直接停止
            \DB::table('tasks')->where('id', $id)
                ->update([
                    'status'     => 3,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        } elseif ($status == 2) {
            // 已开始执行的任务需执行人员停止
            \DB::table('tasks')->where('id', $id)
                ->update([
                    'interim_status' => 2,
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
        }

        return redirect()->back();
    }

    /**
     * 执行人员停止一个任务的执行
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stopTask($id)
    {
        \DB::table('tasks')->where('id', $id)
            ->update([
                'status'         => 3,
                'interim_status' => null,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

        return redirect()->back();
    }

    /**
     * 数据上报表格
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatTable($id)
    {
        $task = Task::with('stat')->find($id);

        $today = Carbon::now();

        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', substr($task->exec_at, 0, 10) . ' 00:00:00');
        // $endDate   = Carbon::createFromFormat('Y-m-d H:i:s', substr($task->end_time, 0, 10) . ' 23:59:59');
        $end_time = $task->end_time;
        if ($end_time && !is_null($end_time)) {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', substr($task->end_time, 0, 10) . ' 23:59:59');
        } else {
            $endDate = $today->addDay(10);
        }

        $data = [
            'task_id' => $id,
            'price'   => 0.00,
            'stat'    => [],
        ];

        $stats = \DB::table('stat')
            ->where([
                ['task_id', '=', $id],
                ['stat_date', '>=', $startDate->format('Y-m-d')],
                ['stat_date', '<=', $today->format('Y-m-d')],
            ])
            ->select('stat_date as date', 'show', 'click', 'cost', 'price', 'remark')
            ->get();


        $statDatas = [];
        foreach ($stats as $stat) {
            $statDatas[$stat->date] = [
                'show'   => $stat->show,
                'click'  => $stat->click,
                'cost'   => $stat->cost,
                'remark' => $stat->remark,
            ];
            $data['price']          = (isset($stat->price)) ? $stat->price : 0.00;
        }

        for ($dt = $startDate; $dt->lt($today); $dt->addDay()) {
            $date = $dt->format('Y-m-d');

            $data['stat'][] = [
                'date'   => $date,
                'show'   => isset($statDatas[$date]['show']) ? $statDatas[$date]['show'] : 0,
                'click'  => isset($statDatas[$date]['click']) ? $statDatas[$date]['click'] : 0,
                'cost'   => isset($statDatas[$date]['cost']) ? $statDatas[$date]['cost'] : 0.00,
                'remark' => isset($statDatas[$date]['remark']) ? $statDatas[$date]['remark'] : "",
            ];
        }

        return response()->json($data);
    }

    /**
     * 增加业务配置信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function add($id)
    {
        // 业务已经配置的媒介
        $configuredIds = \DB::table('tasks')
            ->where('business_id', $id)
            ->pluck('media_id');

        // 全部媒介
        $all = \DB::table('media')
            ->where('status', 1)
            ->pluck('id');

        // 待配置的
        $mediaIds = array_diff($all->toArray(), $configuredIds->toArray());

        $medias = \DB::table('media')
            ->select(['id', 'name'])
            ->whereIn('id', $mediaIds)
            ->get();

        return response()->json($medias);
    }
}
