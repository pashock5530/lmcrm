<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('password')->nullable();
            $table->text('permissions')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('name')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            //$table->unique(['agent_id','phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('leads');
    }
}
