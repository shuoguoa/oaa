<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * 与模型关联的数据表
     * @var string
     */
    protected $table = 'business';

    /**
     * 获取该业务所属的帐户模型
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    /**
     * 获取业务的创建者信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    /**
     * 获取业务所属的销售人员信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getSalesman()
    {
        return $this->belongsTo('App\Models\User', 'salesman');
    }

    /**
     * 获取一个业务下所有的任务
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task()
    {
       return $this->hasMany('App\Models\Task');
    }
}
