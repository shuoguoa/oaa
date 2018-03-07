<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('task_id')->commnet('任务ID');
            $table->integer('show')->default(0)->commnet('投放量');
            $table->date('stat_date')->comment('统计日期');

            $table->timestamps();
            $table->unique(['task_id', 'stat_date']);
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stat', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            Schema::dropIfExists('stat');
        });
    }
}
