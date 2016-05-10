<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


#class Lead extends EloquentUser implements AuthenticatableContract, CanResetPasswordContract {
#    use Authenticatable, CanResetPassword;
class LeadInfoEAV extends Model {

    protected $table="lead_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id','key', 'value',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    #protected $hidden = [
    #    'password', 'remember_token',
    #];


}
