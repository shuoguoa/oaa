<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterModifyBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            $table->decimal('account_amount', 12, 4)->nullable()->comment('到帐金额')->change();
            $table->dateTime('account_time')->nullable()->comment('到帐时间')->change();
            $table->integer('account_id')->nullable()->unsigned()->comment('到帐帐户')->change();
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
        });
    }
}
