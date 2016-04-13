<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicRules extends Model
{
    protected $table = 'characteristic_rules';
    protected $fillable = ['group_id', 'srange','erange', 'rule' ];

    public function group() {
        return $this->belongsTo('App\Models\CharacteristicGroup','id','group_id');
    }

}