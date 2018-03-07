<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * 可以被批量赋值的属性
     * @var array
     */
    protected $fillable = ['status'];

    /**
     * 获取一个帐户下所有的业务信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany('App\Models\Business');
    }
}
