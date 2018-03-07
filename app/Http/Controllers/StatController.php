<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    /**
     * 存储投放统计数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $task_id   = $request->get('task_id');
        $price     = $request->get('price');
        $stat_date = $request->get('stat_date');
        $show      = $request->get('show');
        $click     = $request->get('click');
        $cost      = $request->get('cost');
        $remark    = $request->get('remark');

        $insertData = [];
        foreach ($stat_date as $k => $v) {
            $insertData[$v] = [
                'task_id' => $task_id,
                'price'   => $price,
                'show'    => $show[$k],
                'click'   => $click[$k],
                'cost'    => $cost[$k],
                'remark'  => $remark[$k],
            ];
        }

        foreach ($insertData as $date => $n) {
            $show = \DB::table('stat')
                ->where('task_id', $task_id)
                ->where('stat_date', $date)
                ->value('show');

            if (!is_null($show)) {
                \DB::table('stat')
                    ->where('task_id', $task_id)
                    ->where('stat_date', $date)
                    ->update([
                        'price'      => $n['price'],
                        'show'       => $n['show'],
                        'click'      => $n['click'],
                        'cost'       => $n['cost'],
                        'remark'     => $n['remark'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            } else {
                \DB::table('stat')
                    ->insert([
                        'task_id'    => $task_id,
                        'stat_date'  => $date,
                        'price'      => $n['price'],
                        'show'       => $n['show'],
                        'click'      => $n['click'],
                        'cost'       => $n['cost'],
                        'remark'     => $n['remark'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }

        return redirect()->back();
    }

    /**
     * 获取执行中任务最近更新日期及已投放量
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats(Request $request)
    {
        $task_ids = $request->get('task_ids');
        $taskIds  = explode(',', $task_ids);

        $data = [];
        foreach ($taskIds as $taskId) {
            $last_stat_date = \DB::table('stat')->where('task_id', $taskId)->max('stat_date');
            $sum_shows      = \DB::table('stat')->where('task_id', $taskId)->sum('show');
            $data[]         = [
                'stat_id'        => $taskId,
                'last_stat_date' => $last_stat_date,
                'sum_shows'      => $sum_shows,
            ];
        }

        return response()->json($data);
    }

    /**
     * 返回一条Stat的详细信息
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $stat = Stat::find($id);

        return response()->json($stat);
    }

    /**
     * 保存更新后的Stat信息
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        DB::table('stat')
            ->where('id', $id)
            ->update([
                'show'   => $request->get('show', 0),
                'click'  => $request->get('click', 0),
                'price'  => $request->get('price', 0.00),
                'cost'   => $request->get('cost', 0.00),
                'remark' => $request->get('remark', ''),
            ]);

        return redirect()->back();
    }
}
