<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business', function (Blueprint $table) {
            //
            $table->dateTime('audit_time')->nullable()->after('audit_msg')->comment('审核时间');
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
            $table->dropColumn('audit_time');
        });
    }
}
