<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * @return $this
     */
    public function index()
    {
        $medias = Media::paginate(15);

        $config = config('session');

        Cookie::queue('_menu',
            'media',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.media.index', [
            'medias'     => $medias,
            'page_title' => '媒介管理',
        ]);
    }

    /**
     * 新添加一个媒介
     * @return $this
     */
    public function create()
    {
        $data = [
            'page_title' => '添加媒介',
        ];

        $config = config('session');
        Cookie::queue('_menu',
            'media',
            Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
            $config['path'],
            $config['domain'],
            $config['secure'],
            false
        );

        return view('admin.media.create')->with($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'name'   => 'required|unique:media|max:32',
            'status' => 'required',
            'remark' => 'required',
        ];

        $messages = [
            'name.required'   => '请填写媒介名称',
            'name.unique'     => '媒介名称已存在',
            'name.max'        => '媒介名称长度已超过32个字符',
            'status.required' => '请选择媒介状态',
            'remark.required' => '请填写媒介备注信息',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $media         = new Media();
        $media->name   = $request->get('name');
        $media->status = $request->get('status');
        $media->remark = $request->get('remark');

        if ($media->save()) {
            return redirect('/admin/media');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * 删除一个未启用的媒介
     * @param $id
     * @return $this
     */
    public function destroy($id)
    {
        $media = Media::find($id);

        if ($media->status === 1) {
            return redirect()->back()->withInput()->withErrors('此媒介正在使用中，不能删除！');
        }

        $media->delete();

        return redirect()->back()->withInput()->withErrors('删除成功！');
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function update($id, $status)
    {
        $media = Media::find($id);

        if ($status == 1) {
            $newStatus = 2;
        } elseif ($status == 2) {
            $newStatus = 1;
        }

        if ($newStatus && $media->update(['status' => $newStatus])) {
            return redirect('/admin/media');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    /**
     * @return mixed
     */
    public function assign()
    {
        // 执行用户
        $users = DB::table('users')
            ->select(['id', 'name'])
            ->where('user_type', 4)
            ->get();

        // 投放媒介
        $medias = DB::table('media')
            ->select(['id', 'name'])
            ->where('status', 1)
            // ->where('user_id', null)
            ->get();

        // 获取已分配管理者的媒介及管理者信息
        $media_users = [];

        $getMedias = Media::all();
        foreach ($getMedias as $media) {
            foreach ($media->user as $user) {
                $media_users[] = [
                    'media_id'   => $media->id,
                    'media_name' => $media->name,
                    'user_id'    => $user->id,
                    'user_name'  => $user->real_name,
                ];
            }
        }

        return view('admin.media.assign', [
            'users'       => $users,
            'medias'      => $medias,
            'media_users' => $media_users,
            'page_title'  => '媒介分配',
        ]);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function doAssign(Request $request)
    {
        $rules = [
            'user_id'  => 'required',
            'media_id' => 'required',
        ];

        $messages = [
            'user_id.required'  => '请选择执行人员',
            'media_id.required' => '请选择投放媒介',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id  = $request->get('user_id');
        $media_id = $request->get('media_id');

        $data = [];

        foreach ($media_id as $item) {
            $data[] = [
                'user_id'  => $user_id,
                'media_id' => $item,
            ];
        }

        // Media::wherein('id', $media_id)->update(['user_id' => $user_id]);
        DB::table('media_user')->insert($data);

        return redirect('admin\media\assign');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delUser(Request $request)
    {
        $user_id  = $request->get('user_id');
        $media_id = $request->get('media_id');

        $delete = DB::table('media_user')
            ->where([
                ['media_id', '=', $media_id],
                ['user_id', '=', $user_id],
            ])->delete();

        if ($delete) {
            return redirect('admin\media\assign');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }
}
