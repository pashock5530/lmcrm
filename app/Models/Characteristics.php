<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristics extends Model
{
    protected $table = 'characteristics';
    protected $fillable = ['_type', 'label','icon','required', 'position' ];

    public function options() {
        return $this->hasMany('App\Models\CharacteristicOptions','characteristic_id','id')->where('ctype','=','agent')->orderBy('position');
    }

    public function group() {
        return $this->belongsTo('App\Models\CharacteristicGroup','id','group_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($characteristic) { // before delete() method call
            $characteristic->options()->delete();
        });
    }
}