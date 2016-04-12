<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicGroup extends Model
{
    protected $table = 'characteristic_group';

    protected $fillable = ['name', 'table_name' ,'status', 'icon'];

    public function characteristics() {
        return $this->hasMany('App\Models\Characteristics','group_id','id')->orderBy('position');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($group) { // before delete() method call
            $group->characteristics()->delete();
        });
    }
}