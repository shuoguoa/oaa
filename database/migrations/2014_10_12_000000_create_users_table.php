<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', '32');
            $table->string('email');
            $table->string('real_name', '32');
            $table->string('password');
            $table->tinyInteger('user_type')->default(2)->comment('用户类型，1：系统管理员，2：其它用户');
            $table->tinyInteger('status')->default(1)->comment('用户状态，1：正常，2：禁用');
            $table->text('remark')->nullable();
            $table->rememberToken();

            $table->timestamps();

            $table->unique('name');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
