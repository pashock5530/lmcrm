<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicGroup extends Model
{
    protected $table = 'characteristic_group';

    protected $fillable = ['name', 'minLead','table_name' ,'status'];

    public function characteristics() {
        return $this->hasMany('App\Models\Characteristics','group_id','id')->orderBy('position');
    }

    public function leadAttr() {
        return $this->hasMany('App\Models\CharacteristicLead','group_id','id')->orderBy('position');
    }

    public function rules() {
        return $this->hasMany('App\Models\CharacteristicRules','group_id','id');
    }

    public function statuses() {
        return $this->hasMany('App\Models\CharacteristicStatuses','group_id','id')->orderBy('position');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($group) { // before delete() method call
            $group->characteristics()->delete();
            $group->leadAttr()->delete();
            $group->rules()->delete();
        });
    }
}