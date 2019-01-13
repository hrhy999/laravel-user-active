<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordUserActiveLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('record_user_active_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->timestamp('last_active_at')->index()->default(\DB::raw('CURRENT_TIMESTAMP')->comment('当天最后活跃时间');
            $table->timestamp('active_log_at')->index()->default(\DB::raw('CURRENT_TIMESTAMP')->comment('活跃记录事件');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('record_user_active_logs');
    }
}
