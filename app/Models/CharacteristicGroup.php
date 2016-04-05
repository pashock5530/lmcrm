<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicGroup extends Model
{
    protected $table = 'characteristic_group';

    protected $fillable = ['name', 'table_name' ];

    public function characteristics() {
        return $this->hasMany('App\Models\Characteristics','group_id','id');
    }
}