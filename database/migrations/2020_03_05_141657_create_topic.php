<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 50); // 主題
            $table->tinyInteger('show_on')->default(1); // 開關
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('board_id');   
            
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->foreign('board_id')->references('id')->on('board'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic');
    }
}
