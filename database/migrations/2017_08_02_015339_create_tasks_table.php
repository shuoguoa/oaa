<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            //
            $table->increments('id');

            $table->unsignedInteger('business_id')->comment('业务ID');
            $table->unsignedInteger('media_id')->comment('媒介ID');
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->unsignedInteger('throws')->comment('投放量');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->dateTime('exec_at')->nullable()->comment('执行时间');
            $table->text('plan')->comment('执行方案');

            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropForeign('tasks_business_id_foreign');
            $table->dropForeign('tasks_media_id_foreign');
            $table->dropIfExists('tasks');
        });
    }
}
