<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacteristicRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristic_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');

            $table->integer('srange');
            $table->integer('erange');
            $table->string('rule'); //->integer('rule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('characteristics_rules');
    }
}
