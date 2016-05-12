<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class Agent extends EloquentUser implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','name','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopelistAll($query){
        return $query->whereIn('id',\Sentinel::findRoleBySlug('agent')->users()->lists('id'))->select(array('users.id','users.first_name','users.last_name', 'users.name', 'users.email', 'users.created_at'));
    }

    public function leads(){
        return $this->hasMany('\App\Models\Lead','agent_id','id');
    }
}