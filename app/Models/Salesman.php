<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class Salesman extends EloquentUser implements AuthenticatableContract, CanResetPasswordContract {
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

    public function info(){
        return $this->hasOne('App\Models\SalesmantInfo','salesman_id','id');
    }

    public function agent(){
        return $this->info()->agent();
    }

    public function leads(){
        return $this->hasMany('\App\Models\Lead','agent_id','id');
    }

    public function sphere(){
        return $this->belongsToMany('\App\Models\Sphere','salesman_info','agent_id','sphere_id')->first();
    }

    public function bill(){
        return $this->agent()->bill();
    }
}