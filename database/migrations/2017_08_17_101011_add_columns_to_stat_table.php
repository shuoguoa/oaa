<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stat', function (Blueprint $table) {
            $table->integer('click')->default(0)->comment('点击');
            $table->decimal('price', 10, 4)->default(0.00)->comment('单价');
            $table->decimal('cost')->default('0.00')->comment('消耗金额');
            $table->text('remark')->comment('备注');
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
            $table->dropColumn('click');
            $table->dropColumn('price');
            $table->dropColumn('cost');
            $table->dropColumn('remark');
        });
    }
}
