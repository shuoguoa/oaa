<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name')->comment('业务名称');
            $table->decimal('account_amount', 12, 4)->comment('到帐金额');
            $table->timestamp('account_time')->comment('到帐时间');
            $table->integer('account_id')->unsigned()->comment('到帐帐户');
            $table->string('material')->comment('素材');
            $table->string('price')->comment('结算价格');
            $table->string('mode')->commnet('结算方式');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->text('audit_msg')->nullable()->comment('审核信息');
            $table->integer('created_by')->unsigned()->comment('创建者');
            $table->integer('salesman')->unsigned()->comment('销售');
            $table->text('remark')->comment('备注');

            $table->timestamps();

            $table->unique('name');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('salesman')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business', function (Blueprint $table) {
            //
            Schema::disableForeignKeyConstraints();
            Schema::dropIfExists('business');
        });
    }
}
