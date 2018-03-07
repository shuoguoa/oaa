<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Many-to-Many relations with the permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * 获取一个执行用户管理的所有媒介
     *
     * @return mixed
     */
    public function media()
    {
        return $this->belongsToMany('App\Models\Media');
    }

    /**
     * 获取一个运营人员创建的所有的业务信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function business()
    {
        return $this->hasMany('App\Models\Business', 'created_by');
    }

    /**
     * 获取一个销售人员下的所有业务信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salesman()
    {
        return $this->hasMany('App\Models\Business', 'salesman');
    }
}
