<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


#class Lead extends EloquentUser implements AuthenticatableContract, CanResetPasswordContract {
#    use Authenticatable, CanResetPassword;
class Lead extends EloquentUser {

    protected $table="leads";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id','sphere_id','name', 'phone_id', 'comment', 'date', 'bad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    #protected $hidden = [
    #    'password', 'remember_token',
    #];

    public function sphere(){
        return $this->hasOne('App\Models\Sphere', 'id', 'sphere_id');
    }

    public function info(){
        return $this->hasMany('App\Models\LeadInfoEAV','lead_id','id');
    }

    public function phone(){
        return $this->hasOne('App\Models\LeadPhone','id','phone_id');
    }
}
