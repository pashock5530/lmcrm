<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicBit extends Model
{
    protected $table = NULL;

    public function __construct($table = 'not_found', array $attributes = array())
    {
        $this->table = $table;

        parent::__construct($attributes);
    }


}