<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * 获取任务所属的业务模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    /**
     * 获取任务所属的媒介模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media()
    {
        return $this->belongsTo('App\Models\Media');
    }

    /**
     * 获取任务所有的统计数据
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stat()
    {
        return $this->hasMany('App\Models\Stat');
    }
}
