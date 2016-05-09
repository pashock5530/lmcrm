<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SphereLead extends Model
{
    protected $table = 'sphere_leads';
    protected $fillable = ['_type', 'label','icon','required', 'position' ];

    public function options() {
        return $this->hasMany('App\Models\SphereAttrOptions','sphere_attr_id','id')->where('ctype','=','lead')->where('_type','=','option')->orderBy('position');
    }
    public function validators() {
        return $this->hasMany('App\Models\SphereAttrOptions','sphere_attr_id','id')->where('ctype','=','lead')->where('_type','=','validate')->orderBy('position');
    }

    public function sphere() {
        return $this->belongsTo('App\Models\Sphere','id','sphere_id');
    }

}