<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('subject', 50); // 主題
            $table->string('description'); // 描述
            $table->tinyInteger('show_on')->default(1); // 判別是否關閉
            $table->tinyInteger('board_type')->nullable()->default(null); // 分類
            $table->string('cover_img')->nullable()->default('no_picture'); // 圖
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board');
    }
}
