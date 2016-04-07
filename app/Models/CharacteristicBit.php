<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CharacteristicBit extends Model
{
    protected $table = NULL;

    public $tableDB = NULL;

    public function __construct($id = NULL, array $attributes = array())
    {
        $this->table = 'bitmask_'.$id;
        DB::statement('CREATE TABLE IF NOT EXISTS `'.$this->table.'`(`id` INT NOT NULL AUTO_INCREMENT, `agent_id` BIGINT NOT NULL, `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`))',[]);
        $this->tableDB = DB::table($this->table);

        parent::__construct($attributes);

        return $this->table;
    }

    public function getTableName(){
        return $this->table;
    }

    public function attributes() {
        return DB::getSchemaBuilder()->getColumnListing($this->table);
    }

    public function addAttr($group_index,$opt_index){
        if(is_array($opt_index)) {
            foreach($opt_index as $aVal) $this->addAttr($group_index,$aVal);
        } else {
            $index = implode('_', ['fb', $group_index, $opt_index]);
            if (!in_array($index, $this->attributes())) {
                DB::statement('ALTER TABLE `' . $this->table . '` ADD COLUMN `' . $index . '` BIT(32) NOT NULL', []);
            }
        }
        return true;
    }

    public function removeAttr($group_index,$opt_index){
        if(is_array($group_index) && $opt_index==null) {
            foreach($group_index as $item) {
                $delAttr = preg_grep("/^fb_" . $item . "_.*/", $this->attributes());
                foreach($delAttr as $item) {
                    DB::statement('ALTER TABLE `' . $this->table . '` DROP COLUMN `' . $item . '', []);
                }
            }
        }
        if(is_array($opt_index)) {
            foreach($opt_index as $aVal) $this->removeAttr($group_index,$aVal);
        } else {
            $index = implode('_', ['fb', $group_index, $opt_index]);
            if (!in_array($index, $this->attributes())) {
                DB::statement('ALTER TABLE `' . $this->table . '` DROP COLUMN `' . $index . '', []);
            }
        }
        return true;
    }

    public function _delete() {
        return DB::delete('DROP TABLE `?`',[$this->table]);
    }

    public function getAppends() {

        return $this->hasOne();
    }
}