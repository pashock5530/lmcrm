<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credits extends Model {

    protected $table="credits";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id','real','virtual'
    ];

    public function agent(){
        return $this->belongsTo('App\Models\Agent', 'id', 'agent_id');
    }

    public function getBalanceAttribute(){
        return $this->attributes['real']+$this->attributes['virtual'];
    }

    public function setPaymentAttribute($value){
        if($this->attributes['real'] < $value) {
            $this->attributes['virtual'] -= ($value - $this->attributes['real']);
            $this->attributes['real'] = 0;
        } else {
            $this->attributes['real'] -= $value;
        }
    }
}
