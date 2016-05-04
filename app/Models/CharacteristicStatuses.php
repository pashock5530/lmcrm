<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicStatuses extends Model
{
    protected $table = 'characteristic_statuses';
    protected $fillable = ['stepname', 'minmax','percent', 'position' ];

    public function group() {
        return $this->belongsTo('App\Models\CharacteristicGroup','id','group_id');
    }

}