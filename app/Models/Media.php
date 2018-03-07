<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected $fillable = ['status', 'user_id'];

    /**
     * 获取一个媒介的管理者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
       return $this->belongsToMany('App\Models\User');
    }

    /**
     * 获取一个媒介下的所有任务
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task()
    {
        return $this->hasMany('App\Models\task');
    }
}
